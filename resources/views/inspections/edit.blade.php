
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel">
        <h1>Edit Inspection #{{ $inspection->id }}</h1>

        @if($errors->any())
            <div style="color:#ff8b8b;margin-bottom:16px">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('inspections.update', $inspection) }}" method="POST">
            @csrf
            @method('PUT')
            @include('inspections._form', ['buttonText' => 'Save Changes'])
        </form>
    </div>
</div>
@endsection
