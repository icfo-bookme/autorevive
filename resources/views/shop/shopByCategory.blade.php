@extends('layouts.master')

@section('content')

{{-- <div id="fullNav">
    @include('partials.navBar')
<div> --}}


@if (isset($anchor))
<input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
@endif

@if (isset($message))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>Thank You!</strong> {{$message}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div id="shopbyCatApp"></div>
<script src="{{ asset('react/app.js') }}"></script>

@endsection
{{-- @include('partials.footer') --}}
