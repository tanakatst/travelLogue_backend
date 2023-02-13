<?php

namespace App\Http\Controllers;
use App\Services\Utilities\UtilityService;
use App\Models\Post;
use App\Models\PostImage;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{

    public function index(Request $request){
        $posts = Post::where('user_id', '=', \Auth::id())->get();

    //    呼び出したpostのidをpost_idとして持っている画像データをそれぞれ用意して、postとセットで返す処理を記述
        $post_ids = Post::where('user_id', \Auth::id())->get('id');
        $posts_images_data = Post::where('user_id', '=' ,\Auth::id())->with('images')->get();
       return response()->json($posts_images_data);
    }

    public function store(Request $request){
        // $service = new UtilityService();
        // $bucket = $client->bucket('travellogue'); // 作成したバケット名
        $dir = '/images';
        $post = Post::create([
            "title"=> $request->title,
            "prefecture" => $request->prefecture,
            "content"=> $request->content,
            "user_id"=> \Auth::id()
        ]);
        $post_id = $post->id;
        if($request->hasFile('photos')){
            $photos = $request->file('photos');
            foreach($photos as $index => $photo){
                $photo_name = $photo->getClientOriginalName();
                $photo->storeAs('public/' . $dir, $photo_name);
                $post_image = PostImage::create([
                    'name' => $photo->getClientOriginalName(),
                    'path' => 'http://localhost:8888/storage/' .$dir . '/' . $photo_name,
                    'post_id' => $post_id
                ]);
            }
        }
        return response()->json('投稿完了', 200);
        // return response()->json($request, 200);
    }
    public function update(Request $request, Post $post){
        {
            echo($request);
            $post->title = $request->title;
            $post->prefecture = $request->prefecture;
            $post->content = $request->content;
            return $post->update()
                ?response()->json($post)
                :response()->json([],500);
        }
    }
    public function destroy(Post $post)
    {
        return $post->delete()
            ? response()->json($post)
            : response()->json([],500);
    }
}







