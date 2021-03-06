<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\InfoPost;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at' , 'desc')->paginate(5); 

        return view('posts.index' , compact('posts'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get all tags
        $tags = Tag::all();
        return view('posts.create' , compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //GET DATA FROM FORM
        $data = $request->all();
       
        //VALIDATION WITH A PRIVATE CUSTOM FUNCTION
        $request->validate($this->ruleValidation());

        //SET POST SLUG
        $data['slug'] = Str::slug($data['title'] , '-');

        //IMG E' PRESENTE?
        if (!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images' , $data['path_img']);
        } 

        //SAVE TO DB
        $newPost = new Post();
        $newPost->fill($data); //<----Fillable in  model!!!
        $saved = $newPost->save();

        //iNFOPOST RECORD
        $data['post_id'] = $newPost->id; //Foreign Key
        $newInfo = new InfoPost();
        $newInfo->fill($data);//<-----fillable in model
        $infoSaved = $newInfo->save();

        if ($saved && $infoSaved) {
            if(!empty($data['tags'])) {
                $newPost->tags()->attach($data['tags']); //Attach in pivot
            }
            return redirect()->route('posts.index');
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug' , $slug)->first();

        //CHECK
        if (empty($post)) {
            abort (404);
        }
        
        return view('posts.show' , compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug' , $slug)->first();
        $tags = Tag::all();

        //CHECK
        if (empty('$post')) {
            abort(404);
        }

        return view('posts.edit' , compact('post' , 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //GET DATA FROM FORM
        $data = $request->all();

        //VALIDATION
        $request->validate($this->ruleValidation());

        //GET POST TO UPDATE
        $post = Post::find($id);

        //SLUG GENERATION
        $data['slug'] = Str::slug($data['title'] , '-');

        //IF IMAGE CHANGED?
        if(!empty($data['path_img'])) {
            if(!empty($post->path_img)) {
                Storage::disk('public')->delete($post->path_img);
            }
            $data['path_img'] = Storage::disk('public')->put('images' , $data['path_img']);
        }

        //UPDATE IN DATABASE
        $updated = $post->update($data); //<---- Fillable in model!!

        //Info table update
        $data['post_id'] = $post->id; //Foreign Key
        $info = InfoPost::where('post_id' , $post->id)->first();
        $infoUpdated = $info->update($data); //<---- Fillable in model!!


        if($updated && $infoUpdated) {
            if (!empty($data['tags'])) {
                $post->tags()->sync($data['tags']);
            } else {
                $post->tags()->detach();
            }
            return redirect()->route('posts.show' , $post->slug);
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)   //<---- Forma contratta , dietro le quinte: $post = Post::find($id);
    {
        $title = $post->title;
        $image = $post->path_img;
        $post->tags()->detach();
        $deleted = $post->delete();

        if ($deleted) {
            if (!empty($image)) {
                Storage::disk('public')->delete($image); 
            }
            return redirect()->route('posts.index')->with('post-deleted' , $title); 
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * FUNCTION VALIDATION
     */
    private function ruleValidation() {
        return [
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'image',
        ];
    }
}
