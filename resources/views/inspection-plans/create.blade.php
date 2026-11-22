
@extends('layouts.app')

@section('title', 'Create Inspection Plan')
@section('heading', 'Create Inspection Plan')

@section('content')
<div class="panel">
    <h1>New Inspection Plan</h1>
    <p class="muted">Configure the schedule and inspection type.</p>

    <form method="POST" action="{{ route('inspection-plans.store') }}">
        @csrf
        @include('inspection-plans._form')
    </form>
</div>
@endsection
