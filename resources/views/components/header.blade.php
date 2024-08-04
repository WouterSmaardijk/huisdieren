<header>
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <h1 class="title is-4 has-text-white">Huisdieren</h1>
            </a>
        </div>
        <div id="navbar" class="navbar-menu">
            <div class="navbar-start">
                <a role="button" class="navbar-item {{ Request::is('/') ? 'has-text-white is-active' : '' }}" href="/">
                    Home
                </a>
                <a class="navbar-item {{ Request::is('create') ? 'has-text-white is-active' : '' }}" href="/create">
                    Nieuw huisdier
                </a>
            </div>
        </div>
    </nav>
</header>