@extends('layouts.app')

@section('title', 'Edit Inspection Type')
@section('heading', 'Edit Inspection Type')

@section('content')
<div class="panel">
    <h1>Edit Type</h1>

    <form method="POST" action="{{ route('inspection-types.update', $type) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="field full">
                <label for="title">Title</label>
                <input id="title" name="title" value="{{ old('title', $type->title) }}"
                       required maxlength="255">
            </div>

            <div class="field full">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $type->description) }}</textarea>
            </div>

            <div class="field full">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                           style="width:auto"
                           @checked(old('is_active', $type->is_active))>
                    Active
                </label>
            </div>
        </div>

        <div class="actions" style="margin-top:22px">
            <button class="btn" type="submit">Save Changes</button>
            <a class="btn btn-secondary" href="{{ route('inspection-types.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
