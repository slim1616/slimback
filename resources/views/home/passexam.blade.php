@extends('home.app')

@section('content')
@include('home.header')
    <div id="app" style="display: flex;justify-content: center;">
        <single-front :enquete_id="{{$enquete_id}}"></single-front>
    </div>

    <script src="{{asset('js/front.js')}}"></script>
@endsection

@section('script')
@endsection
