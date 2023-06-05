<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="logo">
            <a class="nav-link" aria-current="page" href="{{ route('home') }}">
                <img src="{{ url('assets/img/logo-branca.png') }}" height="30" width="130">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon">&#9776;</span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            @if (auth()->user() && auth()->user()->role !== 'seller' || auth()->guest())
                <ul class="navbar-nav mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Tecnology
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('product', ['smartphones']) }}">Smartphones</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('product', ['laptops']) }}">Laptops</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Beauty
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('product', ['fragrances']) }}">Fragrances</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('product', ['skincare']) }}">SkinCare</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Groceries
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('product', ['groceries']) }}">Ingredients</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Home Decoration
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('product', ['home-decoration']) }}">Itens</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>

        @if (auth()->check() && (auth()->user()->role === 'seller' && Auth::user()->seller->status === 'approved'))
            <a class="btn btn-primary" href="{{ route('product.create') }}" role="button">Cadastrar Novo Produto</a>
        @endif

        @if (auth()->check() &&
                (auth()->user()->role === 'admin' ||
                    (auth()->user()->role === 'seller' && Auth::user()->seller->status === 'approved') ||
                    auth()->user()->role === 'client'))
            <button class="openbtn" onclick="openNav()"><i class="bi bi-person"></i></button>
        @endif

        @guest
            <a class="btn btn-primary" href="{{ route('login') }}" role="button">Login</a>
        @endguest

        <form id="logout" action="{{ route('logout') }}" method="GET">
            @csrf
            <a href="{{ route('logout') }}">
                <i style="color:white" class="bi bi-box-arrow-right"></i>
            </a>
        </form>

    </div>
</nav>



<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginRight = "250px";
    }
</script>
