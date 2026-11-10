<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\JobTicket;
use App\Models\Opportunity;
use App\Models\Property;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use App\Services\InquiryWorkflowService;
use App\Services\ModuleManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleManager::class)->syncFromConfig();

        $users = [
            ['name' => 'Admin Demo', 'email' => 'admin@residentialproperleadpilot.test', 'role' => 'admin', 'phone' => '555-0100'],
            ['name' => 'Owner Demo', 'email' => 'owner@residentialproperleadpilot.test', 'role' => 'owner', 'phone' => '555-0101'],
            ['name' => 'Staff Demo', 'email' => 'staff@residentialproperleadpilot.test', 'role' => 'staff', 'phone' => '555-0102'],
            ['name' => 'Vendor Demo', 'email' => 'vendor@residentialproperleadpilot.test', 'role' => 'technician', 'phone' => '555-0103'],
            ['name' => 'Resident Demo', 'email' => 'resident@residentialproperleadpilot.test', 'role' => 'customer', 'phone' => '555-0104'],
        ];

        $created = [];
        foreach ($users as $user) {
            $created[$user['role']] = User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'phone' => $user['phone'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        $oakridge = Property::query()->updateOrCreate(
            ['code' => 'OAK-120'],
            [
                'name' => 'Oakridge Court Apartments',
                'address' => '1200 Oak Ridge Dr',
                'city' => 'Plano',
                'state' => 'TX',
                'zip' => '75024',
                'unit_count' => 148,
                'property_type' => 'multifamily',
                'status' => 'active',
                'notes' => 'Class B garden style; leasing office on-site',
            ]
        );

        $cedar = Property::query()->updateOrCreate(
            ['code' => 'CDR-88'],
            [
                'name' => 'Cedar Lane SFR Portfolio',
                'address' => '88 Cedar Lane',
                'city' => 'Frisco',
                'state' => 'TX',
                'zip' => '75034',
                'unit_count' => 24,
                'property_type' => 'sfr',
                'status' => 'active',
                'notes' => 'Scattered-site single-family rentals',
            ]
        );

        $vendorUser = $created['technician'];
        $vendor = Technician::query()->updateOrCreate(
            ['user_id' => $vendorUser->id],
            [
                'name' => 'North Texas Plumbing Pros',
                'license_number' => 'TX-PL-44821',
                'vendor_type' => 'plumbing',
                'specialties' => ['maintenance_emergency', 'maintenance_general'],
                'availability_status' => 'available',
                'service_area' => 'Dallas–Fort Worth',
                'phone' => '555-0103',
                'is_active' => true,
            ]
        );

        Technician::query()->updateOrCreate(
            ['license_number' => 'TX-HV-55210'],
            [
                'name' => 'Summit HVAC Vendors',
                'vendor_type' => 'hvac',
                'specialties' => ['maintenance_general', 'maintenance_emergency'],
                'availability_status' => 'on_job',
                'service_area' => 'Collin County',
                'phone' => '555-0118',
                'is_active' => true,
            ]
        );

        Customer::query()->updateOrCreate(
            ['email' => 'prospect@example.com'],
            [
                'name' => 'Jordan Prospect',
                'phone' => '555-2001',
                'address' => 'Nearby — touring Oakridge',
                'city' => 'Plano',
                'state' => 'TX',
                'zip' => '75024',
                'kind' => 'prospect',
                'property_id' => $oakridge->id,
                'notes' => 'Interested in 2BR; wants weekend tour',
            ]
        );

        Customer::query()->updateOrCreate(
            ['email' => 'resident@example.com'],
            [
                'name' => 'Alex Resident',
                'phone' => '555-2002',
                'address' => $oakridge->address,
                'city' => 'Plano',
                'state' => 'TX',
                'zip' => '75024',
                'kind' => 'resident',
                'property_id' => $oakridge->id,
                'unit_number' => '214B',
                'notes' => 'Current resident; preferred contact email',
            ]
        );

        if (Inquiry::query()->count() === 0) {
            $workflow = app(InquiryWorkflowService::class);
            $staff = $created['staff'];

            $samples = [
                [
                    'source' => 'website',
                    'contact_name' => 'Chris Martinez',
                    'contact_email' => 'chris.m@example.com',
                    'contact_phone' => '555-3001',
                    'subject' => 'Schedule a tour — 2 bedroom',
                    'service_interest' => 'Leasing tour',
                    'property_id' => $oakridge->id,
                    'body' => 'Looking to schedule a tour of a 2 bedroom unit at Oakridge Court this weekend. Phone 555-3001. Prefer pets-friendly floorplan.',
                    'consent_email' => true,
                    'consent_sms' => true,
                ],
                [
                    'source' => 'phone',
                    'contact_name' => 'Dana Lee',
                    'contact_email' => 'dana.lee@example.com',
                    'contact_phone' => '555-3002',
                    'subject' => 'Unit 214B — no water emergency',
                    'service_interest' => 'Maintenance emergency',
                    'property_id' => $oakridge->id,
                    'body' => 'Urgent: unit 214B has no water and a broken pipe under the sink. Need emergency maintenance ASAP.',
                    'consent_email' => true,
                    'consent_sms' => false,
                ],
                [
                    'source' => 'email',
                    'contact_name' => 'Sam Patel',
                    'contact_email' => 'sam.patel@example.com',
                    'contact_phone' => '555-3003',
                    'subject' => 'Owner inquiry — manage SFR portfolio',
                    'service_interest' => 'Owner management',
                    'property_id' => $cedar->id,
                    'body' => 'I need property management for my 24-home SFR portfolio in Frisco. Prefer a quote for full-service leasing and maintenance this week.',
                    'consent_email' => true,
                    'consent_sms' => false,
                ],
            ];

            foreach ($samples as $i => $sample) {
                $inquiry = $workflow->intake($sample, $staff);
                if ($i < 2) {
                    $workflow->approve($inquiry, $created['owner']);
                }
            }
        }

        $sr = ServiceRequest::query()->first();
        if ($sr) {
            JobTicket::query()->updateOrCreate(
                ['ticket_number' => 'WO-DEMO0001'],
                [
                    'service_request_id' => $sr->id,
                    'technician_id' => $vendor->id,
                    'property_id' => $sr->property_id ?? $oakridge->id,
                    'status' => 'dispatched',
                    'scheduled_start' => now()->addDay()->setTime(9, 0),
                    'scheduled_end' => now()->addDay()->setTime(12, 0),
                    'safety_checklist' => ['COI on file', 'Resident access confirmed', 'Water shutoff located'],
                ]
            );
        }

        if (Opportunity::query()->count() === 0) {
            Opportunity::query()->create([
                'title' => 'Demo leasing pipeline opportunity',
                'stage' => 'qualified',
                'value_estimate' => 1800,
                'probability' => 60,
                'status' => 'open',
                'owner_id' => $created['owner']->id,
            ]);
        }
    }
}
