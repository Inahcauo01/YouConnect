<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="horizontal-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>User Profile - Profile</title>
    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-profile.css" />
    <script src="../../assets/vendor/js/helpers.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <script src="../../assets/js/config.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  </head>
<style>
    button{border:none !important; background: none !important}
</style>
  <body>
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
            </div>

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
                            <button class="btn btn-sm" href="#">marquer comme lu</button>
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
{{-- 
                            <x-dropdown-link href="{{ route('profiles.show', auth()->id()) }}">
                                {{ __('Profile') }}
                            </x-dropdown-link> --}}

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
                            <button class="btn btn-sm" href="#">marquer comme lu</button>
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
            {{-- <x-dropdown-link href="{{ route('profiles.show', auth()->id()) }}">
                {{ __('Profile') }}
            </x-dropdown-link> --}}

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

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu mt-5">
      <div class="layout-container">

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4> -->

                    <!-- Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="user-profile-header-banner">
                                    <img src="{{ asset('images/bg/bg-default.png') }}" alt="bg image" class="rounded-top" />
                                </div>
                                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                        <img src="{{ $user->profile_photo_url }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                                    </div>
                                    <div class="flex-grow-1 mt-3 mt-sm-5">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info">
                                                <h4 class="mb-2">{{ $user->name }}</h4>
                                                <small class="mt-0 d-flex">
                                                    <p>Followers {{ $user->follower->count() }}</p>
                                                    <p class="ms-3">Followings {{ $user->Following->count() }}</p>
                                                </small>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    @if (isset($profile->bio))
                                                        {{ $profile->bio }}
                                                    @endif
                                                </ul>
                                            </div>
                                            @if (auth()->id() == $user->id)
                                                <button class="p-2 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    <span class="m-1">Modifier</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Header -->

                    <!-- User Profile Content -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-5">
                            <!-- About User -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <small class="card-text text-uppercase">About</small>
                                    <ul class="list-unstyled mb-4 mt-3">
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="user"> <g> <path d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" fill="none" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <circle cx="12" cy="7" fill="none" r="4" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle> </g> </g> </g> </g></svg></i><span class="fw-bold mx-2">Titre</span> 
                                            <span>
                                            @if (isset($profile->titre))
                                            {{ $profile->titre }}
                                            @else <small> . . .</small>
                                            @endif
                                            </span>
                                        </li>
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3442 5.39811C12.9087 3.13396 8.93592 3.13396 6.50035 5.39811C4.42306 7.3292 4.11365 10.3235 5.72875 12.5757L10.9223 19.8177L16.1158 12.5757C17.7309 10.3235 17.4215 7.3292 15.3442 5.39811ZM5.34288 4.15302C8.43091 1.28233 13.4137 1.28233 16.5017 4.15302C19.1919 6.65385 19.6221 10.6035 17.4973 13.5664L11.7508 21.5795L11.0601 21.0841L11.7508 21.5795C11.3462 22.1437 10.4984 22.1437 10.0937 21.5795L10.5987 21.2174L10.0937 21.5795L4.34727 13.5664C2.22248 10.6035 2.65271 6.65385 5.34288 4.15302Z" fill="#3d3d3d"></path> <circle cx="11" cy="9" r="2" fill="#3d3d3d"></circle> </g></svg><span class="fw-bold mx-2">Adresse:</span>
                                        <span>
                                            @if (isset($profile->adresse))
                                            {{ $profile->adresse }}
                                            @else <small> . . .</small>
                                            @endif
                                            </span>
                                        </li>
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="3" y="6" width="18" height="15" rx="2" stroke="#3d3d3d"></rect> <path d="M3 10C3 8.11438 3 7.17157 3.58579 6.58579C4.17157 6 5.11438 6 7 6H17C18.8856 6 19.8284 6 20.4142 6.58579C21 7.17157 21 8.11438 21 10H3Z" fill="#3d3d3d"></path> <path d="M7 3L7 6" stroke="#3d3d3d" stroke-linecap="round"></path> <path d="M17 3L17 6" stroke="#3d3d3d" stroke-linecap="round"></path> </g></svg><span class="fw-bold mx-2">Date naissance:</span>
                                            <span>
                                                @if (isset($profile->date_naissance))
                                                {{ $profile->date_naissance }}
                                                @else <small> . . .</small>
                                                @endif
                                            </span>
                                        </li>                            
                                    </ul>
                                    <small class="card-text text-uppercase">Contacts</small>
                                    <ul class="list-unstyled mb-4 mt-3">
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.4 20.75H18.17C15.5788 20.4681 13.0893 19.5846 10.9 18.17C8.86618 16.8747 7.13938 15.1513 5.84 13.12C4.42216 10.925 3.53852 8.42823 3.26 5.83001C3.22816 5.52011 3.2596 5.20696 3.35243 4.90958C3.44525 4.6122 3.59752 4.33677 3.8 4.10001C3.99694 3.86008 4.24002 3.66211 4.51486 3.51782C4.78969 3.37354 5.09068 3.28587 5.4 3.26001H8C8.56312 3.26058 9.10747 3.46248 9.53476 3.82925C9.96205 4.19602 10.2441 4.70349 10.33 5.26001C10.425 5.97489 10.6028 6.67628 10.86 7.35001C11.0164 7.77339 11.0487 8.23264 10.9531 8.67375C10.8574 9.11485 10.6378 9.51947 10.32 9.84001L9.71 10.45C10.6704 11.9662 11.9587 13.2477 13.48 14.2L14.09 13.6C14.4105 13.2822 14.8152 13.0626 15.2563 12.9669C15.6974 12.8713 16.1566 12.9036 16.58 13.06C17.2545 13.3148 17.9556 13.4926 18.67 13.59C19.236 13.6751 19.7515 13.9638 20.1198 14.402C20.488 14.8403 20.6837 15.3978 20.67 15.97V18.37C20.67 18.9942 20.4227 19.593 19.9823 20.0353C19.5419 20.4776 18.9442 20.7274 18.32 20.73L18.4 20.75ZM8 4.75001H5.61C5.49265 4.75777 5.37809 4.78924 5.27325 4.84252C5.1684 4.8958 5.07545 4.96979 5 5.06001C4.92658 5.14452 4.871 5.24302 4.83663 5.34957C4.80226 5.45612 4.7898 5.56852 4.8 5.68001C5.04249 8.03679 5.83362 10.304 7.11 12.3C8.28664 14.1467 9.85332 15.7134 11.7 16.89C13.6973 18.1798 15.967 18.9878 18.33 19.25C18.4529 19.2569 18.5759 19.2383 18.6912 19.1953C18.8065 19.1522 18.9117 19.0857 19 19C19.1592 18.8368 19.2489 18.6181 19.25 18.39V16C19.2545 15.7896 19.1817 15.5848 19.0453 15.4244C18.9089 15.2641 18.7184 15.1593 18.51 15.13C17.6839 15.0189 16.8724 14.8177 16.09 14.53C15.9359 14.4724 15.7686 14.4596 15.6075 14.4933C15.4464 14.5269 15.2982 14.6055 15.18 14.72L14.18 15.72C14.0629 15.8342 13.912 15.9076 13.7499 15.9292C13.5877 15.9508 13.423 15.9195 13.28 15.84C11.1462 14.6342 9.37997 12.8715 8.17 10.74C8.08718 10.598 8.05402 10.4324 8.07575 10.2694C8.09748 10.1065 8.17286 9.95538 8.29 9.84001L9.29 8.84001C9.40468 8.72403 9.48357 8.57751 9.51726 8.41793C9.55095 8.25835 9.53802 8.09244 9.48 7.94001C9.19119 7.15799 8.98997 6.34637 8.88 5.52001C8.85519 5.30528 8.75133 5.10747 8.58865 4.96513C8.42597 4.82278 8.21613 4.7461 8 4.75001Z" fill="#3d3d3d"></path> </g></svg><span class="fw-bold mx-2">Telephone:</span>
                                            @if (isset($profile->telephone))
                                                <a href="tel: {{ $profile->telephone }}" class="text-dark">{{ $profile->telephone }}</a>
                                            @else <small> . . .</small>
                                            @endif
                                        </li>
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="mail"> <g> <polyline fill="none" points="4 8.2 12 14.1 20 8.2" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polyline> <rect fill="none" height="14" rx="2" ry="2" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="18" x="3" y="6.5"></rect> </g> </g> </g> </g></svg><span class="fw-bold mx-2">Email:</span>
                                            <a href="mailto: {{ $user->email }}" class="text-dark">{{ $user->email }}</a>
                                        </li>
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="18px" height="18px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>linkedin [#161]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -7479.000000)" fill="#3d3d3d"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,7339 L140,7339 L140,7332.001 C140,7330.081 139.153,7329.01 137.634,7329.01 C135.981,7329.01 135,7330.126 135,7332.001 L135,7339 L131,7339 L131,7326 L135,7326 L135,7327.462 C135,7327.462 136.255,7325.26 139.083,7325.26 C141.912,7325.26 144,7326.986 144,7330.558 L144,7339 L144,7339 Z M126.442,7323.921 C125.093,7323.921 124,7322.819 124,7321.46 C124,7320.102 125.093,7319 126.442,7319 C127.79,7319 128.883,7320.102 128.883,7321.46 C128.884,7322.819 127.79,7323.921 126.442,7323.921 L126.442,7323.921 Z M124,7339 L129,7339 L129,7326 L124,7326 L124,7339 Z" id="linkedin-[#161]"> </path> </g> </g> </g> </g></svg><span class="fw-bold mx-2">Linkedin:</span>
                                            @if (isset($profile->linkedin_link))
                                                <a href="{{ $profile->linkedin_link }}" class="text-dark">{{ $profile->linkedin_link }}</a>
                                            @else
                                                <span> . . . </span>
                                            @endif
                                        </li>
                                        <li class="d-flex align-items-center mb-3 align-items-center">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>github [#142]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-140.000000, -7559.000000)" fill="#3d3d3d"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M94,7399 C99.523,7399 104,7403.59 104,7409.253 C104,7413.782 101.138,7417.624 97.167,7418.981 C96.66,7419.082 96.48,7418.762 96.48,7418.489 C96.48,7418.151 96.492,7417.047 96.492,7415.675 C96.492,7414.719 96.172,7414.095 95.813,7413.777 C98.04,7413.523 100.38,7412.656 100.38,7408.718 C100.38,7407.598 99.992,7406.684 99.35,7405.966 C99.454,7405.707 99.797,7404.664 99.252,7403.252 C99.252,7403.252 98.414,7402.977 96.505,7404.303 C95.706,7404.076 94.85,7403.962 94,7403.958 C93.15,7403.962 92.295,7404.076 91.497,7404.303 C89.586,7402.977 88.746,7403.252 88.746,7403.252 C88.203,7404.664 88.546,7405.707 88.649,7405.966 C88.01,7406.684 87.619,7407.598 87.619,7408.718 C87.619,7412.646 89.954,7413.526 92.175,7413.785 C91.889,7414.041 91.63,7414.493 91.54,7415.156 C90.97,7415.418 89.522,7415.871 88.63,7414.304 C88.63,7414.304 88.101,7413.319 87.097,7413.247 C87.097,7413.247 86.122,7413.234 87.029,7413.87 C87.029,7413.87 87.684,7414.185 88.139,7415.37 C88.139,7415.37 88.726,7417.2 91.508,7416.58 C91.513,7417.437 91.522,7418.245 91.522,7418.489 C91.522,7418.76 91.338,7419.077 90.839,7418.982 C86.865,7417.627 84,7413.783 84,7409.253 C84,7403.59 88.478,7399 94,7399" id="github-[#142]"> </path> </g> </g> </g> </g></svg><span class="fw-bold mx-2">Github:</span>
                                            @if (isset($profile->github_link))
                                                <a href="mailto: {{ $profile->github_link }}" class="text-dark">{{ $profile->github_link }}</a>
                                            @else
                                                <span> . . . </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!--/ Profile Overview -->
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7">
                            
                            @if ($posts->count() == 0)
                                <small class="card card-action p-5 text-center">Vous avez aucun post pour l'instant</small>
                            @endif
                            @foreach ($posts as $post)
                            <div class="card card-action mb-4 pb-3">
                                <div class="card-header align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $post->user->profile_photo_url }}" alt="User Avatar" class="rounded-circle">
                                        <div class="post-header-details d-flex flex-column justify-content-center ms-2">
                                            <h5 class="card-action-title mb-0">{{ $post->user->name }}</h5>
                                            <span>{{ Carbon\Carbon::parse($post->post_date)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-action-element">
                                        @if (auth()->user()->id == $post->user_id)
                                            <div>
                                                <button type="button" class="btn" data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Supprimer</button>
                                                        </form>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Modifier</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <p>{{$post->post_desc}}</p>
                                    @if($post->post_image != "")
                                        <img src="{{ asset('images/'.$post->post_image) }}" alt="post image">
                                    @endif
                                    <div class="post-actions justify-content-between mt-2">
                                        <livewire:like-post :post="$post" />
                                    </div>
                                    <hr class="w-75 m-auto color-secondary my-3">
                                    <livewire:comments-section :postId="$post->id" />
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button> --}}
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- @dd($profile) --}}
            <form action="{{ route('profiles.update', $profile->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mettre à jour mon profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Bio</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="bio" rows="3" placeholder=""></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Titre</label>
                        <input type="text" name="titre" class="form-control border rounded" id="exampleFormControlInput1" placeholder="developper/ formateur/ etudiant/ . . .">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control border rounded" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Telephone</label>
                        <input type="text" name="telephone" class="form-control border rounded" id="exampleFormControlInput1" placeholder="+212 ....">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Adreese</label>
                        <input type="text" name="adresse" class="form-control border rounded" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Linkedin</label>
                        <input type="url" name="link_linkedin" class="form-control border rounded" id="exampleFormControlInput1" placeholder="https://www.linkedin.com/in/.....">
                    </div>
                    <div class="">
                        <label for="exampleFormControlInput1" class="form-label">Github</label>
                        <input type="url" name="link_github" class="form-control border rounded" id="exampleFormControlInput1" placeholder="https://github.com/....">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-secondary btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-primary text-white btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
