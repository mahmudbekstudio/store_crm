@extends('errors::layout')

@section('title', __('error.500.title'))

@section('message')
    {!! __('error.500.message') !!}
@stop
