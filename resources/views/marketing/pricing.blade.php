@extends('layouts.marketing')

@section('title', 'Pricing — ResidentialProperLeadPilot Pilot Plans')

@section('content')
<section class="wrap section">
    <p class="eyebrow">Pricing hypothesis</p>
    <h1>Pilot $199–$799 / month</h1>
    <p class="lead">Start with inbound triage for one portfolio. Expand modules as leasing volume and vendor dispatch grow.</p>
    <div class="grid grid-3" style="margin-top:1.5rem">
        <div class="card">
            <h3>Starter · $199</h3>
            <p class="muted">Inbound triage, AI classify, human approval, audit log for a single property group.</p>
        </div>
        <div class="card">
            <h3>Growth · $449</h3>
            <p class="muted">CRM opportunities, maintenance requests, vendors, fair-housing guardrails, follow-up drafts.</p>
        </div>
        <div class="card">
            <h3>Portfolio · $799</h3>
            <p class="muted">Multi-property routing, AppFolio/Buildium hooks, PDF exports, attendance hub options.</p>
        </div>
    </div>
</section>
@endsection
