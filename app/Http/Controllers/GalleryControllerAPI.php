<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator;

class GalleryControllerAPI extends Controller
{
    /**
     * @OA\Post(
     * path="/api/gallery",
     * tags={"gallery"},
     * summary="Returns a Gallery API response",
     * description="A gallery to test out the API",
     * operationId="gallery",
     * @OA\RequestBody(
     *         required=true,
     *         description="Data untuk mengunggah gambar",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     description="Judul Upload",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Deskripsi Gambar",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="picture",
     *                     description="File Gambar",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *             )
     *         )
     *     ),
     * @OA\Response(
     * response="default",
     * description="successful operation"
     * )
     * )
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('picture')) {
            // dd($request->input());
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
        $request->file('picture')->storeAs("posts_image", $smallFilename);
        $request->file('picture')->storeAs("posts_image", $mediumFilename);
        $request->file('picture')->storeAs("posts_image", $largeFilename);
        $this->createThumbnail(public_path() . "/storage/posts_image/" . $smallFilename, 150, 93);
        $this->createThumbnail(public_path() . "/storage/posts_image/" . $mediumFilename, 300, 185);
        $this->createThumbnail(public_path() . "/storage/posts_image/" . $largeFilename, 550, 340);

        // dd($request->input());
        $post = new Post;
        // dd($post);
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        // dd($post);
        $post->save();

        return redirect()->route('gallery.index');
    }

    /**
     * @OA\Get(
     * path="/api/getgallery",
     * tags={"gallery"},
     * summary="Returns a Gallery API response",
     * description="A gallery to test out the API",
     * operationId="getgallery",
     * 
     * @OA\Response(
     * response="default",
     * description="successful operation"
     * )
     * )
     */
    public function get()
    {
        $data = Post::all();
        return response()->json(["data" => $data]);
    }

    public function index()
    {
        // $response = Http::get('http://localhost:8000/api/getgallery');
        // $galleries = $response->object()->data;
        
        return redirect('api/documentation');
    }




    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
