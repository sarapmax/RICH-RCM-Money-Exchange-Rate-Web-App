@extends('layouts.master')

@section('content')
<div id="app">
    <exchange-rate-listing guest="{{ Auth::guest() }}"></exchange-rate-listing>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ mix('css/pages/home.css') }}">
@endsection

@section('scripts')
<script src="{{ mix('js/pages/home.js') }}"></script>
@endsection
