@extends('errors::layout')

@section('title', __('error.404.title'))

@section('message')
    {!! __('error.404.message') !!}
@stop
