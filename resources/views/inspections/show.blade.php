
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel">
        <div class="actions" style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:20px">
            <h1>Inspection #{{ $inspection->id }}</h1>
            <div class="actions">
                <a class="btn" href="{{ route('inspections.edit', $inspection) }}">Edit Inspection</a>
                <a class="btn" href="{{ route('inspections.index') }}">Back</a>
            </div>
        </div>

        @if(session('success'))
            <p style="color:#6ee7b7">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <div style="color:#ff8b8b">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <h2>Inspection Details</h2>
        <div class="table-wrap">
            <table>
                <tbody>
                    <tr><th>Plan</th><td>{{ $inspection->plan?->title ?? 'N/A' }}</td></tr>
                    <tr><th>Inspection Type</th><td>{{ $inspection->plan?->type?->title ?? 'N/A' }}</td></tr>
                    <tr><th>Inspector</th><td>{{ $inspection->inspector?->first_name }} {{ $inspection->inspector?->last_name }}</td></tr>
                    <tr><th>Target</th><td>{{ $inspection->target_name ?? 'N/A' }}</td></tr>
                    <tr><th>Target Type</th><td>{{ $inspection->target_type ?? 'N/A' }}</td></tr>
                    <tr><th>Inspection Date</th><td>{{ $inspection->inspection_date }}</td></tr>
                    <tr><th>Status</th><td>{{ ucfirst(str_replace('_', ' ', $inspection->status)) }}</td></tr>
                    <tr><th>Result / Notes</th><td>{{ $inspection->result ?? 'N/A' }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel" style="margin-top:24px">
        <h2>Inspection Items</h2>

        @forelse($inspection->items as $item)
            <div style="border:1px solid #333;padding:16px;margin:12px 0;border-radius:8px">
                <form method="POST" action="{{ route('inspection-items.update', $item) }}">
                    @csrf
                    @method('PUT')

                    <p><strong>Item #{{ $item->id }}</strong></p>

                    <label>Title</label>
                    <input name="item_title" value="{{ $item->item_title }}" required>

                    <label>Result</label>
                    <select name="result" required>
                        @foreach(['pending', 'pass', 'fail', 'not_applicable'] as $result)
                            <option value="{{ $result }}" @selected($item->result === $result)>
                                {{ ucfirst(str_replace('_', ' ', $result)) }}
                            </option>
                        @endforeach
                    </select>

                    <label>Notes</label>
                    <textarea name="notes" rows="2">{{ $item->notes }}</textarea>

                    <button class="btn" type="submit">Update Item</button>
                </form>

                <form method="POST"
                      action="{{ route('inspection-items.destroy', $item) }}"
                      onsubmit="return confirm('Delete this item?')"
                      style="margin-top:10px">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit">Delete Item</button>
                </form>
            </div>
        @empty
            <p>No inspection items yet.</p>
        @endforelse

        <h3>Add Inspection Item</h3>
        <form method="POST" action="{{ route('inspections.items.store', $inspection) }}">
            @csrf

            <label>Item Title</label>
            <input name="item_title" required maxlength="255">

            <label>Result</label>
            <select name="result" required>
                <option value="pending">Pending</option>
                <option value="pass">Pass</option>
                <option value="fail">Fail</option>
                <option value="not_applicable">Not applicable</option>
            </select>

            <label>Notes</label>
            <textarea name="notes" rows="3"></textarea>

            <button class="btn" type="submit">Add Item</button>
        </form>
    </div>

    <div class="panel" style="margin-top:24px">
        <h2>Findings</h2>

        @forelse($inspection->findings as $finding)
            <div style="border:1px solid #333;padding:16px;margin:12px 0;border-radius:8px">
                <form method="POST" action="{{ route('findings.update', $finding) }}">
                    @csrf
                    @method('PUT')

                    <p><strong>Finding #{{ $finding->id }}</strong></p>

                    <label>Description</label>
                    <textarea name="finding_description" rows="3" required>{{ $finding->finding_description }}</textarea>

                    <label>Severity</label>
                    <select name="severity" required>
                        @foreach(['low', 'medium', 'high', 'critical'] as $severity)
                            <option value="{{ $severity }}" @selected($finding->severity === $severity)>
                                {{ ucfirst($severity) }}
                            </option>
                        @endforeach
                    </select>

                    <label>Follow-up Status</label>
                    <select name="follow_up_status" required>
                        @foreach(['open', 'in_progress', 'resolved'] as $followUp)
                            <option value="{{ $followUp }}" @selected($finding->follow_up_status === $followUp)>
                                {{ ucfirst(str_replace('_', ' ', $followUp)) }}
                            </option>
                        @endforeach
                    </select>

                    <label>Correction Deadline</label>
                    <input type="date" name="correction_deadline"
                           value="{{ $finding->correction_deadline ? \Carbon\Carbon::parse($finding->correction_deadline)->format('Y-m-d') : '' }}">

                    <button class="btn" type="submit">Update Finding</button>
                </form>

                <form method="POST"
                      action="{{ route('findings.destroy', $finding) }}"
                      onsubmit="return confirm('Delete this finding?')"
                      style="margin-top:10px">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit">Delete Finding</button>
                </form>
            </div>
        @empty
            <p>No findings recorded.</p>
        @endforelse

        <h3>Add Finding</h3>
        <form method="POST" action="{{ route('inspections.findings.store', $inspection) }}">
            @csrf

            <label>Description</label>
            <textarea name="finding_description" rows="3" required></textarea>

            <label>Severity</label>
            <select name="severity" required>
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>

            <label>Follow-up Status</label>
            <select name="follow_up_status" required>
                <option value="open">Open</option>
                <option value="in_progress">In progress</option>
                <option value="resolved">Resolved</option>
            </select>

            <label>Correction Deadline</label>
            <input type="date" name="correction_deadline">

            <button class="btn" type="submit">Add Finding</button>
        </form>
    </div>
</div>
@endsection
