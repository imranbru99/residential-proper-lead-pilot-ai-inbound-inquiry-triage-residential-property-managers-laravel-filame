@extends('layouts.marketing')

@section('title', 'Workflow — ResidentialProperLeadPilot MVP')

@section('content')
<section class="wrap section">
    <p class="eyebrow">MVP scope</p>
    <h1>1 intake → draft/action → human approval → audit log</h1>
    <p class="lead">Designed for residential property managers who need fair-housing-aware sales operations without losing after-hours leads.</p>
    <div class="grid grid-2" style="margin-top:1.5rem">
        <div class="card"><h3>1. Intake trigger</h3><p class="muted">Website form, phone note, or email body lands in the inquiry queue with consent flags and optional property link.</p></div>
        <div class="card"><h3>2. AI draft / action</h3><p class="muted">Local AI Hub rules classify category, priority, score, tags, fair-housing risk, and draft a follow-up.</p></div>
        <div class="card"><h3>3. Human approval</h3><p class="muted">Owner or staff approve → CRM opportunity (+ maintenance request when urgency is maintenance).</p></div>
        <div class="card"><h3>4. Audit log</h3><p class="muted">Every classify, approve, reject, and convert is recorded for compliance and tenant privacy reviews.</p></div>
    </div>
</section>
@endsection
