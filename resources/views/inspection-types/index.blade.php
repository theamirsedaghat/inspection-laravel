@extends('layouts.app')

@section('title', 'Inspection Types')
@section('heading', 'Inspection Types')

@section('content')
<div class="actions" style="justify-content:space-between;margin-bottom:22px">
    <div>
        <h1>Inspection Types</h1>
        <p class="muted">Manage the categories used for inspections.</p>
    </div>
    <a class="btn" href="{{ route('inspection-types.create') }}">+ New Type</a>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Plans</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <td><strong>{{ $type->title }}</strong></td>
                        <td>{{ $type->description ?: '—' }}</td>
                        <td>{{ $type->plans_count }}</td>
                        <td>
                            <span class="status">
                                {{ $type->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary"
                                   href="{{ route('inspection-types.edit', $type) }}">Edit</a>

                                <form method="POST"
                                      action="{{ route('inspection-types.destroy', $type) }}"
                                      onsubmit="return confirm('Delete this inspection type?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No inspection types found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">{{ $types->links() }}</div>
</div>
@endsection
