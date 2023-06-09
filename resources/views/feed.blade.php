<x-app-layout>

    <div class="py-3">

    <main class="main mt-5">
        {{-- left bar --}}
        <aside class="sidebar-left">
            <div class="trending">
                <h2>Trending Topics</h2>
                <ul>
                    @foreach ($tags as $tag)
                        <li class="links-left"><a href="#">{{ $tag->name }}</a> : {{$tag->posts->count()}}</li>
                    @endforeach
                    @if (!$tags->count())
                        <small class="d-flex flex-column text-center text-secondary">Il n y a aucun trending tags pour l'instant.</small>
                    @endif
                </ul>
            </div>
            <div class="links">
                <h2>Useful Links</h2>
                <ul>
                    <li class="links-left"><a href="#">About Us</a></li>
                    <li class="links-left"><a href="#">Contact Us</a></li>
                    <li class="links-left"><a href="#">Privacy Policy</a></li>
                    <li class="links-left"><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </aside>

        {{-- feed content (middle) --}}
        <div class="feed-container">
            <div class="publish">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="form-publish">
                    @csrf
                    <div class="image-upload w-100">
                        <label for="post_image">
                            <i class="fa-solid fa-upload" style="color: #0248c0;"></i>
                        </label>
                        <input type="file" id="post_image" name="post_image">
                        <div class="imgshow-container hide">
                            <img id="imgshow" src="" alt="">
                        </div>
                    </div>
                    <div class="form-group w-100">
                        <textarea type="text" class="form-control-publish" rows="3" id="post-description" name="post_description" placeholder="Enter your post description and tags"></textarea>
                    </div>
                    <button class="cta" type="submit">
                        <span>Publier</span>
                    </button>
                </form>
            </div>
            @if (session('add'))
                <div class="alert alert-success alert-dismissible fade show align-items-center" role="alert">
                    {{ session('add') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-success alert-dismissible fade show align-items-center" role="alert">
                    {{ session('update') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-success alert-dismissible fade show align-items-center" role="alert">
                    {{ session('delete') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>            
            @endif
            {{-- 
            @foreach ($posts as $post)
                @php
                    $date = Carbon\Carbon::parse($post->post_date);
                    $formattedDate = $date->format("j F Y");
                @endphp
                <div class="feed">
                    <div class="post">
                        <div class="post-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $post->user->profile_photo_url }}" alt="User Avatar">
                                <div class="post-header-details">
                                    <h2>{{ $post->user->name }}</h2>
                                    <p>{{ Carbon\Carbon::parse($post->post_date)->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if (auth()->user()->id == $post->user->id)
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
                        <div class="post-content">
                            <p>{{$post->post_desc}}</p>
                            @if($post->post_image != "")
                                <img src="{{ asset('images/'.$post->post_image) }}" alt="post image">
                            @endif
                        </div>

                        <div class="post-actions justify-content-between mt-2">
                            <livewire:like-post :post="$post" />
                        </div>
                        <hr class="w-75 m-auto color-secondary my-3">
                        <livewire:comments-section :postId="$post->id" />
                    </div>
                </div>
            @endforeach --}}

            <livewire:posts />

            
        {{-- <livewire:manage-posts /> --}}
        </div> 

        {{-- right bar --}}
        <aside class="sidebar-right">
            <div class="suggested-friends">
                <h2>Suggested Friends</h2>
                    @foreach ($users as $user)
                        @if (auth()->user()->id != $user->id)
                            <li class="d-flex align-items-center border-bottom pb-3 mb-2">
                                <a href="{{ route('profiles.show', $user->id ) }}">
                                    <img src="{{ $user->profile_photo_url }}" alt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 60px">
                                </a>
                                {{-- @livewire('follow', ['user' => $user]) --}}
                                <livewire:follow :user="$user" />
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </aside>
    </main>
    
  
</x-app-layout>
