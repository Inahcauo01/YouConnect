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
                                            <button class="bg-info rounded text-white p-2">
                                                Modifier
                                            </button>
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
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="ti ti-user"></i><span class="fw-bold mx-2">Titre</span> 
                                            <span>
                                            @if (isset($profile->titre))
                                            {{ $profile->titre }}
                                            @else <small> . . .</small>
                                            @endif
                                            </span>
                                        </li>
                                        <li class="d-flex align-items-center mb-3">
                                        <i class="ti ti-check"></i><span class="fw-bold mx-2">Adresse:</span>
                                        <span>
                                            @if (isset($profile->adresse))
                                            {{ $profile->adresse }}
                                            @else <small> . . .</small>
                                            @endif
                                            </span>
                                        </li>
                                        <li class="d-flex align-items-center mb-3">
                                        <i class="ti ti-crown"></i><span class="fw-bold mx-2">Date naissance:</span>
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
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="ti ti-phone-call"></i><span class="fw-bold mx-2">Telephone:</span>
                                            @if (isset($profile->telephone))
                                                <a href="tel: {{ $profile->telephone }}" class="text-dark">{{ $profile->telephone }}</a>
                                            @else <small> . . .</small>
                                            @endif
                                        </li>
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="ti ti-mail"></i><span class="fw-bold mx-2">Email:</span>
                                            <a href="mailto: {{ $user->email }}" class="text-dark">{{ $user->email }}</a>
                                        </li>
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="ti ti-mail"></i><span class="fw-bold mx-2">Linkedin:</span>
                                            @if (isset($profile->linkedin_link))
                                                <a href="{{ $profile->linkedin_link }}" class="text-dark">{{ $profile->linkedin_link }}</a>
                                            @else
                                                <span> . . . </span>
                                            @endif
                                        </li>
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="ti ti-mail"></i><span class="fw-bold mx-2">Github:</span>
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
                            
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
