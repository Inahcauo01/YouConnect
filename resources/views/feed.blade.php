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
                <div class="post-header">
                    <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                    <div class="post-header-details">
                        <h2>{{ $post->user->name }}</h2>
                        <p>{{ $formattedDate }}</p>
                    </div>
                </div>
                <div class="post-content">
                    <p>{{$post->post_desc}}</p>
                    @if($post->post_image != "")
                        <img src="{{ asset('images/'.$post->post_image) }}" alt="post image">
                    @endif
                </div>
                <div class="post-actions">
                    {{-- @if(auth()->check() && !$post->likes()->where('user_id', auth()->user()->id)->exists())
                        <form method="POST" action="{{ route('posts.like', $post) }}">
                            @csrf
                            <button type="submit" class="like-button">Like</button><span>{{ $post->likes()->count() }} </span>
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.unlike', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="like-button">Unlike</button><span>{{ $post->likes()->count() }} </span>
                        </form>
                    @endif --}}
                    

                    {{-- livewire like --}}
                    <livewire:like-post :post="$post" />

                </div>
                
                @foreach ($post->comments as $comment)
                    <div class="comments">
                        <div class="comment">
                            <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                            <div class="comment-details">
                                <h3>{{ $comment->user->name }}</h3>
                                <p><small>{{ $comment->comment_date }}</small></p>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>

                        <div class="comment">
                            <p>{{ $comment->content }}</p>
                            <small>Posted by {{ $comment->user->name }} on {{ $comment->comment_date }}</small>
                        </div>
                        @auth
                            @if (auth()->user()->id === $comment->user_id)
                                <div class="comment-actions">
                                    <form action="{{ route('comments.update', [$post->id, $comment->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input name="content" value="{{ $comment->content }}" />
                                        <button type="submit">Save</button>
                                    </form>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                @endforeach


                <form class="comment-form" action="{{ route('comments.store', ['post_id' => $post->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                    <input type="text" placeholder="Add a comment..." name="content">
                    <button type="submit" name="addComment" title="envoyer le commentaire" class="ms-1">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="25.000000pt" height="25.000000pt" viewBox="0 0 30.000000 30.000000" preserveAspectRatio="xMidYMid meet" class="SendSVG">
                            <g transform="translate(0.000000,30.000000) scale(0.100000,-0.100000)" fill="#119fff8f" stroke="none">
                            <path d="M44 256 c-3 -8 -4 -29 -2 -48 3 -31 5 -33 56 -42 28 -5 52 -13 52 -16 0 -3 -24 -11 -52 -16 -52 -9 -53 -9 -56 -48 -2 -21 1 -43 6 -48 10 -10 232 97 232 112 0 7 -211 120 -224 120 -4 0 -9 -6 -12 -14z"></path>
                            </g>
                        </svg>
                    </button>
                </form>                
                
            </div>
        </div>
        @endforeach

        <div class="feed">
            <div class="post">
                <div class="post-header">
                    <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                    <div class="post-header-details">
                        <h2>John Doe</h2>
                        <p>2 hours ago</p>
                    </div>
                </div>
                <div class="post-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tristique ante nulla, a laoreet risus vehicula a. Donec eu est at enim mollis dignissim.</p>
                    <img src="{{ asset('images/abstract-landing2.jpg') }}" alt="Post Image">
                </div>
                <div class="post-actions">
                    <button class="like-button">Like</button>
                    <button class="comment-button">Comment</button>
                    <button class="share-button">Share</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="comment-details">
                            <h3>Jane Smith</h3>
                            <p>2 hours ago</p>
                            <p>Great post, John!</p>
                        </div>
                    </div>
                <div class="comment">
                    <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                    <div class="comment-details">
                        <h3>Bob Johnson</h3>
                        <p>1 hour ago</p>
                        <p>Thanks for sharing, John.</p>
                    </div>
                </div>
                <form class="comment-form">
                    <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                    <input type="text" placeholder="Add a comment...">
                    <button type="submit">Post</button>
                </form>
                </div>
            </div>
        </div>
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
