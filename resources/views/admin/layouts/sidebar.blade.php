<!-- ========== Left Sidebar Start ========== -->
<style>
    body:not(.vertical-collpsed) #sidebar-menu ul li a {
        display: flex;
        align-items: center;
        padding: 0.58rem 2.15rem 0.58rem 1.35rem;
    }
    body:not(.vertical-collpsed) #sidebar-menu ul li a i {
        flex-shrink: 0;
        min-width: 1.75rem;
        padding-bottom: 0;
    }
    body:not(.vertical-collpsed) #sidebar-menu ul li a span {
        flex: 1 1 auto;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    body:not(.vertical-collpsed) #sidebar-menu .has-arrow:after {
        position: absolute;
        right: 1rem;
        top: 50%;
        margin-top: -0.55em;
        float: none;
        line-height: 1;
    }
    body:not(.vertical-collpsed) #sidebar-menu ul li ul.sub-menu li a {
        padding: 0.4rem 1.25rem 0.4rem 3.25rem;
    }
</style>
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!-- Sidebar Menu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Overview -->
                <li class="menu-title">Overview</li>
                <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="waves-effect {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" target="_blank" class="waves-effect">
                        <i class="bx bx-link-external"></i>
                        <span>View Website</span>
                    </a>
                </li>

                <!-- Tours & Package Categories -->
                @php
                    $tourModules = [
                        [
                            'route' => 'tour',
                            'label' => 'Tour Packages',
                            'view_label' => 'View Packages',
                            'add_label' => 'Add Package',
                            'icon' => 'bx-briefcase-alt-2',
                            'patterns' => ['tour.*'],
                            'view_perms' => ['view-tour', 'list-tour', 'create-tour', 'edit-tour', 'delete-tour'],
                            'create_perms' => ['create-tour'],
                        ],
                        [
                            'route' => 'state',
                            'label' => 'Regions (States)',
                            'view_label' => 'View Regions',
                            'add_label' => 'Add Region',
                            'icon' => 'bx-map-alt',
                            'patterns' => ['state.*'],
                            'view_perms' => ['view-state', 'list-state', 'create-state', 'edit-state', 'delete-state'],
                            'create_perms' => ['create-state'],
                        ],
                        [
                            'route' => 'country',
                            'label' => 'Domestic / Intl',
                            'view_label' => 'View Countries',
                            'add_label' => 'Add Country',
                            'icon' => 'bx-globe',
                            'patterns' => ['country.*'],
                            'view_perms' => ['view-country', 'list-country', 'create-country', 'edit-country', 'delete-country'],
                            'create_perms' => ['create-country'],
                        ],
                        [
                            'route' => 'tourcategory',
                            'label' => 'Tour Themes',
                            'view_label' => 'View Themes',
                            'add_label' => 'Add Theme',
                            'icon' => 'bx-tag',
                            'patterns' => ['tourcategory.*', 'subtourcategory.*'],
                            'view_perms' => ['view-tourcategory', 'list-tourcategory', 'create-tourcategory', 'edit-tourcategory', 'delete-tourcategory'],
                            'create_perms' => ['create-tourcategory'],
                        ],
                    ];
                @endphp
                <li class="menu-title">Tours &amp; Categories</li>
                @foreach($tourModules as $mod)
                    @canany($mod['view_perms'])
                    @php $isActive = request()->routeIs(...$mod['patterns']); @endphp
                    <li class="{{ $isActive ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect {{ $isActive ? 'mm-active' : '' }}" title="{{ $mod['label'] }}">
                            <i class="bx {{ $mod['icon'] }}"></i>
                            <span>{{ $mod['label'] }}</span>
                        </a>
                        <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}">
                            <li><a href="{{ route($mod['route'] . '.index') }}" class="{{ request()->routeIs($mod['route'] . '.index') ? 'active' : '' }}">{{ $mod['view_label'] }}</a></li>
                            @canany($mod['create_perms'])
                            <li><a href="{{ route($mod['route'] . '.create') }}" class="{{ request()->routeIs($mod['route'] . '.create') ? 'active' : '' }}">{{ $mod['add_label'] }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Destinations & Experiences -->
                @php
                    $destinationModules = [
                        [
                            'route' => 'destination',
                            'label' => 'Destinations',
                            'view_label' => 'View Destinations',
                            'add_label' => 'Add Destination',
                            'icon' => 'bx-map-pin',
                            'patterns' => ['destination.*'],
                            'view_perms' => ['view-destination', 'list-destination', 'create-destination', 'edit-destination', 'delete-destination'],
                            'create_perms' => ['create-destination'],
                        ],
                        [
                            'route' => 'destinationcategory',
                            'label' => 'Dest. Categories',
                            'view_label' => 'View Categories',
                            'add_label' => 'Add Category',
                            'icon' => 'bx-collection',
                            'patterns' => ['destinationcategory.*', 'subdestinationcategory.*'],
                            'view_perms' => ['view-destinationcategory', 'list-destinationcategory', 'create-destinationcategory', 'edit-destinationcategory', 'delete-destinationcategory'],
                            'create_perms' => ['create-destinationcategory'],
                        ],
                        [
                            'route' => 'activity',
                            'label' => 'Activities',
                            'view_label' => 'View Activities',
                            'add_label' => 'Add Activity',
                            'icon' => 'bx-compass',
                            'patterns' => ['activity.*'],
                            'view_perms' => ['view-activity', 'list-activity', 'create-activity', 'edit-activity', 'delete-activity'],
                            'create_perms' => ['create-activity'],
                        ],
                    ];
                @endphp
                <li class="menu-title">Destinations &amp; Activities</li>
                @foreach($destinationModules as $mod)
                    @canany($mod['view_perms'])
                    @php $isActive = request()->routeIs(...$mod['patterns']); @endphp
                    <li class="{{ $isActive ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect {{ $isActive ? 'mm-active' : '' }}" title="{{ $mod['label'] }}">
                            <i class="bx {{ $mod['icon'] }}"></i>
                            <span>{{ $mod['label'] }}</span>
                        </a>
                        <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}">
                            <li><a href="{{ route($mod['route'] . '.index') }}" class="{{ request()->routeIs($mod['route'] . '.index') ? 'active' : '' }}">{{ $mod['view_label'] }}</a></li>
                            @canany($mod['create_perms'])
                            <li><a href="{{ route($mod['route'] . '.create') }}" class="{{ request()->routeIs($mod['route'] . '.create') ? 'active' : '' }}">{{ $mod['add_label'] }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Stays, Cabs & Weddings -->
                @php
                    $bookingModules = [
                        [
                            'route' => 'hotel',
                            'label' => 'Hotels & Resorts',
                            'view_label' => 'View Hotels',
                            'add_label' => 'Add Hotel',
                            'icon' => 'bx-building-house',
                            'patterns' => ['hotel.*'],
                            'view_perms' => ['view-hotel', 'list-hotel', 'create-hotel', 'edit-hotel', 'delete-hotel'],
                            'create_perms' => ['create-hotel'],
                        ],
                        [
                            'route' => 'cab',
                            'label' => 'Cabs & Fleet',
                            'view_label' => 'View Cabs',
                            'add_label' => 'Add Cab',
                            'icon' => 'bx-car',
                            'patterns' => ['cab.*'],
                            'view_perms' => ['view-cab', 'list-cab', 'create-cab', 'edit-cab', 'delete-cab'],
                            'create_perms' => ['create-cab'],
                        ],
                        [
                            'route' => 'destinationwedding',
                            'label' => 'Weddings & Vendors',
                            'view_label' => 'View Listings',
                            'add_label' => 'Add Listing',
                            'icon' => 'bx-heart',
                            'patterns' => ['destinationwedding.*'],
                            'view_perms' => ['view-destinationwedding', 'list-destinationwedding', 'create-destinationwedding', 'edit-destinationwedding', 'delete-destinationwedding'],
                            'create_perms' => ['create-destinationwedding'],
                        ],
                        [
                            'route' => 'service',
                            'label' => 'Services',
                            'view_label' => 'View Services',
                            'add_label' => 'Add Service',
                            'icon' => 'bx-support',
                            'patterns' => ['service.*'],
                            'view_perms' => ['view-service', 'list-service', 'create-service', 'edit-service', 'delete-service'],
                            'create_perms' => ['create-service'],
                        ],
                    ];
                @endphp
                <li class="menu-title">Stays, Cabs &amp; Weddings</li>
                @foreach($bookingModules as $mod)
                    @canany($mod['view_perms'])
                    @php $isActive = request()->routeIs(...$mod['patterns']); @endphp
                    <li class="{{ $isActive ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect {{ $isActive ? 'mm-active' : '' }}" title="{{ $mod['label'] }}">
                            <i class="bx {{ $mod['icon'] }}"></i>
                            <span>{{ $mod['label'] }}</span>
                        </a>
                        <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}">
                            <li><a href="{{ route($mod['route'] . '.index') }}" class="{{ request()->routeIs($mod['route'] . '.index') ? 'active' : '' }}">{{ $mod['view_label'] }}</a></li>
                            @canany($mod['create_perms'])
                            <li><a href="{{ route($mod['route'] . '.create') }}" class="{{ request()->routeIs($mod['route'] . '.create') ? 'active' : '' }}">{{ $mod['add_label'] }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Homepage & Navigation -->
                @php
                    $homepageModules = [
                        [
                            'route' => 'slidericon',
                            'label' => 'Header Icons',
                            'view_label' => 'View Header Icons',
                            'add_label' => 'Add Header Icon',
                            'icon' => 'bx-grid-alt',
                            'patterns' => ['slidericon.*'],
                            'view_perms' => ['view-slidericon', 'list-slidericon', 'view-slider-icon', 'create-slider-icon', 'view-blog', 'create-blog'],
                            'create_perms' => ['create-slidericon', 'create-slider-icon', 'create-blog'],
                        ],
                        [
                            'route' => 'menu',
                            'label' => 'Menus',
                            'view_label' => 'View Menus',
                            'add_label' => 'Add Menu',
                            'icon' => 'bx-menu',
                            'patterns' => ['menu.*', 'submenu.*'],
                            'view_perms' => ['view-menu', 'list-menu', 'create-menu', 'edit-menu', 'delete-menu'],
                            'create_perms' => ['create-menu'],
                        ],
                        [
                            'route' => 'slider',
                            'label' => 'Hero Sliders',
                            'view_label' => 'View Sliders',
                            'add_label' => 'Add Slider',
                            'icon' => 'bx-images',
                            'patterns' => ['slider.*'],
                            'view_perms' => ['view-slider', 'list-slider', 'create-slider', 'edit-slider', 'delete-slider'],
                            'create_perms' => ['create-slider'],
                        ],
                        [
                            'route' => 'travel-bestie',
                            'label' => 'Why Choose Us',
                            'view_label' => 'View Reasons',
                            'add_label' => 'Add Reason',
                            'icon' => 'bx-badge-check',
                            'patterns' => ['travel-bestie.*'],
                            'view_perms' => ['view-travel-bestie', 'list-travel-bestie', 'view-blog', 'create-blog'],
                            'create_perms' => ['create-travel-bestie', 'create-slider-icon', 'create-blog'],
                        ],
                        [
                            'route' => 'youtube',
                            'label' => 'Video Reviews',
                            'view_label' => 'View Videos',
                            'add_label' => 'Add Video',
                            'icon' => 'bx-video',
                            'patterns' => ['youtube.*'],
                            'view_perms' => ['view-youtube', 'list-youtube', 'view-blog', 'create-blog'],
                            'create_perms' => ['create-youtube', 'create-blog'],
                        ],
                        [
                            'route' => 'testimonial',
                            'label' => 'Testimonials',
                            'view_label' => 'View Testimonials',
                            'add_label' => 'Add Testimonial',
                            'icon' => 'bx-message-square-dots',
                            'patterns' => ['testimonial.*'],
                            'view_perms' => ['view-testimonial', 'list-testimonial', 'create-testimonial', 'edit-testimonial', 'delete-testimonial'],
                            'create_perms' => ['create-testimonial'],
                        ],
                        [
                            'route' => 'partner',
                            'label' => 'Brand Partners',
                            'view_label' => 'View Partners',
                            'add_label' => 'Add Partner',
                            'icon' => 'bx-award',
                            'patterns' => ['partner.*'],
                            'view_perms' => ['view-partner', 'list-partner', 'create-partner', 'edit-partner', 'delete-partner'],
                            'create_perms' => ['create-partner'],
                        ],
                    ];
                @endphp
                <li class="menu-title">Homepage &amp; Menus</li>
                @foreach($homepageModules as $mod)
                    @canany($mod['view_perms'])
                    @php $isActive = request()->routeIs(...$mod['patterns']); @endphp
                    <li class="{{ $isActive ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect {{ $isActive ? 'mm-active' : '' }}" title="{{ $mod['label'] }}">
                            <i class="bx {{ $mod['icon'] }}"></i>
                            <span>{{ $mod['label'] }}</span>
                        </a>
                        <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}">
                            <li><a href="{{ route($mod['route'] . '.index') }}" class="{{ request()->routeIs($mod['route'] . '.index') ? 'active' : '' }}">{{ $mod['view_label'] }}</a></li>
                            @canany($mod['create_perms'])
                            <li><a href="{{ route($mod['route'] . '.create') }}" class="{{ request()->routeIs($mod['route'] . '.create') ? 'active' : '' }}">{{ $mod['add_label'] }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Pages, Blogs & Media -->
                @php
                    $contentModules = [
                        [
                            'route' => 'page',
                            'label' => 'Pages & Policies',
                            'view_label' => 'View Pages',
                            'add_label' => 'Add Page',
                            'icon' => 'bx-file',
                            'patterns' => ['page.*'],
                            'view_perms' => ['view-page', 'list-page', 'create-page', 'edit-page', 'delete-page'],
                            'create_perms' => ['create-page', 'create-blog'],
                        ],
                        [
                            'route' => 'blog',
                            'label' => 'Blogs & Insights',
                            'view_label' => 'View Blogs',
                            'add_label' => 'Add Blog',
                            'icon' => 'bx-news',
                            'patterns' => ['blog.*'],
                            'view_perms' => ['view-blog', 'list-blog', 'create-blog', 'edit-blog', 'delete-blog'],
                            'create_perms' => ['create-blog'],
                        ],
                        [
                            'route' => 'faq',
                            'label' => 'FAQs',
                            'view_label' => 'View FAQs',
                            'add_label' => 'Add FAQ',
                            'icon' => 'bx-help-circle',
                            'patterns' => ['faq.*'],
                            'view_perms' => ['view-faq', 'list-faq', 'create-faq', 'edit-faq', 'delete-faq'],
                            'create_perms' => ['create-faq'],
                        ],
                        [
                            'route' => 'gallery',
                            'label' => 'Gallery',
                            'view_label' => 'View Gallery',
                            'add_label' => 'Add Media',
                            'icon' => 'bx-photo-album',
                            'patterns' => ['gallery.*'],
                            'view_perms' => ['view-gallery', 'list-gallery', 'create-gallery', 'edit-gallery', 'delete-gallery'],
                            'create_perms' => ['create-gallery'],
                        ],
                        [
                            'route' => 'touristguide',
                            'label' => 'Tourist Guides',
                            'view_label' => 'View Guides',
                            'add_label' => 'Add Guide',
                            'icon' => 'bx-user-voice',
                            'patterns' => ['touristguide.*'],
                            'view_perms' => ['view-touristguide', 'list-touristguide', 'create-touristguide', 'edit-touristguide', 'delete-touristguide'],
                            'create_perms' => ['create-touristguide'],
                        ],
                    ];
                @endphp
                <li class="menu-title">Pages, Blogs &amp; Media</li>
                @foreach($contentModules as $mod)
                    @canany($mod['view_perms'])
                    @php $isActive = request()->routeIs(...$mod['patterns']); @endphp
                    <li class="{{ $isActive ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect {{ $isActive ? 'mm-active' : '' }}" title="{{ $mod['label'] }}">
                            <i class="bx {{ $mod['icon'] }}"></i>
                            <span>{{ $mod['label'] }}</span>
                        </a>
                        <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}">
                            <li><a href="{{ route($mod['route'] . '.index') }}" class="{{ request()->routeIs($mod['route'] . '.index') ? 'active' : '' }}">{{ $mod['view_label'] }}</a></li>
                            @canany($mod['create_perms'])
                            <li><a href="{{ route($mod['route'] . '.create') }}" class="{{ request()->routeIs($mod['route'] . '.create') ? 'active' : '' }}">{{ $mod['add_label'] }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
                @endforeach

                <!-- Enquiries & Leads -->
                @canany(['view-booking', 'edit-booking', 'delete-booking', 'view-contact', 'edit-contact', 'delete-contact'])
                <li class="menu-title">Enquiries &amp; Leads</li>
                @canany(['view-booking', 'edit-booking', 'delete-booking', 'edit-contact'])
                <li class="{{ request()->routeIs('global-booking.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('global-booking.index') }}" class="waves-effect {{ request()->routeIs('global-booking.*') ? 'active' : '' }}">
                        <i class="bx bx-calendar-check"></i>
                        <span>Booking Enquiries</span>
                    </a>
                </li>
                @endcanany
                @canany(['view-contact', 'edit-contact', 'delete-contact'])
                <li class="{{ request()->routeIs('admin.contact.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.contact.index') }}" class="waves-effect {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                        <i class="bx bx-envelope"></i>
                        <span>Contact Messages</span>
                    </a>
                </li>
                @endcanany
                @endcanany

                <!-- Access & Settings -->
                @if(auth()->user()->canany(['list-permission', 'create-permission', 'list-role', 'create-role', 'list-user', 'create-user', 'edit-setting', 'view-setting']))
                <li class="menu-title">Access &amp; Settings</li>

                @canany(['list-permission', 'create-permission', 'list-role', 'create-role'])
                @php $rolesActive = request()->routeIs('permissions.*', 'roles.*'); @endphp
                <li class="{{ $rolesActive ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect {{ $rolesActive ? 'mm-active' : '' }}">
                        <i class="bx bx-lock-alt"></i>
                        <span>Roles &amp; Permissions</span>
                    </a>
                    <ul class="sub-menu {{ $rolesActive ? 'mm-show' : '' }}" aria-expanded="{{ $rolesActive ? 'true' : 'false' }}">
                        @can('list-permission') <li><a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.index') ? 'active' : '' }}">View Permissions</a></li> @endcan
                        @can('create-permission') <li><a href="{{ route('permissions.create') }}" class="{{ request()->routeIs('permissions.create') ? 'active' : '' }}">Add Permission</a></li> @endcan
                        @can('list-role') <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">View Roles</a></li> @endcan
                        @can('create-role') <li><a href="{{ route('roles.create') }}" class="{{ request()->routeIs('roles.create') ? 'active' : '' }}">Add Role</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['list-user', 'create-user', 'edit-user', 'delete-user'])
                @php $usersActive = request()->routeIs('users.*'); @endphp
                <li class="{{ $usersActive ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect {{ $usersActive ? 'mm-active' : '' }}">
                        <i class="bx bx-user"></i>
                        <span>Manage Users</span>
                    </a>
                    <ul class="sub-menu {{ $usersActive ? 'mm-show' : '' }}" aria-expanded="{{ $usersActive ? 'true' : 'false' }}">
                        <li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') ? 'active' : '' }}">View Users</a></li>
                        @can('create-user') <li><a href="{{ route('users.create') }}" class="{{ request()->routeIs('users.create') ? 'active' : '' }}">Add User</a></li> @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['edit-setting', 'view-setting'])
                <li class="{{ request()->routeIs('setting.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('setting.edit', 1) }}" class="waves-effect {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                        <i class="bx bx-cog"></i>
                        <span>Site Settings</span>
                    </a>
                </li>
                @endcanany
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
