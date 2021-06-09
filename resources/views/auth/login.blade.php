@extends('layouts.cnx')

@section('content')

<div class="limiter">
		<div class="container-login100" style="background-image: url('cnx/images/isc.jpeg');">
			<div class="wrap-login100 p-b-30">

                <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
                        @csrf
					<div class="login100-form-avatar">
                        <div>
                            <img src="cnx/images/logo.png" alt="AVATAR">
                        </div>
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Trust Access
                    </span>
                    @if(Session::get('errors')||count( $errors ) > 0)
                        @foreach ($errors->all() as $error)
                            <p style="color: #ff5151;margin: 15px auto;">{{ $error }}</p>
                        @endforeach
                    @endif
					<div class="wrap-input100 validate-input m-b-10" data-validate = "email obligatoire">
                        <input class="input100" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">                        
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Mot de passe obligatoire">
						<input class="input100"  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn">
							Login
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
