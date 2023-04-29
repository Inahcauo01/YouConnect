<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 fixed top-O w-100 nav-all">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('feed') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}

            </div>

            {{-- search --}}
            {{-- <div class="d-flex align-items-center">
                <input type="text" class="rounded-start" placeholder="Recherche" class="w-50">
                <button class="d-flex align-items-center border-none border-secondary px-1" type="button" id="button-addon2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>  --}}

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-dropdown>
                        
                    </div>
                    
                @endif
                <a href="{{ route('users_chat')}}">
                    <svg fill="#0000000" width="22px" height="22px" viewBox="0 0 24 24" id="chat-left-3" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="secondary" d="M21,8V19a1,1,0,0,1-1,1H17" style="fill: none; stroke: #0a91ff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M3,5V15a1,1,0,0,0,1,1H8l5,3V16h3a1,1,0,0,0,1-1V5a1,1,0,0,0-1-1H4A1,1,0,0,0,3,5Z" style="fill: none; stroke: #363535; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></g></svg>
                </a>
                    {{-- notifications --}}
                <div class="dropdown">
                    <button type="button" class="m-2 position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="icon" id="bell"><i class="fa-regular fa-bell"></i></div>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread messages</span>
                        @endif
                        </span>
                    </button>
                    <ul class="dropdown-menu" style="width: 25rem">
                        <div class="notification-heading d-flex justify-content-between align-items-center px-2">
                            <p class="menu-title ">Notifications ({{ auth()->user()->unreadNotifications->count() }})</p>
                            <a class="btn btn-sm" href="{{ route('posts.markCommeLu') }}">marquer comme lu</a>
                        </div>
                        <hr class="m-auto w-75 mt-2">
                        {{-- @dd(auth()->user()->unreadNotifications) --}}
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            @if ($notification->type == "App\Notifications\LikeNotifications")
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('posts.show', $notification->data['post_id']) }}">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['like_post'] }}</b> liked your post</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                        @if (isset($notification->data['image_post']))
                                            <img src="{{ asset('images/'.$notification->data['image_post']) }}" style="width: 50px;" class="d-flex justify-self-end rounded">
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($notification->type == "App\Notifications\FollowNotifications")
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('profiles.show', $notification->data['follower_id']) }}">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['follower_name'] }}</b> is following you</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                    </a>
                                </li>
                            @endif
                            @if ($notification->type == "App\Notifications\CommentNotifications")
                                {{-- @dd($notification) --}}
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('posts.show', $notification->data['post_id']) }}">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['comment_post'] }}</b> a ajouté un commentaire: "{{$notification->data['content_comment']}}"</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
        
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{-- image de profile de user --}}
                                        <img src="{{ asset('images/default.png') }}" alt="" style="width: 32px" class="pe-2">
                                        {{ Auth::user()->name }}
                                        
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            @if(auth()->user()->hasRole('admin'))
                            <x-dropdown-link href="{{ route('admin-dashboard.index') }}">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            @endif
                            
                            {{-- @if(auth()->user()->hasRole('admin'))
                            <x-dropdown-link href="{{ route('admin-dashboard') }}">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            @endif --}}

                            <x-dropdown-link href="{{ route('profiles.show', auth()->id()) }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Parametres') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <div class="dropdown">
                    <button type="button" class="m-2 position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="icon" id="bell"><i class="fa-regular fa-bell"></i></div>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread messages</span>
                        @endif
                        </span>
                    </button>
                    <ul class="dropdown-menu" style="width: 23rem">
                        <div class="notification-heading d-flex justify-content-between align-items-center px-2">
                            <p class="menu-title ">Notifications ({{ auth()->user()->unreadNotifications->count() }})</p>
                            <a class="btn btn-sm" href="{{ route('posts.markCommeLu') }}">marquer comme lu</a>
                        </div>
                        <hr class="m-auto w-75 mt-2">
                        {{-- @dd(auth()->user()->unreadNotifications) --}}
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            @if ($notification->type == "App\Notifications\LikeNotifications")
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('posts.show', $notification->data['post_id']) }}">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['like_post'] }}</b> liked your post</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                        @if (isset($notification->data['image_post']))
                                            <img src="{{ asset('images/'.$notification->data['image_post']) }}" style="width: 50px;" class="d-flex justify-self-end rounded">
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($notification->type == "App\Notifications\FollowNotifications")
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['follower_name'] }}</b> is following you</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                    </a>
                                </li>
                            @endif
                            @if ($notification->type == "App\Notifications\CommentNotifications")
                                {{-- @dd($notification) --}}
                                <li class="border-bottom">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('posts.show', $notification->data['post_id']) }}">
                                        <small class="notification-item ">
                                            <p><b>{{ $notification->data['comment_post'] }}</b> a ajouté un commentaire: "{{$notification->data['content_comment']}}"</p>
                                            <p>{{ date('j F   H:i', strtotime($notification->created_at)) }}</p>
                                        </small>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('feed') }}" :active="request()->routeIs('feed')">
                {{ __('feed') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                @if(auth()->user()->hasRole('admin'))
                <x-dropdown-link href="{{ route('admin-dashboard.index') }}">
                    {{ __('Dashboard') }}
                </x-dropdown-link>
                @endif
                
                {{-- @if(auth()->user()->hasRole('admin'))
                <x-dropdown-link href="{{ route('admin-dashboard') }}">
                    {{ __('Dashboard') }}
                </x-dropdown-link>
                @endif --}}

                <x-dropdown-link href="{{ route('profiles.show', auth()->id()) }}">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Parametres') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
