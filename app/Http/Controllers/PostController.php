<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;
use Illuminate\Http\Request;

class PostController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Post::with('author');
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
     
        if (!$request->has('status')) {
            $query->published();
        }
        
        if ($request->has('recent')) {
            $query->recent();
        }
        
        $posts = $query->latest()->paginate(10);
        
        return view('posts.index', compact('posts'));
    }
    
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('author')
            ->firstOrFail();
            
        return view('posts.show', compact('post'));
    }
    
    public function byAuthor($authorId)
    {
        $author = Author::findOrFail($authorId);
        $posts = $author->posts()
            ->published()
            ->latest()
            ->paginate(10);
            
        return view('posts.by_author', compact('posts', 'author'));
    }
    
    public function recent()
    {
        $posts = Post::published()
            ->recent()
            ->latest()
            ->paginate(10);
            
        return view('posts.recent', compact('posts'));
    }
   
    public function verifyFunctionality()
    {
        $results = [];
        $recentPublishedPosts = Post::published()->recent()->get();
        $results['recent_published_posts'] = [
            'count' => $recentPublishedPosts->count(),
            'posts' => $recentPublishedPosts->map(function($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'status' => $post->status,
                    'created_at' => $post->created_at->format('Y-m-d H:i:s')
                ];
            })
        ];
        $prolificAuthors = Author::has('posts', '>=', 5)->get();
        $results['prolific_authors'] = [
            'count' => $prolificAuthors->count(),
            'authors' => $prolificAuthors->map(function($author) {
                return [
                    'id' => $author->id,
                    'name' => $author->name,
                    'post_count' => $author->posts()->count()
                ];
            })
        ];
        
        // 3. Create a new post for a specific author
        $author = Author::first();
        if ($author) {
            $newPost = new Post([
                'title' => 'New Test Post ' . now()->timestamp,
                'content' => 'This is a test post created for functional verification.',
                'status' => 'draft'
            ]);
            $author->posts()->save($newPost);
            
            $results['new_post'] = [
                'id' => $newPost->id,
                'title' => $newPost->title,
                'slug' => $newPost->slug,
                'author_id' => $author->id,
                'author_name' => $author->name
            ];
        }
        
        $postToUpdate = Post::where('slug', $newPost->slug)->first();
        if ($postToUpdate) {
            $results['update_post'] = [
                'before' => [
                    'content' => $postToUpdate->content,
                    'status' => $postToUpdate->status
                ]
            ];
            
            $postToUpdate->content = 'This content has been updated for testing purposes.';
            $postToUpdate->status = 'published';
            $postToUpdate->published_at = now();
            $postToUpdate->save();
            
            $results['update_post']['after'] = [
                'content' => $postToUpdate->content,
                'status' => $postToUpdate->status,
                'published_at' => $postToUpdate->published_at
            ];
        }
        
        $tempAuthor = Author::create([
            'name' => 'Temporary Author',
            'email' => 'temp' . now()->timestamp . '@example.com',
            'bio' => 'This author will be deleted for testing cascade deletion.'
        ]);
        
        for ($i = 0; $i < 3; $i++) {
            $tempAuthor->posts()->create([
                'title' => "Temp Post $i",
                'content' => "This is temporary post $i for testing cascade deletion.",
                'status' => 'draft'
            ]);
        }
 
        $postCountBefore = Post::where('author_id', $tempAuthor->id)->count();
        $tempAuthor->delete();
        
        $postCountAfter = Post::where('author_id', $tempAuthor->id)->count();
        
        $results['cascade_delete'] = [
            'author_id' => $tempAuthor->id,
            'posts_before_deletion' => $postCountBefore,
            'posts_after_deletion' => $postCountAfter,
            'cascade_successful' => $postCountAfter === 0
        ];
        
        return response()->json($results);
    }
}