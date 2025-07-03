<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Modulos</div>
                <a class="nav-link" href="{{ route('categories.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                    Categorias
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            Start Bootstrap
        </div>
    </nav>
</div>
