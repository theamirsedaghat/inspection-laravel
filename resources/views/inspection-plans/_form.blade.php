
<div class="form-grid">
    <div class="field full">
        <label for="title">Plan Title</label>
        <input id="title" name="title" type="text"
               value="{{ old('title', $plan->title) }}"
               placeholder="e.g. Monthly Equipment Inspection" required>
        @error('title') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="inspection_type_id">Inspection Type</label>
        <select id="inspection_type_id" name="inspection_type_id" required>
            <option value="">Select a type</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}"
                    @selected((string) old('inspection_type_id', $plan->inspection_type_id) === (string) $type->id)>
                    {{ $type->title }}
                </option>
            @endforeach
        </select>
        @error('inspection_type_id') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="planned_date">Planned Date</label>
        <input id="planned_date" name="planned_date" type="date"
               value="{{ old('planned_date', $plan->planned_date?->format('Y-m-d')) }}"
               required>
        @error('planned_date') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="frequency">Frequency</label>
        <select id="frequency" name="frequency" required>
            @foreach (['weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly'] as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('frequency', $plan->frequency ?? 'monthly') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('frequency') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="end_date">End Date (Optional)</label>
        <input id="end_date" name="end_date" type="date"
               value="{{ old('end_date', $plan->end_date?->format('Y-m-d')) }}">
        @error('end_date') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            @foreach (['draft' => 'Draft', 'active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('status', $plan->status ?? 'draft') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status') <span class="error">{{ $message }}</span> @enderror
    </div>
</div>

<div class="actions" style="margin-top:24px">
    <button class="btn" type="submit">Save Plan</button>
    <a class="btn btn-secondary" href="{{ route('inspection-plans.index') }}">
        Cancel
    </a>
</div>
