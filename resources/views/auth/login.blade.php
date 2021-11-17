<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title',"cytonTickets") Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="POST" action="{{ route('login') }}">
					@csrf
					<span class="login100-form-title p-b-51">
						Login
					</span>

					
					<div class="wrap-input100 validate-input m-b-16">
						<input id="email" class="input100 @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16">
						<input id="password" class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="current-password">
						<span class="focus-input100"></span>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="cb100">
							<input class="form-check-input cbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

							<label class="form-check-label" for="remember">
								{{ __('Remember Me') }}
							</label>
						</div>

						<div>
							@if (Route::has('password.request'))
								<a class=" txt1" href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							@endif
						</div>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div>
							@if (Route::has('register'))
								<a class=" txt1" href="{{ route('register') }}">
									Don't have an account?
								</a>
							@endif
						</div>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" type="submit">
							{{ __('Login') }}
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	


</body>
</html>