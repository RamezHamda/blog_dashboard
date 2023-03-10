    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.index')}}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>

            {{-- Name Of Site with two ways --}}

            {{-- <div class="sidebar-brand-text mx-3">{{env("APP_NAME")}}</div> --}}
            <div class="sidebar-brand-text mx-3">

            @php
                $sitename = config("app.name");
                $namearr = explode(" ", $sitename);
                $namearr[1] = '<span style="color:red">'. $namearr[1] .'</span>';
                $sitename = implode(' ', $namearr );

            @endphp

                {!!  $sitename !!}

            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.index')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file"></i>
                <span>Posts</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('admin.posts.index')}}">All Posts</a>
                    <a class="collapse-item" href="{{route('admin.posts.create')}}">Add Post</a>
                    <a class="collapse-item" href="{{route('admin.posts.trash')}}">Trashed Posts</a>
                </div>
            </div>

              <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" href="{{}}">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span></a>
        </li>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
