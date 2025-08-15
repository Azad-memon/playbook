<div class="container">
    <header id="main_header">
        <a href="" class="logo"><img src="{{ URL::asset('frontend/assets/img/CompanyLogo.png') }}"
                alt=""></a>
        <nav>
            <ul class="navigaiton">
                <li><a href="">Home</a></li>
                <li><a href="">Jobs</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Services</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </nav>

        <div class="right_side">
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle logbutton" type="button" id="userMenu"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ ucwords(Auth::user()->name) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userMenu">
                        <li>
                            {{-- <a class="dropdown-item text-primary fw-semibold"
                                href="{{ Auth::user()->user_type == 0 ? route('superadmin.dashboard') : '#' }}">
                                Dashboard
                            </a> --}}
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger signoutbutton">Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary logbutton">Sign In</a>
            @endauth
        </div>


    </header>
</div>
