<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users  = User::all();
        // $tags  = Tag::withCount('posts')->orderByDesc('posts_count')->get();
        
        $tags = Tag::withCount('posts')->get();

        if($tags->count() >0){
            $moy_posts_par_tag = Post::count() / $tags->count();

            // Sort the tags by their popularity
            $tags = $tags->sortByDesc(function($tag) use ($moy_posts_par_tag) {
                        return abs($tag->posts_count - $moy_posts_par_tag);
                    })->take(5);;
        }
        
        $posts = Post::with('user')->latest()->get();
        // return view('feed', compact('posts'));
        return view('feed', [
            'tags'  => $tags,
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validate([
            'post_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $post = new Post;
    
        if ($request->hasFile('post_image')) {
            $image    = $request->file('post_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $post->post_image = $filename;
        }
    
        $postDescription = $request->input('post_description');
        $tags = [];
    
        if (!empty($postDescription)) {
            $words = explode(' ', $postDescription);
            $tags = array_filter($words, function($word) {
                return strpos($word, '#') === 0 && strpos($word, ' ') === false;
            });
        }
    
        // $post->post_desc = str_replace($tags, '', $postDescription);
        $post->post_desc = $postDescription;
        $post->user_id = auth()->user()->id;
        $post->post_date = now();
        $post->save();
    
        $tag_ids = [];
    
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $tag_model = Tag::firstOrCreate(['name' => $tag]);
                $tag_ids[] = $tag_model->id;
            }
        }
    
        $post->tags()->sync($tag_ids);
    
        return redirect()->route('feed')->with('add', 'Le post a été ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $users  = User::all();
        $tags = Tag::withCount('posts')->get();

        if($tags->count() >0){
            $moy_posts_par_tag = Post::count() / $tags->count();
            $tags = $tags->sortByDesc(function($tag) use ($moy_posts_par_tag) {
                        return abs($tag->posts_count - $moy_posts_par_tag);
                    })->take(5);;
        }

        $post = Post::with('user')->findOrFail($id);

        // $getid = DB::table('notifications')->where('data->post_id',$id)->pluck('id');
        // DB::table('notifications')->where('id',$getid)->update(['read_at'=>now()]);

        $notification = DB::table('notifications')->where('data->post_id', $id)->first();
        if ($notification) {
            DB::table('notifications')->where('id', $notification->id)->update(['read_at' => date('Y-m-d H:i:s')]);
        }
        



        return view('posts.show', [
            'tags'  => $tags,
            'post'  => $post,
            'users' => $users,
        ]);
        // return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $post = Post::findOrFail($id);
    //     return view('posts.edit', compact('post'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdatePostRequest $request, $id)
    public function update(UpdatePostRequest $request)
    {
        $validatedData = $request->validate([
            'postId_up' => 'required',
            'post_desc_up' => 'nullable',
        ]);

        $post = Post::findOrFail($validatedData['postId_up']);

        $post->post_desc = $validatedData['post_desc_up'];
        $post->save();

        return redirect()->route('feed')->with('update', 'Le post a bien été modifié.');
    }
    // public function update(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'postId_up' => 'required',
    //         'post_desc_up' => 'nullable',
    //     ]);

    //     $post = Post::findOrFail($id);

    //     $postDescription = $request->input('post_desc_up');
    //     $tags = [];

    //     if (!empty($postDescription)) {
    //         $words = explode(' ', $postDescription);
    //         $tags = array_filter($words, function($word) {
    //             return strpos($word, '#') === 0 && strpos($word, ' ') === false;
    //         });
    //     }

    //     $post->post_desc = $postDescription;
    //     $post->post_date = now();
    //     $post->save();

    //     $tag_ids = [];

    //     if (is_array($tags)) {
    //         foreach ($tags as $tag) {
    //             $tag_model = Tag::firstOrCreate(['name' => $tag]);
    //             $tag_ids[] = $tag_model->id;
    //         }
    //     }

    //     $post->tags()->sync($tag_ids);

    //     return redirect()->route('feed')->with('update', 'Le post a été modifié avec succès.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        // $tagIds = $post->tags()->pluck('id')->toArray();
        $tagIds = $post->tags()->pluck('tags.id')->toArray(); // recuperer les IDs des tags de ce post
        $post->tags()->detach();
        $post->delete();
        
        foreach ($tagIds as $tagId) {
            $tag = Tag::findOrFail($tagId);
            if ($tag->posts()->count() == 0) {
                $tag->delete();
            }
        }
        return redirect()->route('feed')->with('delete', 'Le post a bien été supprimé.');
    }
}
