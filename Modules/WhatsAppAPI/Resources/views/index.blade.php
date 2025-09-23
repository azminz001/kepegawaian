@extends('whatsappapi::layouts.master')

@section('content')
    <h1>Hello World</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif
    <p>
        This view is loaded from module: {!! config('whatsappapi.name') !!}
    </p>
    <form id="kirimForm" action="{{ route('sendBirthdayMessages') }}" method="POST">
        @csrf
    </form>
    <script>
        window.onload = function() {
            document.getElementById('kirimForm').submit();
        };
    </script>
@endsection
