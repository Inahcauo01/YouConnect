<div>
    {{-- In work, do what you enjoy. --}}
    {{-- <div class="publish">
        <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" class="form-publish">
            @csrf
            <div class="image-upload">
                <label for="upload">
                    <i class="fa-solid fa-upload" style="color: #0248c0;"></i>
                </label>
                <input type="file" wire:model="post_image" id="post_image" name="post_image">
            </div>
            <div class="form-bottom-part">
                <textarea id="post_desc" wire:model="post_desc" name="post_desc" class="form-control-publish" rows="3" placeholder="what's in your head"></textarea>
            </div>
            <button class="cta" type="submit">
                <span>Publier</span>
            </button>
        </form>
    </div> --}}
    
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
                            <p>{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                    @if (auth()->user()->id == $post->user->id)
                        <div>
                            <button type="button" class="btn" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form wire:submit.prevent="deletePost({{ $post->id }})">
                                        <button type="submit" class="dropdown-item">Supprimer</button>
                                    </form>
                                </li>
                                <li><a class="dropdown-item" href="#" wire:click.prevent="editPost({{ $post->id }})">Modifier</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="post-content">
                    <p>{{ $post->post_desc }}</p>
                    @if ($post->post_image)
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
    @endforeach
    
</div>
