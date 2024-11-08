<!-- HEADER -->
<header class="p-3 text-white bg-primary fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="mb-0 h5 fw-bold">HealthHub Connect</h1>
        <div>
            @if(auth()->check())
            <span>Hi, {{Auth::user()->firstName }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light" id="logoutButton">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            @endif
        </div>
    </div>
</header>
