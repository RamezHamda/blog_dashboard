<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $count = 5;
        if($request->has('count')){
            $count = $request->count;
        }
        // $posts = Post::latest('id')->paginate();
        $posts = Post::orderBy('id','Desc')->paginate($count);

        if($request->has('search')){
            $posts = Post::where('title', 'like' , '%'.$request->search.'%')->orderBy('id','Desc')->paginate($count);
        }

        return view("admin.posts.index")->with("posts" , $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // 1-> Validation >>Method #1

        // $request->validate([
        //     'title' => 'required',
        //     'image' => 'required|image|mimes:png,jpg',
        //     'content' => 'required'
        // ]);

            // Validation >>Method #2
        // $validator = Validator::make($request->all(),[
        //     'title' => 'required',
        //     'image' => 'required|image|mimes:png,jpg',
        //     'content' => 'required'
        // ],['title.required'=>'title Req','content.required' => 'Cont is req']);

        // if($validator->fails()){
        //     return redirect()->back()
        //     ->withErrors($validator)->withInput();
        // }

            // Method #3 using PostRequest


        // 2->  Upload files (images)
        // $path = $request->file('image')->store('uploads','public');
        $path = $request->file('image')->store('/','custom');

        // dd($path);
        // exit;

        // 3-> Save in Database
        // $request->merge([
        //     'slug' => Str::slug($request->title)
        // ]);

        // $post = Post::create($request->all());
            // الطريقة الأولى للتخزين في قاعدة البيانات
        // $post = new Post();
        // $post->title = $request->title;
        // $post->slug = Str::slug($request->title);
        // $post->image = $path;
        // $post->content = $request->content;
        // $post->user_id = 1;
        // $post->save();

        $title =$this->removescript($request->title);
        Post::create([

            'title' => $title,
            'slug' => Str::slug($title),
            'image' => $path,
            'content' => $this->removescript($request->content),
            'user_id' => 1,
        ]);


        // 4-> Redirect to index   (PGR Post Redirect Get)
        return redirect()->route('admin.posts.index')->with('success','Post Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // $posts = Post::findOrFail($id);

        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(postRequest $request, Post $post)
    {
        $path = $post->image;
        if($request->hasFile('image')){
            $path = $request->file('image')->store('/','custom');
        }
        $title =$this->removescript($request->title);

        $post->update([
            'title' => $title,
            'image' => $path,
            'content' => $this->removescript($request->content),
            'deleted_by' => 1,
        ]);


        // 4-> Redirect to index   (PGR Post Redirect Get)
        return redirect()->route('admin.posts.index')->with('success','Post Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Post::destroy($id);

        return Redirect::route('admin.posts.index')
        ->with('delete','Category Deleted');
    }

    public function trash(){

        $posts = Post::onlyTrashed()->orderBy('id','Desc')->paginate(5);
        return view('admin.posts.trash',compact('posts'));
    }

    public function restore(Post $post){
        $post->restore();
        return redirect()->back();


        // $category = Category::onlyTrashed()->findOrFail($id);
        // $category->restore();
    }

    public function forcedelete(Post $post){
        File::delete(public_path('uploads/'.$post->image));
        $post->forcedelete();
        // $post->update(['deleted_at' => 'null']);
        return redirect()->back();
    }

    private function removescript($input)
    {
        $input = str_replace('<script>','',$input);
        return str_replace('</script>','',$input);
    }
}
