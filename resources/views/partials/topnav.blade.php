<nav class="navbar navbar-expand-lg navbar-light p-1" id="topnav">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Team Selector -->
        <div class="dropdown mr-4 d-none d-lg-flex mt-1">
            <a class="dropdown-toggle" href="#" role="button" id="teamSelector" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Rugged Networks Limited
            </a>

            <div class="dropdown-menu" aria-labelledby="teamSelector">
                <h6 class="dropdown-header">Change Team</h6>
                <span class="dropdown-item disabled">Rugged Networks Limited</span>
                <a class="dropdown-item" href="#">Swanmoor Team</a>
            </div>
        </div>

        <!-- User -->
        <div class="navbar-user mt-1">

            <!-- Notifications Dropdown -->
            <div class="dropdown mr-4 d-none d-lg-flex">

                <!-- Bell Icon -->
                <a href="#" class="text-muted mt-1" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="icon active">
                        <i class="fe fe-bell"></i>
                    </span>
                </a>

                <!-- Notification Holder -->
                {{--
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">

                                <h5 class="card-header-title">
                                    Notifications
                                </h5>

                            </div>
                            <div class="col-auto">

                                <a href="#!" class="small">
                                    View all
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- List group -->
                        <div class="list-group list-group-flush my-n3">
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-1.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Dianna Smiley</strong> shared your post with
                                            <strong class="text-body">Ab Hadley</strong>, <strong
                                                class="text-body">Adolfo Hess</strong>, and <strong class="text-body">3
                                                others</strong>.
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-2.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Ab Hadley</strong> reacted to your post with a 😍
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-3.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Adolfo Hess</strong> commented <blockquote
                                                class="text-body">“I don’t think this really makes sense to do without
                                                approval from Johnathan since he’s the one...” </blockquote>
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-4.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Daniela Dewitt</strong> subscribed to you.
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-5.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Miyah Myles</strong> shared your post with <strong
                                                class="text-body">Ryu Duke</strong>, <strong class="text-body">Glen
                                                Rouse</strong>, and <strong class="text-body">3 others</strong>.
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-6.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Ryu Duke</strong> reacted to your post with a 😍
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-7.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Glen Rouse</strong> commented <blockquote
                                                class="text-body">“I don’t think this really makes sense to do without
                                                approval from Johnathan since he’s the one...” </blockquote>
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                            <a class="list-group-item px-0" href="#!">

                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('assets/img/avatars/profiles/avatar-8.jpg') }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        </div>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Content -->
                                        <div class="small text-muted">
                                            <strong class="text-body">Grace Gross</strong> subscribed to you.
                                        </div>

                                    </div>
                                    <div class="col-auto">

                                        <small class="text-muted">
                                            2m
                                        </small>

                                    </div>
                                </div> <!-- / .row -->

                            </a>
                        </div>

                    </div>
                </div>
                --}}

            </div>

            <!-- User Profile Settings -->
            <div class="dropdown">

                <!-- Avatar -->
                <a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('assets/img/avatars/profiles/avatar-1.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </a>

                <!-- Profile Menu -->
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="profile-posts.html" class="dropdown-item">Billing</a>
                    <a href="settings.html" class="dropdown-item">Team Settings</a>
                    <hr class="dropdown-divider">
                    <a href="sign-in.html" class="dropdown-item">Profile</a>
                    <a href="sign-in.html" class="dropdown-item">Logout</a>
                </div>

            </div>

        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse mr-auto order-lg-first" id="navbar">

            <!-- Team Selector -->
            <div class="dropdown mt-4 mb-3 d-md-none">
                <a class="dropdown-toggle" href="#" role="button" id="teamSelector" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Rugged Networks Limited
                </a>

                <div class="dropdown-menu" aria-labelledby="teamSelector">
                    <h6 class="dropdown-header">Change Team</h6>
                    <span class="dropdown-item disabled">Rugged Networks Limited</span>
                    <a class="dropdown-item" href="#">Swanmoor Team</a>
                </div>
            </div>

            <!-- Brand -->
            <a class="navbar-brand mr-4" href="index.html">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="..." style="width: 140px; height: 40px; margin-bottom: 5px">
            </a>

            <!-- Navigation -->
            <ul class="navbar-nav mr-auto mt-1">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @@if(category=='dashboards'){active}" href="#"
                        id="topnavDashboards" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Live
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="topnavDashboards">
                        <li>
                            <a class="dropdown-item" href="index.html">
                                View All
                            </a>
                        </li>
                        <li>
                            <h6 class="dropdown-header">Sites</h6>
                        </li>

                        <li>
                            <a class="dropdown-item" href="index.html">
                                Location 1
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="index.html">
                                Location 2
                            </a>
                        </li>
                        <li>
                            <h6 class="dropdown-header">Global Views</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-alt.html">
                                Driveway
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-alt.html">
                                Gatehouse
                            </a>
                        </li>
                        <li>
                            <h6 class="dropdown-header">Personal Views</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-alt.html">
                                My View
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="topnavPages" role="button">
                        Settings
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" !" href="#" id="topnavDocumentation" role="button">
                        Help
                    </a>
                </li>

            </ul>

        </div>

    </div> <!-- / .container -->
</nav>
