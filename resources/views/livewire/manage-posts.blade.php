<div class="">
    

    @foreach ($posts as $post)
        @php
            $date = Carbon\Carbon::parse($post->post_date);
            $formattedDate = $date->format("j F Y");
        @endphp
        <div class="feed">
            <div class="post">
                <div class="post-header d-flex justify-content-between align-items-center"">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="post-header-details">
                            <h2>{{ $post->user->name }}</h2>
                            {{-- <p>{{ $formattedDate }}</p> --}}
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
                                    {{-- <a class="dropdown-item" href="#">Supprimer</a> --}}
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
                <div class="post-actions">
                    <livewire:like-post :post="$post" />
                </div>
                <hr class="w-75 m-auto color-secondary my-3">
                <livewire:comments-section :postId="$post->id" />
            </div>
        </div>
    @endforeach
</div>
