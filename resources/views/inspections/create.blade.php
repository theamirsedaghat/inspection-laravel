
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel">
        <h1>New Inspection</h1>

        @if($errors->any())
            <div style="color:#ff8b8b;margin-bottom:16px">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('inspections.store') }}" method="POST">
            @csrf
            @include('inspections._form', ['buttonText' => 'Create Inspection'])
        </form>
    </div>
</div>
@endsection
