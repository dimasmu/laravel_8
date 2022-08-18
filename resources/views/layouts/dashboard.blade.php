<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.css')
    <title>{{$title}} | anime list</title>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="/">
                    <span class="align-middle">Anime Kit</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        System
                    </li>
                    <li class="sidebar-item {{Request::is('system/standard-field') ? 'active' : ''}}">
                        <a class="sidebar-link" href="{{ route('system.index')}}">
                            <i class="fa-solid fa-gear"></i> <span class="align-middle">Standard field</span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Movie Section
                    </li>
                    <li class="sidebar-item {{Request::is('movie') ? 'active' : ''}}">
                        <a class="sidebar-link" href="{{ route('movie')}}">
                            <i class="fa-solid fa-clapperboard"></i> <span class="align-middle">Movie</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="layout"></i> <span class="align-middle">Pages</span>
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-settings.html">Settings</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-projects.html">Projects <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-clients.html">Clients <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-pricing.html">Pricing <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-chat.html">Chat <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-blank.html">Blank Page</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown"
                                data-bs-toggle="dropdown"></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                @yield('content')
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="#" target="_blank"><strong>Database Anime</strong></a>
                                &copy;
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('layouts.js')
    @yield('javascript')
</body>

</html>
