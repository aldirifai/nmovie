<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->is('movie') ? 'active' : '' }}">
                    <a class="nav-link" href="movie">Movie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
