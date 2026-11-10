<?php

namespace App\Services;

use App\Models\AiClassification;
use App\Models\FollowUpDraft;
use App\Models\Inquiry;

/**
 * Local equivalent of imrandevbd/laravel-ai-hub classification for residential property managers.
 * Rule + heuristic engine ships offline; swap provider via AI Hub module.
 */
class AiTriageService
{
    public function __construct(
        protected ModuleManager $modules,
        protected AuditLogger $audit,
    ) {}

    public function classify(Inquiry $inquiry): Inquiry
    {
        if (! $this->modules->enabled('ai_classification')) {
            $inquiry->update(['status' => 'pending_approval']);

            return $inquiry->fresh();
        }

        $text = strtolower(($inquiry->subject ?? '').' '.$inquiry->body.' '.$inquiry->service_interest);
        $category = $this->detectCategory($text);
        $priority = $this->detectPriority($text, $category);
        $score = $this->score($text, $category, $priority);
        $tags = $this->tags($text, $category);
        $fairHousing = $this->modules->enabled('fair_housing_guardrails') && $this->detectFairHousingRisk($text);
        $summary = sprintf(
            'AI triage: %s inquiry scored %d/100 as %s priority for %s%s.',
            $inquiry->source,
            $score,
            $priority,
            $category,
            $fairHousing ? ' — fair-housing review required' : ''
        );

        $response = [
            'category' => $category,
            'priority' => $priority,
            'score' => $score,
            'tags' => $tags,
            'summary' => $summary,
            'qualified' => $score >= 55,
            'fair_housing_flag' => $fairHousing,
        ];

        AiClassification::query()->create([
            'inquiry_id' => $inquiry->id,
            'provider' => $this->modules->enabled('ai_hub') ? 'ai-hub-local' : 'local-rules',
            'model' => 'resi-pm-triage-v1',
            'prompt' => substr($inquiry->body, 0, 2000),
            'response' => $response,
            'confidence' => min(95, 50 + (int) floor($score / 3)),
        ]);

        $inquiry->update([
            'ai_category' => $category,
            'ai_priority' => $priority,
            'ai_score' => $score,
            'ai_summary' => $summary,
            'ai_tags' => $tags,
            'fair_housing_flag' => $fairHousing,
            'status' => $this->modules->enabled('human_approval_workflow') ? 'pending_approval' : 'classified',
            'classified_at' => now(),
        ]);

        $this->audit->log('inquiry.classified', Inquiry::class, $inquiry->id, null, $response);

        if ($this->modules->enabled('follow_up_drafts')) {
            $this->draftFollowUp($inquiry->fresh());
        }

        return $inquiry->fresh();
    }

    protected function detectCategory(string $text): string
    {
        $map = [
            'leasing_tour' => ['tour', 'showing', 'view apartment', 'see the unit', 'schedule a visit', 'open house'],
            'lease_application' => ['apply', 'application', 'rental application', 'screening', 'credit check', 'move in'],
            'availability' => ['available', 'vacancy', 'vacancies', 'units open', 'when can i move', 'floorplan', 'floor plan'],
            'rent_pricing' => ['rent price', 'monthly rent', 'how much is rent', 'pricing', 'specials', 'concession'],
            'maintenance_emergency' => ['flood', 'no heat', 'no water', 'gas leak', 'smoke', 'emergency', 'broken pipe', 'sewage'],
            'maintenance_general' => ['maintenance', 'work order', 'fix', 'leak', 'ac not', 'pest', 'appliance', 'clog'],
            'owner_management' => ['property management', 'manage my property', 'owner inquiry', 'landlord', 'portfolio'],
            'vendor_bid' => ['vendor', 'contractor bid', 'proposal for', 'trade partner'],
            'resident_notice' => ['notice to vacate', 'move out', 'lease renewal', 'renewal', 'transfer unit'],
        ];

        foreach ($map as $category => $needles) {
            foreach ($needles as $needle) {
                if (str_contains($text, $needle)) {
                    return $category;
                }
            }
        }

        return 'general_inquiry';
    }

    protected function detectPriority(string $text, string $category): string
    {
        if ($category === 'maintenance_emergency' || str_contains($text, 'asap') || str_contains($text, 'urgent')) {
            return 'urgent';
        }

        if (in_array($category, ['lease_application', 'leasing_tour', 'owner_management'], true) || str_contains($text, 'this week')) {
            return 'high';
        }

        if (in_array($category, ['maintenance_general', 'rent_pricing', 'availability'], true)) {
            return 'high';
        }

        return 'normal';
    }

    protected function score(string $text, string $category, string $priority): int
    {
        $score = 45;

        if (strlen($text) > 80) {
            $score += 10;
        }

        if (preg_match('/\d{3}[-.\s]?\d{3}[-.\s]?\d{4}/', $text)) {
            $score += 8;
        }

        $score += match ($priority) {
            'urgent' => 25,
            'high' => 15,
            default => 5,
        };

        $score += match ($category) {
            'lease_application', 'leasing_tour', 'owner_management', 'maintenance_emergency' => 12,
            'availability', 'rent_pricing', 'maintenance_general' => 8,
            default => 3,
        };

        return max(10, min(99, $score));
    }

    protected function tags(string $text, string $category): array
    {
        $tags = [$category];

        if (str_contains($text, 'pet') || str_contains($text, 'dog') || str_contains($text, 'cat')) {
            $tags[] = 'pets';
        }
        if (str_contains($text, 'furnished')) {
            $tags[] = 'furnished';
        }
        if (str_contains($text, 'corporate') || str_contains($text, 'relocation')) {
            $tags[] = 'corporate';
        }
        if (str_contains($text, 'section 8') || str_contains($text, 'housing voucher')) {
            $tags[] = 'voucher';
        }
        if (str_contains($text, 'owner') || str_contains($text, 'investor')) {
            $tags[] = 'owner';
        }

        return array_values(array_unique($tags));
    }

    protected function detectFairHousingRisk(string $text): bool
    {
        $risks = [
            'no kids', 'no children', 'adults only', 'no disabled', 'christians only',
            'prefer young', 'no wheelchair', 'english speakers only', 'no section 8',
        ];

        foreach ($risks as $risk) {
            if (str_contains($text, $risk)) {
                return true;
            }
        }

        return false;
    }

    protected function draftFollowUp(Inquiry $inquiry): void
    {
        $channel = $inquiry->consent_email ? 'email' : ($inquiry->consent_sms ? 'sms' : 'email');
        $guard = $inquiry->fair_housing_flag
            ? " Our fair-housing desk will review messaging before any reply is sent."
            : '';

        FollowUpDraft::query()->create([
            'inquiry_id' => $inquiry->id,
            'channel' => $channel,
            'subject' => 'Re: '.($inquiry->subject ?: 'Your property management inquiry'),
            'body' => "Hi {$inquiry->contact_name},\n\nThanks for contacting our residential property management team about {$inquiry->ai_category}. ".
                "We reviewed your {$inquiry->source} inquiry (ref {$inquiry->reference}) and classified it as {$inquiry->ai_priority} priority. ".
                "A leasing or operations specialist will follow up to confirm property details and next steps.{$guard}\n\n— ResidentialProperLeadPilot Desk",
            'status' => 'pending_approval',
        ]);
    }
}
