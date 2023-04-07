<div >
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

        @foreach ($posts as $post)
            <div class="feed">
                <div class="post">
                    <div class="post-header">
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="post-header-details">
                            <h2>{{ $post->user->name }}</h2>
                            {{-- <p>{{ $post->post_date->format("j F Y") }}</p> --}}
                            <p>{{ \Carbon\Carbon::parse($post->post_date)->format("j F Y") }}</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>{{$post->post_desc}}</p>
                        @if($post->post_image)
                            <img src="{{ asset('storage/images/'.$post->post_image) }}" alt="post image">
                        @endif
                    </div>
                    <div class="post-actions">
                        <livewire:like-post :post="$post" />
                    </div>
                    <hr class="w-75 m-auto color-secondary my-3">
                    <livewire:comments-section :postId="$post->id" />
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form wire:submit.prevent="deletePost({{ $post->id }})">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    
</div>
