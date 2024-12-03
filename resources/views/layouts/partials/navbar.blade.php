<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="{{ route('home') }}" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Language Dropdown -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-language"></i> {{ strtoupper(app()->getLocale()) }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                <a class="dropdown-item" href="{{ route('change.language', 'en') }}">English</a>
                <a class="dropdown-item" href="{{ route('change.language', 'ar') }}">العربية</a>
                <a class="dropdown-item" href="{{ route('change.language', 'es') }}">Español</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
