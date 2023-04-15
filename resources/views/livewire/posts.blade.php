<div>
    {{-- In work, do what you enjoy. --}}
    
    @foreach ($posts as $post)
        @if ($post->user->follower->contains(auth()->user()->id) || $post->user->id == auth()->id())
            <div class="feed" id="{{$post->id}}">   
                <div class="post">
                    <div class="post-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $post->user->profile_photo_url }}" alt="User Avatar">
                            <div class="post-header-details">
                                <h2>{{ $post->user->name }}</h2>
                                <p>{{ \Carbon\Carbon::parse($post->created_at)->formatLocalized('%e %B %Y') }}</p>
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
                                        {{-- <form wire:submit.prevent="deletePost({{ $post->id }})">
                                            <button type="submit" class="dropdown-item">Supprimer</button>
                                        </form> --}}
                                    </li>
                                    {{-- <li><a class="dropdown-item" href="#" wire:click.prevent="editPost({{ $post->id }})">Modifier</a></li> --}}
                                    <li>
                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit-post" 
                                        onclick="updatePost({{$post->id}},'{{$post->post_desc }}','{{$post->post_image}}','{{$post->user->name}}','{{$post->user->profile_photo_url}}')">
                                        Modifier
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="post-content">
                        <p>{{ $post->post_desc }}</p>
                        @if ($post->post_image)
                            <p class="d-flex justify-content-center"><img src="{{ asset('images/'.$post->post_image) }}" alt="post image"  ondblclick="liking({{$post->id}})"></p>
                        @endif
                    </div>
        
                    <div class="post-actions justify-content-between mt-2">
                        <livewire:like-post :post="$post" />
                    </div>
                    <hr class="w-75 m-auto color-secondary my-3">
                    <livewire:comments-section :postId="$post->id" />
                </div>
            </div>
            
            
        @endif
    @endforeach
    <div class="modal fade" id="edit-post" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            {{-- <form class="modal-content" action="{{ route('posts.update', $post->id) }}" method="POST"> --}}
            <form class="modal-content" action="{{ route('posts.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="post">
                        <div class="post-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <p class="user-img">
                                    {{-- <img src="{{ $post->user->profile_photo_url }}" alt="User Avatar"> --}}
                                </p>
                                <div class="post-header-details">
                                    <h2 class="name-user">
                                        {{-- {{ $post->user->name }} --}}
                                    </h2>
                                    {{-- <p>{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="post-content">
                            <p><input type="hidden" name="postId_up" id="postId_up"></p>
                            <p><input type="text" class="w-100" name="post_desc_up" id="post_desc_up"></p>
                            @if ($post->post_image)
                                <p class="img-post"><img src="{{ asset('images/'.$post->post_image) }}" alt="post image"></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-end m-2">
                    <button type="button" class="btn-sm m-2 btn-dark" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    {{-- <button class="btn btn-sm btn-primary" wire:click.prevent="updatePost({{ $post->id }})">Modifier</button> --}}
                    <button class="btn btn-sm btn-primary" type="submit">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
