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
  </head>
<style>
    button{border:none !important; background: none !important}
</style>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
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
                                            {{-- <a href="javascript:void(0)" class="btn btn-primary">
                                                <i class="ti ti-user-check me-1"></i>Connected
                                            </a> --}}
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
                            <!--/ Activity Timeline -->
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Content wrapper -->
            </div>
        </div>
    </div>
</body>
</html>
