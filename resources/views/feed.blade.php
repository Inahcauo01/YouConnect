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
                    <label for="post_desc"  class="form-label-publish">Description:</label>
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
                    @if(auth()->check() && !$post->likes()->where('user_id', auth()->user()->id)->exists())
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
                    @endif


                </div>

                {{-- <div class="comments">
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
                </div> --}}
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
