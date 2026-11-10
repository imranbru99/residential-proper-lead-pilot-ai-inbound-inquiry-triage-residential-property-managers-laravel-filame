<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\JobTicket;
use App\Models\Opportunity;
use App\Models\ServiceRequest;
use App\Services\ModuleManager;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TriageStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $modules = app(ModuleManager::class);

        return [
            Stat::make('Pending Approval', Inquiry::query()->where('status', 'pending_approval')->count())
                ->description('AI-classified leads awaiting human review')
                ->color('warning'),
            Stat::make('Open Opportunities', $modules->enabled('crm_opportunities')
                ? Opportunity::query()->where('status', 'open')->count()
                : 0)
                ->description('Qualified CRM pipeline')
                ->color('success'),
            Stat::make('Maintenance Requests', $modules->enabled('service_requests')
                ? ServiceRequest::query()->whereIn('status', ['intake', 'scheduled', 'in_progress'])->count()
                : 0)
                ->description('Active resident work'),
            Stat::make('Open Work Orders', $modules->enabled('job_tickets')
                ? JobTicket::query()->whereIn('status', ['draft', 'dispatched', 'on_site'])->count()
                : 0)
                ->description('Vendor dispatch'),
        ];
    }
}
