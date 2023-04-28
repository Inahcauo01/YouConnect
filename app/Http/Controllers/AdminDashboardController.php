<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get total number of users, tags, and posts
        $users    = User::all();
        $tags     = Tag::all();
        $posts    = Post::all();
        $comments = Comment::all();
        
        $popularTags = Tag::withCount('posts')
                        ->orderByDesc('posts_count')
                        ->take(5)
                        ->get();

        $tagsParPost = Tag::count() / Post::count();
        $userActif = User::has('posts')->count();

        $averagePostsPerUser = Post::count() / User::count();

        $result = DB::table('posts')
            ->select('users.name', DB::raw('COUNT(*) as num_posts'))
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->groupBy('posts.user_id', 'users.name')
            ->get();

        $data = '';
        $index = 0;

        foreach ($result as $val) {
            $data .= "['".$val->name."', ".$val->num_posts.",  \"#87C1FF\"],";
            $index++;
        }


        
        // dd($data);

        // Return the statistics to the view
        return view('admin-dashboard.index', [
            'users'               => $users,
            'tags'                => $tags,
            'posts'               => $posts,
            'comments'            => $comments,
            'popularTags'         => $popularTags,
            'tagsParPost'         => $tagsParPost,
            'userActif'           => $userActif,
            'averagePostsPerUser' => $averagePostsPerUser,
            'data'                => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
