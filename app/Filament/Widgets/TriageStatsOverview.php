<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\JobTicket;
use App\Models\Opportunity;
use App\Models\ServiceRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TriageStatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Pending Approval', Inquiry::query()->where('status', 'pending_approval')->count())
                ->description('AI-classified leads awaiting human review')
                ->color('warning')
                ->key('pending-approval'),
            Stat::make('Open Opportunities', Opportunity::query()->where('status', 'open')->count())
                ->description('Qualified CRM pipeline')
                ->color('success')
                ->key('open-opportunities'),
            Stat::make('Maintenance Requests', ServiceRequest::query()->whereIn('status', ['intake', 'scheduled', 'in_progress'])->count())
                ->description('Active resident work')
                ->key('maintenance-requests'),
            Stat::make('Open Work Orders', JobTicket::query()->whereIn('status', ['draft', 'dispatched', 'on_site'])->count())
                ->description('Vendor dispatch')
                ->key('open-work-orders'),
        ];
    }
}
