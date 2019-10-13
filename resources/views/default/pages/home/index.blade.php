{{--
@extends('layouts.main')
@section('main-content')
    <p>{{ trans('word.hi') }}</p>
    <div>home page index</div>
@endsection
@push('footer')
    test111
@endpush
@section('body-class', 'testing')
@section('body-id', 'asdasd')
--}}
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
<div id="app">
    <page-login></page-login>
</div>
<script src="/js/app.js"></script>
