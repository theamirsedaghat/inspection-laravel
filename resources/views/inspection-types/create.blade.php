@extends('layouts.app')

@section('title', 'Create Inspection Type')
@section('heading', 'Create Inspection Type')

@section('content')
<div class="panel">
    <h1>New Inspection Type</h1>
    <p class="muted">Create a category for inspection plans.</p>

    <form method="POST" action="{{ route('inspection-types.store') }}">
        @csrf

        <div class="form-grid">
            <div class="field full">
                <label for="title">Title</label>
                <input id="title" name="title" value="{{ old('title') }}"
                       required maxlength="255" placeholder="e.g. Safety Inspection">
            </div>

            <div class="field full">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          placeholder="Describe the inspection category">{{ old('description') }}</textarea>
            </div>

            <div class="field full">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                           style="width:auto"
                           @checked(old('is_active', true))>
                    Active
                </label>
            </div>
        </div>
        <div class="actions" style="margin-top:22px">
            <button class="btn" type="submit">Create Type</button>
            <a class="btn btn-secondary" href="{{ route('inspection-types.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
