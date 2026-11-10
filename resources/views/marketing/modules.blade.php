@extends('layouts.marketing')

@section('title', 'Modules — ResidentialProperLeadPilot Toggleable Features')

@section('content')
<section class="wrap section">
    <p class="eyebrow">Modular platform</p>
    <h1>Turn modules on or off per portfolio</h1>
    <p class="lead">Core triage stays on. Niche integrations and portals stay off until your property management company needs them.</p>
    <div class="grid grid-2" style="margin-top:1.5rem">
        @foreach($modules as $module)
            <div class="card">
                <span class="pill {{ $module['enabled'] ? '' : 'off' }}">{{ $module['enabled'] ? 'ON' : 'OFF' }}</span>
                <h3 style="margin-top:.55rem">{{ $module['name'] }}</h3>
                <p class="muted">{{ $module['description'] }}</p>
                <p class="muted" style="font-size:.85rem;margin-top:.4rem">Category: {{ $module['category'] }} · key: {{ $module['key'] ?? '' }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
