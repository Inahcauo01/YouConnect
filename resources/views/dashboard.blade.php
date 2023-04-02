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

        {{-- right bar --}}
        <aside class="sidebar-right">
            <div class="suggested-friends">
                <h2>Suggested Friends</h2>
                <ul>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="friend-details">
                            <h3>Jane Smith</h3>
                            <button>Add Friend</button>
                        </div>
                    </li>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="friend-details">
                            <h3>Bob Johnson</h3>
                            <button>Add Friend</button>
                        </div>
                    </li>
                    <li>
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
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
