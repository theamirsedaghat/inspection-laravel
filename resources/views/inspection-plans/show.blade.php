
@extends('layouts.app')

@section('title', 'Inspection Plan Details')
@section('heading', 'Inspection Plan Details')

@section('content')
<div class="panel">
    <div class="actions" style="justify-content:space-between">
        <div>
            <h1>{{ $plan->title }}</h1>
            <p class="muted">{{ $plan->type?->title ?? 'No inspection type' }}</p>
        </div>

        <a class="btn" href="{{ route('inspection-plans.edit', $plan) }}">
            Edit Plan
        </a>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="muted">Planned Date</div>
            <div class="stat-value" style="font-size:20px">
                {{ $plan->planned_date?->format('Y-m-d') }}
            </div>
        </div>

        <div class="stat">
            <div class="muted">Frequency</div>
            <div class="stat-value" style="font-size:20px">
                {{ ucfirst($plan->frequency) }}
            </div>
        </div>

        <div class="stat">
            <div class="muted">Status</div>
            <div class="stat-value" style="font-size:20px">
                {{ ucfirst($plan->status) }}
            </div>
        </div>

        <div class="stat">
            <div class="muted">Inspections</div>
            <div class="stat-value" style="font-size:20px">
                {{ $plan->inspections->count() }}
            </div>
        </div>
    </div>

    <h2>Related Inspections</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Target</th>
                    <th>Inspector</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plan->inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->target_name ?? 'N/A' }}</td>
                        <td>
                            {{ $inspection->inspector?->first_name ?? '' }}
                            {{ $inspection->inspector?->last_name ?? '' }}
                        </td>
                        <td>{{ $inspection->inspection_date?->format('Y-m-d H:i') }}</td>
                        <td>{{ ucfirst($inspection->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No inspections linked to this plan yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        <a class="btn btn-secondary" href="{{ route('inspection-plans.index') }}">
            Back to Plans
        </a>
    </div>
</div>
@endsection
