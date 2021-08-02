@extends('layouts.cnx')
@section('content')


    <script>
    window.fbAsyncInit = function() {
        FB.init({
        appId      : '395202121896561',
        xfbml      : true,
        version    : 'v7.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
<div class="wrapper">
        <div class="left">

        </div>
		<div class="rigth" >
			<div class="wrap-login100">

                <div class="login100-form-avatar">
                    <div>
                        <a href="{{ route('accueil')}}">
                            <img src="cnx/images/logo.png" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="title">
                    <span class="login100-form-title">
                        Trust Access
                    </span>
                </div>
                <div class="title">
                    <p>Jai déjà un compte? <a href="{{ route('login')}}">Connexion</a></p>
                </div>
                <div class="social-login">
                    <ul>
                        <li>
                            <a href="{{url('login/facebook')}}" title="" class="facebook social-link">
                                <div>
                                    <i class="fa fa-facebook"></i>
                                </div>
                                <div class="login-btn">
                                    <span>Facebook</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="login/google" title="" class="google social-link">
                                    <div>
                                        <img src="cnx/images/google.png" class="img-google"> 
                                    </div>
                                    <div class="login-btn">
                                        <span style="color: #8a8a8a;">Google</span>
                                    </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="display: flex;justify-content: center;">
                    <div class="divider">
                        <p>ou par email</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="wrap-input100">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="input100 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="wrap-input100">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="wrap-input100">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="wrap-input100">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="input100" name="password_confirmation" required autocomplete="new-password"></div>
                    </div>

                    <div class="submit-div">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
			</div>
		</div>
	</div>
@endsection


