<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!-- Sidebar Menu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Dashboard -->
                <li class="menu-title">Dashboard</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Management -->
                @if(auth()->user()->can('list-permission') || auth()->user()->can('list-role') || auth()->user()->can('list-user'))
                <li class="menu-title">User Management</li>

                @if(auth()->user()->can('list-permission') || auth()->user()->can('list-role'))
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-lock-alt"></i>
                        <span>Roles & Permissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('list-permission') <li><a href="{{ route('permissions.index') }}">View Permissions</a></li> @endcan
                        @can('create-permission') <li><a href="{{ route('permissions.create') }}">Add Permission</a></li> @endcan
                        @can('list-role') <li><a href="{{ route('roles.index') }}">View Roles</a></li> @endcan
                        @can('create-role') <li><a href="{{ route('roles.create') }}">Add Role</a></li> @endcan
                    </ul>
                </li>
                @endif

                @if(auth()->user()->can('list-user'))
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Manage Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">View Users</a></li>
                        @can('create-user') <li><a href="{{ route('users.create') }}">Add User</a></li> @endcan
                    </ul>
                </li>
                @endif
                @endif

                <!-- Website Content -->
                <li class="menu-title">Website Management</li>

                @canany(['list-slider'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-images"></i>
                        <span>Sliders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('slider.index') }}">View Sliders</a></li>
                        @can('create-slider') <li><a href="{{ route('slider.create') }}">Add Slider</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-menu'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-menu"></i>
                        <span>Menus</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('menu.index') }}">View Menus</a></li>
                        @can('create-menu') <li><a href="{{ route('menu.create') }}">Add Menu</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-gallery'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-photo-album"></i>
                        <span>Gallery</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('gallery.index') }}">View Gallery</a></li>
                        @can('create-gallery') <li><a href="{{ route('gallery.create') }}">Add Image</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-blog'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bxl-blogger"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('blog.index') }}">View Blogs</a></li>
                        @can('create-blog') <li><a href="{{ route('blog.create') }}">Add Blog</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-faq'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-help-circle"></i>
                        <span>FAQs</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('faq.index') }}">View FAQs</a></li>
                        @can('create-faq') <li><a href="{{ route('faq.create') }}">Add FAQ</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-page'])
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Pages</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('page.index') }}">View Pages</a></li>
                        @can('create-page') <li><a href="{{ route('page.create') }}">Add Page</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                <!-- Travel Modules -->
                <li class="menu-title">Travel Modules</li>

                @foreach([
                    'cab' => 'Cab',
                    'hotel' => 'Hotel',
                    'state' => 'State',
                    'destinationwedding' => 'Destination Wedding',
                    'tourcategory' => 'Tour Category',
                    'tour' => 'Tour',
                    'destinationcategory' => 'Destination Category',
                    'destination' => 'Destination',
                    'service' => 'Service',
                    'touristguide' => 'Tourist Guide',
                    'testimonial' => 'Testimonial',
                    'activity' => 'Activity',
                    'partner' => 'Partner',
                    'youtube' => 'YouTube Slides',
                    'slidericon' => 'Slider Icon Section',
                    'travel-bestie' => 'Travel Bestie Section',
                ] as $key => $label)
                    @canany(["list-$key"])
                    <li>
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span>{{ $label }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{ route($key.'.index') }}">View {{ $label }}</a></li>
                            @can("create-$key") <li><a href="{{ route($key.'.create') }}">Add {{ $label }}</a></li> @endcan
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Settings -->
                @can('edit-contact')
                <li class="menu-title">Contact</li>
                <li>
                    <a href="{{ route('global-booking.index') }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Contact</span>
                    </a>
                </li>
                @endcan

                <!-- Settings -->
                @can('edit-setting')
                <li class="menu-title">System</li>
                <li>
                    <a href="{{ route('setting.edit', 1) }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
