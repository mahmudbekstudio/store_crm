@extends('errors::layout')

@section('title', __('error.503.title'))

@section('message')
    {!! __('error.503.message') !!}
@stop
