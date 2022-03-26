<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">{{ config('app.name', "e-Bidding") }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('/')) active @endif" href="{{ route('index') }}">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->is('/pages/about')) active @endif" href="/pages/about">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle @if(request()->is('/listings') || request()->is('/category/*')) active @endif" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Listings
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item @if(request()->is('/listings')) active @endif" href="/listings">
                        All Listings
                    </a>
                    <div class="dropdown-divider"></div>
                    @foreach(\App\Models\Category::all() as $_category)
                    <a class="dropdown-item" href="/category/{{ $_category->id }}">
                        {{ $_category->name }}
                    </a>
                    @endforeach
                </div>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link @if(request()->is('/create')) active @endif" href="{{ route('front.create') }}">
                    Add New Listing
                </a>
            </li>
            @endauth
        </ul>
        <form class="d-flex me-auto"  method="GET" action="/search">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search Listings..">
                <button class="btn btn-secondary" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                      </svg>
                </button>
            </div>
        </form>
        <div class="d-flex ms-auto mt-md-0 mt-3">
            @guest
            <a href="/login" class="btn btn-primary me-2">Login</a>
            <a href="/register" class="btn btn-success">Register</a>
            @else
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/profile">
                        Profile
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if(auth()->user()->role == "Admin")
                        <a class="dropdown-item" href="/admin">
                            Admin Dashboard
                        </a>
                        @endif
                        <a class="dropdown-item" href="/profile">
                            Profile
                        </a>
                        <a class="dropdown-item" href="/balance">
                            Balance: Rs. {{ auth()->user()->current_balance }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!" onclick="document.getElementById('logout-form').submit()">
                            Logout
                        </a>

                        <!-- Logout Form -->
                        <form id="logout-form" action="/logout" method="post">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endguest
        </div>
        </div>
    </div>
</nav>