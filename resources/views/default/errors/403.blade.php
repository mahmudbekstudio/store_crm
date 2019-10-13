@extends('errors::layout')

@section('title', __('error.403.title'))

@section('message')
    {!! __('error.403.message') !!}
@stop
