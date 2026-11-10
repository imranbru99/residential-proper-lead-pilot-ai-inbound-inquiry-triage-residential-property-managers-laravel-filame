@extends('layouts.marketing')

@section('title', 'Features — ResidentialProperLeadPilot AI Triage CRM')

@section('content')
<section class="wrap section">
    <p class="eyebrow">Product capabilities</p>
    <h1>Everything you need to triage PM leads</h1>
    <p class="lead">From first inquiry to dispatched vendor work order — with fair-housing guardrails and modular integrations.</p>

    <div class="grid grid-2" style="margin-top:1.5rem">
        <div class="card"><h3>Inbound Inquiry Triage</h3><p class="muted">Unified queue for website, phone, email, SMS, and referral leads with reference IDs.</p></div>
        <div class="card"><h3>AI Classification Hub</h3><p class="muted">Detect leasing tours, applications, availability, rent pricing, maintenance emergencies, owner management, and renewals.</p></div>
        <div class="card"><h3>Human Approval Workflow</h3><p class="muted">Staff/owner gate before CRM conversion — MVP: intake → draft → approve → audit.</p></div>
        <div class="card"><h3>CRM Opportunities</h3><p class="muted">Qualified leasing / management pipeline with value estimates, probability, stages, and owners.</p></div>
        <div class="card"><h3>Properties & Residents</h3><p class="muted">Operate on multifamily and SFR portfolios with prospects, residents, and unit links.</p></div>
        <div class="card"><h3>Maintenance & Vendors</h3><p class="muted">Maintenance requests, licensed vendors, work-order dispatch, and compliance checklists.</p></div>
        <div class="card"><h3>Consent-aware follow-ups</h3><p class="muted">Email/SMS consent flags + AI draft replies awaiting approval.</p></div>
        <div class="card"><h3>Fair housing & audit</h3><p class="muted">Risk flags plus immutable logs for classify/approve/reject — tenant privacy aware.</p></div>
        <div class="card"><h3>Multi-role users</h3><p class="muted">Admin, owner, staff, vendor, resident demo roles with Filament access control.</p></div>
        <div class="card"><h3>Integration-ready</h3><p class="muted">Toggle modules for AppFolio, Buildium, email inbox, and accounting sync.</p></div>
    </div>
</section>
@endsection
