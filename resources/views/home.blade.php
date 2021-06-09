@extends('layouts.app')

@section('content')
@auth
<form id="logout-form" action="/logout" method="POST" style="display: none;">
    @csrf
</form>
@endauth

@auth
<header-site url="{{ url('/') }}" :user_id="{{Auth::user()->id}}"></header-site>
    <chat-box url="{{ url('/') }}"></chat-box>
@else
<header url="{{ url('/') }}"></header>
@endauth
    <main>
    <router-view></router-view>
    </main>
    
    
@endsection


@section('script')
    <script type="text/javascript" src="{{ mix('/js/app.js')}}"></script>
@endsection
