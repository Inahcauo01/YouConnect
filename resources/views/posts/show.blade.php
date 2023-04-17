<x-app-layout>

    <div class="py-3">

    <main class="main">
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

        </div> 

        <aside class="sidebar-right">
            <div class="suggested-friends">
                <h2>Suggested Friends</h2>
                    @foreach ($users as $user)
                        @if (auth()->user()->id != $user->id)
                            <li class="d-flex align-items-center border-bottom pb-3 mb-2">
                                <img src="{{ asset('images/default.png') }}" alt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 60px">
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
