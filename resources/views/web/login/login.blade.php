<!DOCTYPE html>
<html lang="en">
@include('web.includes.login_header')
<body>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>

    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <img class="bg-img-cover bg-center"
                     src="{{ URL::asset('panel/assets/images/login/2.jpg') }}" alt="login page">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div class="text-center d-flex justify-content-center">
                            <a class="logo text-start">
                                <img class="img-fluid for-light"
                                     src="{{ URL::asset('panel/assets/images/logo/logo_dark.png') }}"
                                     width="170" alt="login page">
                            </a>
                        </div>
                        <div class="login-main">
                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success mb-4">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="theme-form">
                                @csrf

                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" name="email"
                                           value="superadmin@yopmail.com" required autofocus autocomplete="username"
                                           placeholder="you@example.com">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" required
                                               autocomplete="current-password" placeholder="********" value="password">
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-group mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                        <label class="form-check-label" for="remember_me">Remember me</label>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                </div>

                                <!-- Forgot Password -->
                                @if (Route::has('password.request'))
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                                    </div>
                                @endif

                                <!-- Register link -->
                                {{-- <p class="mt-4 mb-0 text-center">
                                    Don't have an account?
                                    <a class="ms-2" href="{{ route('register') }}">Create Account</a>
                                </p> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('web.includes.login_footer')
</body>
</html>
