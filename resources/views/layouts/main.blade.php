@extends('layouts.app')

@section('content')
    @auth
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth

    @auth
    <header-site url="{{ url('/') }}" :user_id="{{Auth::user()->id}}"></header-site>
    
    @else
    <header url="{{ url('/') }}"></header>
    @endauth
        <loader></loader>
        <navigation></navigation>
        <div class="main-panel">
            <div class="content">
                
                    <router-view></router-view>

            </div>
        </div>


    
@endsection


@section('script')
    <script type="text/javascript" src="{{ mix('/js/app.js')}}"></script>
@endsection
