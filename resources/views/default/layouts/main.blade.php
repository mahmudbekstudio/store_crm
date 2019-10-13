@extends('layouts.blank')

@section('content')
    <div>test</div>
    <div class="main-content">@yield('main-content')</div>
@endsection

@prepend('footer')
    test222
@endprepend
