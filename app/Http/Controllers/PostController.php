<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\CommentImage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use MeiliSearch\Client;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Hàm lấy danh sách toàn bộ bài viết
     * @param
     * @return $posts
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function index()
    {
        //
        $posts = Post::with(['user', 'status', 'postImage'])->get();

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Hàm lưu bài viết mới
     * @param Request $request
     * @return $users
     * CreatedBy: youngbachhh (04/04/2024)
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'address' => 'required',
        //     'area' => 'required',
        //     'price' => 'required',
        //     'unit' => 'required',
        //     'sold_status' => 'required',
        //     'user_id' => 'required',
        //     'status_id' => 'required'
        // ]);

        $post = Post::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'address' => $request->address,
                'address_detail' => $request->address_detail,
                'area' => $request->area,
                'price' => $request->price,
                'direction' => $request->direction ?? 0,
                'unit' => $request->unit,
                'sold_status' => $request->sold_status,
                'user_id' => $request->user_id,
                'status_id' => $request->status_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        Redis::del('posts:pending');
        Redis::del('posts:not-pending');


        return response()->json($post, 201);
    }

    /**
     * Hàm lấy thông tin bài viết theo id
     * @param Request $request
     * @return $users
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function show($id)
    {
        $post = Redis::get('post:' . $id);

        if ($post === null) {
            $post = Post::with([
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
                'status' => function ($query) {
                    $query->select('id', 'name');
                },
                'postImage' => function ($query) {
                    $query->select('id', 'post_id', 'image_path');
                },
                'comment' => function ($query) {
                    $query->select('id', 'post_id', 'user_id', 'content', 'created_at')->orderBy('created_at', 'desc');
                },
                'comment.user' => function ($query) {
                    $query->select('id', 'name');
                },
                'comment.commentImage'
            ])->findOrFail($id);


            Redis::set('post:' . $id, json_encode($post));
            Redis::expire('post:' . $id, 3600);
        } else {
            $post = json_decode($post);
        }


        return response()->json($post, 200);
    }

    /**
     * Hàm lấy ra danh bài viết đang chờ duyệt
     * @param
     * @return $posts
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function pending()
    {
        $posts = Redis::get('posts:pending');

        if ($posts === null) {
            $posts = Post::with(['user' => function ($query) {
                $query->select('id', 'name');
            }, 'status' => function ($query) {
                $query->select('id', 'name');
            }, 'postImage'])->where('status_id', 3)
                ->orderBy('created_at', 'desc')
                ->get();

            Redis::set('posts:pending', json_encode($posts));
            Redis::expire('posts:pending', 3600);
        } else {
            $posts = json_decode($posts);
        }

        return response()->json($posts, 200);
    }

    /**
     * Hàm lấy ra danh bài viết không phải đang chờ duyệt
     * @param
     * @return $posts
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function notPending()
    {
        $posts = Redis::get('posts:not-pending');

        if ($posts === null) {
            $posts = Post::with(['user' => function ($query) {
                $query->select('id', 'name');
            }, 'status' => function ($query) {
                $query->select('id', 'name');
            }, 'postImage'])
                ->where('status_id', '!=', 3)
                ->orderBy('created_at', 'desc')
                ->get();

            Redis::set('posts:not-pending', json_encode($posts));
            Redis::expire('posts:not-pending', 3600);
        } else {
            $posts = json_decode($posts);
        }

        return response()->json($posts, 200);
    }

    /**
     * Hàm lọc bài viết theo giá và diện tích
     * @param Request $request
     * @return $posts
     * CreatedBy: youngbachhh (23/04/2024)
     */
    public function filter(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $priority = $request->priority;


        // Initialize the query
        $postsQuery = Post::with(['user:id,name', 'status:id,name', 'postImage'])
            ->when(!$request->filled('address'), function ($query) {
                $query->where('status_id', '!=', 3);
            })
            ->when($request->filled('priority') && $priority !== 'all', function ($query) use ($priority) {
                $query->where('priority_status', $priority);
            })
            ->orderBy('created_at', 'desc');

        // Address search
        if ($request->filled('address')) {
            $postsQuery = $this->applyAddressFilter($postsQuery, $request->address);
        }

        // Apply filters
        $postsQuery = $this->applyFilters($postsQuery, $request);

        // Apply pagination
        $posts = $postsQuery->paginate($pageSize, ['*'], 'page', $page);

        return response()->json($posts, 200);
    }

    private function applyAddressFilter($query, $address)
    {
        // $searchResults = Post::search('"' . $address . '"')->raw()['hits'];
        // $postIds = collect($searchResults)->pluck('id')->toArray();
        // Log::info("Address " . $address);
        // Log::info($searchResults);

        // return $query->whereIn('id', $postIds);
        $query->where(function ($query) use ($address) {
            $query->where('title', 'LIKE', '%' . $address . '%')
                ->orWhere('address', 'LIKE', '%' . $address . '%')
                ->orWhere('address_detail', 'LIKE', '%' . $address . '%');
        });
        Log::info("Address: " . $address);

        return $query;
    }

    private function applyFilters($query, Request $request)
    {
        $defaultMinArea = 0;
        $defaultMaxArea = 1000;
        $defaultMinPrice = 0;
        $defaultMaxPrice = 60000000000;

        // Price range filter
        if ($request->filled(['min_price', 'max_price'])) {
            $minPrice = $request->input('min_price', $defaultMinPrice);
            $maxPrice = $request->input('max_price', $defaultMaxPrice);
            if ($minPrice != $defaultMinPrice || $maxPrice != $defaultMaxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }

        // Area range filter
        if ($request->filled(['min_area', 'max_area'])) {
            $minArea = $request->input('min_area', $defaultMinArea);
            $maxArea = $request->input('max_area', $defaultMaxArea);
            if ($minArea != $defaultMinArea || $maxArea != $defaultMaxArea) {
                $query->whereBetween('area', [$minArea, $maxArea]);
            }
        }

        // Directions filter
        if ($request->filled('dirs') && is_array($request->dirs)) {
            $query->whereIn('direction', $request->dirs);
        }

        return $query;
    }



    /**
     * Hàm lấy ra danh sách bài viết theo user_id
     * @param Request $request
     * @return $posts
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function getPostByUser($id)
    {
        $posts = Post::with([
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'postImage'
        ])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Hàm cập nhật thông tin bài viết theo id
     * @param Request $request, Post $post
     * @return $posts
     * CreatedBy: youngbachhh (31/03/2024)
     */

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update(
            [
                'title' => $request->title,
                'description' => $request->description,
                'address' => $request->address,
                'address_detail' => $request->address_detail,
                'area' => $request->area,
                'price' => $request->price,
                'direction' => $request->direction ?? 0,
                'unit' => $request->unit,
                'sold_status' => $request->sold_status,
                'status_id' => $request->status_id,
                'priority_status' => $request->priority_status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
        if (Redis::exists('post:' . $id)) {
            Redis::del('post:' . $id);
            Redis::del('posts:pending');
            Redis::del('posts:not-pending');
        }
        return response()->json($post, 200);
    }

    public function updateStatus($id)
    {
        $post = Post::find($id);
        $post->status_id = 4;
        $post->update(
            [
                'status_id' => $post->status_id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
        if (Redis::exists('post:' . $id)) {
            Redis::hset('post:' . $post->id, [
                'status_id' => $post->status_id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        Redis::del('posts:pending');
        Redis::del('posts:not-pending');
        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }


    /**
     * Hàm xóa bài viết theo id
     * @param Post $post
     * @return message
     * CreatedBy: youngbachhh (31/03/2024)
     */
    public function destroy($id)
    {
        if (Redis::get('post:' . $id) !== null) {
            Redis::del('post:' . $id);
        }
        Redis::del('posts:pending');
        Redis::del('posts:not-pending');
        $directoryName = 'post-' . $id;
        $post = Post::find($id);
        $images = $post->postImage;
        $comments = Comment::where('post_id', $id)->get();
        $commentImages = CommentImage::where('post_id', $id)->get();

        foreach ($commentImages as $commentImage) {
            $commentImage->delete();
        }

        foreach ($comments as $comment) {
            $comment->delete();
        }
        foreach ($images as $image) {
            $image->delete();
            Storage::delete('public/upload/images/posts/' . $directoryName . '/' . basename($image->image_path));
        }

        $post->delete();
        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
