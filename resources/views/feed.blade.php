<x-app-layout>

    <div class="py-3">

    <main class="main">
        {{-- left bar --}}
        <aside class="sidebar-left">
            <div class="trending">
                <h2>Trending Topics</h2>
                <ul>
                    <li class="links-left"><a href="#">#socialmedia</a></li>
                    <li class="links-left"><a href="#">#marketing</a></li>
                    <li class="links-left"><a href="#">#technology</a></li>
                    <li class="links-left"><a href="#">#business</a></li>
                    <li class="links-left"><a href="#">#startup</a></li>
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
                    <div class="image-upload">
                        <label for="upload">
                            <i class="fa-solid fa-upload" style="color: #0248c0;"></i>
                        </label>
                        <input type="file" id="post_image" name="post_image">
                    </div>
                    <div class="form-bottom-part">
                        <textarea id="post_desc" name="post_desc" class="form-control-publish" rows="3" placeholder="what's in your head"></textarea>
                    </div>
                    <button class="cta" type="submit">
                        <span>Publier</span>
                    </button>
                </form>
            </div>
            
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
                        {{-- <span class="fw-light" style="font-size: 15px">comments ({{ $post->comments()->count() }})</span> --}}
                    </div>
                    <hr class="w-75 m-auto color-secondary my-3">
                    <livewire:comments-section :postId="$post->id" />
                </div>
            </div>
            @endforeach
            
            
        {{-- <livewire:manage-posts /> --}}
        </div> 

        {{-- right bar --}}
        <aside class="sidebar-right">
            <div class="suggested-friends">
                <h2>Suggested Friends</h2>
                <ul>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar" style="width: 60px">
                        <div class="friend-details">
                            <h3>Jane Smith</h3>
                            <button>Add Friend</button>
                        </div>
                    </li>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar" style="width: 60px">
                        <div class="friend-details">
                            <h3>Bob Johnson</h3>
                            <button>Add Friend</button>
                        </div>
                    </li>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar" style="width: 60px">
                        <div class="friend-details">
                            <h3>Sarah Williams</h3>
                            <button>Add Friend</button>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
    </main>

  
</x-app-layout>
