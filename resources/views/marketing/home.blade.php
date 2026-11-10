@extends('layouts.marketing')

@section('title', 'ResidentialProperLeadPilot — AI Inbound Inquiry Triage CRM for Residential Property Managers')
@section('meta_description', 'Classify website, phone, and email inquiries into qualified CRM opportunities. AI triage, human approval, properties, residents, maintenance requests, and vendor work orders for residential property managers.')

@section('content')
<section class="wrap hero">
    <div>
        <p class="eyebrow">Residential property managers · Sales Operations</p>
        <h1>ResidentialProperLeadPilot</h1>
        <p class="lead">Classify website, phone, and email inquiries into qualified CRM opportunities — then operate on properties, residents, maintenance requests, and vendor work orders with AI assist and human approval.</p>
        <div class="cta-row">
            <a class="btn btn-accent" href="{{ route('demo') }}">Try live intake</a>
            <a class="btn btn-ghost" href="{{ url('/admin') }}">Open Filament admin</a>
            <a class="btn btn-ghost" href="{{ route('features') }}">Explore all features</a>
        </div>
    </div>
    <div class="panel">
        <small>Live triage snapshot</small>
        <div class="score">99</div>
        <p style="margin:0 0 1rem; opacity:.9">Opportunity score · Inbound Inquiry Triage MVP</p>
        <div class="grid" style="gap:.55rem">
            <div>1) Intake trigger → website / phone / email</div>
            <div>2) AI draft classification + follow-up</div>
            <div>3) Human approval gate</div>
            <div>4) CRM opportunity + audit log</div>
        </div>
    </div>
</section>

<section class="wrap section">
    <h2>Built for residential PM ops leads</h2>
    <p class="muted" style="max-width:46rem">Stop losing after-hours leasing forms and voicemail leads. ResidentialProperLeadPilot centralizes inbound demand, scores leasing vs maintenance urgency, flags fair-housing risks, and routes only approved work into your CRM and property stack.</p>
    <div class="grid grid-3" style="margin-top:1.25rem">
        <div class="card">
            <h3>Multi-channel intake</h3>
            <p class="muted">Website forms, phone notes, email forwards — one triage queue with consent flags.</p>
        </div>
        <div class="card">
            <h3>AI classify & score</h3>
            <p class="muted">Leasing tours, applications, emergencies, owner management — scored with draft follow-ups.</p>
        </div>
        <div class="card">
            <h3>Modular SaaS</h3>
            <p class="muted">Toggle CRM, vendors, AppFolio/Buildium hooks, attendance, and PDF exports per portfolio.</p>
        </div>
    </div>
</section>

<section class="wrap section">
    <h2>Core modules enabled for demo</h2>
    <div class="grid grid-2">
        @foreach(collect($modules)->where('enabled', true)->take(8) as $module)
            <div class="card">
                <span class="pill">ON</span>
                <h3 style="margin-top:.55rem">{{ $module['name'] }}</h3>
                <p class="muted">{{ $module['description'] }}</p>
            </div>
        @endforeach
    </div>
    <div class="cta-row">
        <a class="btn btn-primary" href="{{ route('modules') }}">View every module (on & off)</a>
    </div>
</section>
@endsection
