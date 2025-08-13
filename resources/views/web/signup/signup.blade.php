<!DOCTYPE html>
<html lang="en">
@include('web.includes.login_header')

<body>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur"
                    values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"
                    result="goo"></fecolormatrix>
            </filter>
        </svg>
    </div>

    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <img class="bg-img-cover bg-center"
                     src="{{ URL::asset('panel/assets/images/login/2.jpg') }}" alt="signup page">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div class="text-center d-flex justify-content-center">
                            <a class="logo text-start">
                                <img class="img-fluid for-light"
                                     src="{{ URL::asset('panel/assets/images/logo/logo_dark.png') }}"
                                     width="170" alt="signup page">
                            </a>
                        </div>
                        <div class="login-main">
                            @if (session('status'))
                                <div class="alert alert-success mb-4">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.signup.complete', $invite->token) }}">
                                @csrf

                                <h4>Create Admin Account</h4>
                                <p>Set your details to activate your account</p>

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-form-label">Full Name</label>
                                    <input class="form-control" type="text" name="name"
                                           value="{{ old('name') }}" required autofocus placeholder="John Doe">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label class="col-form-label">Phone Number</label>
                                    <input class="form-control" type="text" name="phone"
                                           value="{{ old('phone') }}" required placeholder="+1234567890">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email (readonly from invite) -->
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" name="email"
                                           value="{{ $invite->email ?? old('email') }}" readonly>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control password-field" type="password" name="password" required
                                               placeholder="********">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control password-field" type="password" name="password_confirmation" required
                                               placeholder="********">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                </div><br><br>

                                <!-- Submit -->
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Complete Signup</button>
                                </div>

                                <!-- Back to login -->
                                <p class="mt-4 mb-0 text-center">
                                    Already have an account?
                                    <a class="ms-2" href="{{ route('login') }}">Sign In</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('web.includes.login_footer')

    <script>
        document.querySelectorAll('.show-hide').forEach(toggle => {
            toggle.addEventListener('click', () => {
                let input = toggle.parentElement.querySelector('.password-field');
                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.querySelector('span').classList.add('hide');
                } else {
                    input.type = 'password';
                    toggle.querySelector('span').classList.remove('hide');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            // Block typing
            emailInput.addEventListener('keydown', function (e) {
                e.preventDefault();
            });
            // Block paste
            emailInput.addEventListener('paste', function (e) {
                e.preventDefault();
            });
        }
    });
    </script>
</body>
</html>
