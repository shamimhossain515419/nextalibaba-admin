<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $blogs = Blog::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.blog.show', compact('blogs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('pages.blog.create', compact('categories'));
    }

    public function show($id)
    {
        $categories = BlogCategory::all();
        $blog = Blog::with('category')->find($id);
        return view('pages.blog.edit', compact('categories', 'blog'));
    }


    public function allBlog(Request $request)
    {
        try {
            $limit = $request->limit ?? 10;
            $blogs = Blog::with('category')
                ->where('status', 1)
                ->paginate($limit);

            return response()->json([
                'success' => true,
                'message' => 'Blog fetched successfully',
                'data' => $blogs,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching blogs',
                'error' => $e->getMessage(), // remove in production if needed
            ], 500);
        }
    }

    public function allBlogCategory(Request $request)
    {
        try {
            $categories = BlogCategory::all();

            return response()->json([
                'success' => true,
                'message' => 'Category fetched successfully',
                'data' => $categories,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Store blog
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'content' => 'required',
            'category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid('blog_', true) . '.' . $image->extension();
                $image->move(public_path('storage/images'), $imageName);
                $imagePath = 'images/' . $imageName;
            }

            $slug = Str::slug($request->title);
            if (Blog::where('slug', $slug)->exists()) {
                $slug .= '-' . uniqid();
            }

            Blog::create([
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'status' => $request->has('status'),
                'author' => auth()->id(),
                'image' => $imagePath,
            ]);

            DB::commit();

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();

        return view('pages.blog.edit', compact('blog', 'categories'));
    }

    public function getSingleProductBySlug($slug)
    {

        try {
            $blog = Blog::where('slug',$slug)->first();
            return response()->json([
                'success' => true,
                'message' => 'Blog fetched successfully',
                'data' => $blog,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching categories',
                'error' => $e->getMessage(),
            ], 500);
        }


    }

    /**
     * Update blog
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title,' . $blog->id,
            'content' => 'required',
            'category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                // delete old image
                if ($blog->image && File::exists(public_path('storage/' . $blog->image))) {
                    File::delete(public_path('storage/' . $blog->image));
                }

                $image = $request->file('image');
                $imageName = uniqid('blog_', true) . '.' . $image->extension();
                $image->move(public_path('storage/images'), $imageName);
                $blog->image = 'images/' . $imageName;
            }

            if ($blog->title !== $request->title) {
                $slug = Str::slug($request->title);
                if (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $blog->slug = $slug;
            }

            $blog->update([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'status' => $request->has('status'),
            ]);

            DB::commit();

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete blog
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && File::exists(public_path('storage/' . $blog->image))) {
            File::delete(public_path('storage/' . $blog->image));
        }

        $blog->delete();

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }

}
