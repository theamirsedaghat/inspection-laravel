
@extends('layouts.app')

@section('title', 'Edit Inspection Plan')
@section('heading', 'Edit Inspection Plan')

@section('content')
<div class="panel">
    <h1>Edit Inspection Plan</h1>
    <p class="muted">Update the schedule and status.</p>

    <form method="POST" action="{{ route('inspection-plans.update', $plan) }}">
        @csrf
        @method('PUT')
        @include('inspection-plans._form')
    </form>
</div>
@endsection
