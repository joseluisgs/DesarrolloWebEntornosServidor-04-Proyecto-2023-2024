<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('index') }}">
            <img alt="Logo" class="d-inline-block align-text-top" height="30"
                 src="{{ asset('images/favicon.png') }}" width="30">
            Mis productos CRUD 2º DAW
        </a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler"
                data-target="#navbarNav" data-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route ('home')  }}" class="nav-link">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        @endauth
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.create') }}">Nuevo producto</a>
                </li>
                <!-- Otras opciones de menú -->
            </ul>
            <ul class="navbar-nav ml-auto"> <!-- Agregamos esta línea -->
                <li class="nav-item">
                    <span class="navbar-text">
                        {{ auth()->user()->role ?? 'invitado/a' }}
                    </span>
                </li>
            </ul>
        </div>
    </nav>
</header>
