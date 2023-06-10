<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\SpladeTable;

class PostController extends Controller
{
    /**
     * display all post data
     */
    public function index()
    {
        // get all post data
        $posts = Post::latest()->paginate(7);

        // render view
        return view('posts.index', [
            'posts' => SpladeTable::for($posts)
            ->column('image')
            ->column('title')
            ->column('content')
            ->column('action')
        ]);
    }

    /**
     *  display form create
     */
    public function create()
    {
        // render view
        return view('posts.create');
    }

    /**
     *  insert new post data
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,jpg,png',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // insert new post to db
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $image->hashName(),
        ]);

        // render view
        return redirect(route('posts.index'));
    }

    /**
     *  display form edit
     */
    public function edit(Post $post)
    {
        // render view
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     *  update post data by id
     */
    public function update(Post $post, Request $request)
    {
        // validate request
        $this->validate($request, [
            'image'     => 'nullable|image|mimes:jpeg,jpg,png',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        // update post data by id
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // check if user upload new image
        if($request->file('image')){
            // upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            // delete old image
            Storage::delete('public/posts/'. $post->image);

            // update post data image
            $post->update([
                'image' => $image->hashName(),
            ]);
        }

        // render view
        return redirect(route('posts.index'));
    }

    /**
     *  delete post data by id
     */
    public function destroy(Post $post)
    {
        // delete post image
        Storage::delete('public/posts/'. $post->image);

        // delete post data by id
        $post->delete();

        // render view
        return back();
    }
}