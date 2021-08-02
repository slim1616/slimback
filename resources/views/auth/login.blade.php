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
                    <p>Pas encore de compte? <a href="{{ route('register')}}">Créer</a></p>
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
                <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
                        @csrf
                    
                    @if(Session::get('errors')||count( $errors ) > 0)
                        @foreach ($errors->all() as $error)
                            <p style="color: #ff5151;margin: 15px auto;">{{ $error }}</p>
                        @endforeach
                    @endif
					<div class="wrap-input100" data-validate = "email obligatoire">
                            <label>Email</label>
                            <input class="input100" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">                        
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

					<div class="wrap-input100" data-validate = "Mot de passe obligatoire">
                        <label>Mot de passe</label>
						<input class="input100"  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

					<div class="submit-div">
						<button class="login100-form-btn">
							Connexion
						</button>
					</div>

					<div class="text-center w-full p-t-25">
						<a href="{{ route('password.request') }}" class="txt1">
							Mot de passe / email oublié?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
