
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel">
        <div class="actions" style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:20px;">
            <h1>Inspections</h1>
            <a href="{{ route('inspections.create') }}" class="btn">
                + New Inspection
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="color:#ff8b8b;margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plan</th>
                        <th>Inspector</th>
                        <th>Target</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inspections as $inspection)
                        <tr>
                            <td>{{ $inspection->id }}</td>
                            <td>{{ $inspection->plan?->title ?? 'N/A' }}</td>
                            <td>
                                {{ $inspection->inspector?->first_name ?? '' }}
                                {{ $inspection->inspector?->last_name ?? 'N/A' }}
                            </td>
                            <td>{{ $inspection->target_name ?? 'N/A' }}</td>
                            <td>{{ $inspection->inspection_date }}</td>
                            <td>{{ ucfirst($inspection->status) }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn" href="{{ route('inspections.show', $inspection) }}">View</a>
                                    <a class="btn" href="{{ route('inspections.edit', $inspection) }}">Edit</a>

                                    <form method="POST"
                                          action="{{ route('inspections.destroy', $inspection) }}"
                                          onsubmit="return confirm('Delete this inspection?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No inspections found. Create your first inspection.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $inspections->links() }}
        </div>
    </div>
</div>
@endsection
