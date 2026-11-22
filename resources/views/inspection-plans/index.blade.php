
@extends('layouts.app')

@section('title', 'Inspection Plans')
@section('heading', 'Inspection Plans')

@section('content')
<div class="actions" style="justify-content:space-between;margin-bottom:22px">
    <div>
        <h1>Inspection Plans</h1>
        <p class="muted">Create and manage your inspection schedules.</p>
    </div>

    <a class="btn" href="{{ route('inspection-plans.create') }}">
        + New Plan
    </a>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Inspection Type</th>
                    <th>Planned Date</th>
                    <th>Frequency</th>
                    <th>Inspections</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($plans as $plan)
                    <tr>
                        <td><strong>{{ $plan->title }}</strong></td>
                        <td>{{ $plan->type?->title ?? 'N/A' }}</td>
                        <td>{{ $plan->planned_date?->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($plan->frequency) }}</td>
                        <td>{{ $plan->inspections_count }}</td>
                        <td>
                            <span class="status">
                                {{ ucfirst($plan->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary"
                                   href="{{ route('inspection-plans.show', $plan) }}">
                                    View
                                </a>

                                <a class="btn btn-secondary"
                                   href="{{ route('inspection-plans.edit', $plan) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('inspection-plans.destroy', $plan) }}"
                                      onsubmit="return confirm('Delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            No inspection plans found. Create your first plan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        {{ $plans->links() }}
    </div>
</div>
@endsection
