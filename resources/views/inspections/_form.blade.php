
<div style="margin-bottom:16px">
    <label>Inspection Plan</label>
    <select name="inspection_plan_id" required>
        <option value="">Select a plan</option>
        @foreach($plans as $planOption)
            <option value="{{ $planOption->id }}"
                @selected(old('inspection_plan_id', $inspection->inspection_plan_id) == $planOption->id)>
                {{ $planOption->title }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom:16px">
    <label>Inspector</label>
    <select name="inspector_id" required>
        <option value="">Select an inspector</option>
        @foreach($inspectors as $inspectorOption)
            <option value="{{ $inspectorOption->id }}"
                @selected(old('inspector_id', $inspection->inspector_id) == $inspectorOption->id)>
                {{ $inspectorOption->first_name }} {{ $inspectorOption->last_name }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom:16px">
    <label>Target Name</label>
    <input type="text" name="target_name"
        value="{{ old('target_name', $inspection->target_name) }}">
</div>

<div style="margin-bottom:16px">
    <label>Target Type</label>
    <input type="text" name="target_type"
        value="{{ old('target_type', $inspection->target_type) }}">
</div>

<div style="margin-bottom:16px">
    <label>External Target ID</label>
    <input type="number" name="target_external_id" min="1"
        value="{{ old('target_external_id', $inspection->target_external_id) }}">
</div>

<div style="margin-bottom:16px">
    <label>Inspection Date</label>
    <input type="datetime-local" name="inspection_date" required
        value="{{ old('inspection_date', $inspection->inspection_date ? \Carbon\Carbon::parse($inspection->inspection_date)->format('Y-m-d\TH:i') : '') }}">
</div>

<div style="margin-bottom:16px">
    <label>Status</label>
    <select name="status" required>
        @foreach(['scheduled', 'in_progress', 'completed', 'cancelled'] as $status)
            <option value="{{ $status }}"
                @selected(old('status', $inspection->status ?? 'scheduled') === $status)>
                {{ ucfirst(str_replace('_', ' ', $status)) }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom:16px">
    <label>Result / Notes</label>
    <textarea name="result" rows="4">{{ old('result', $inspection->result) }}</textarea>
</div>

<button type="submit" class="btn">{{ $buttonText }}</button>
<a href="{{ route('inspections.index') }}" class="btn">Cancel</a>
