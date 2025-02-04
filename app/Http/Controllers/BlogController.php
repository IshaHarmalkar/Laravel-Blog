<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Keep this only at the top

class BlogController extends Controller
{
    public function index()
    {
         $blogs = Blog::all()->map(function ($blog) {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'content' => $blog->content,
            'author' => $blog->author,
            'created_at' => $blog->created_at,
            'image_url' => $blog->image_url 
                ? asset('storage/images/' . $blog->image_url) 
                : asset('images/default-placeholder.jpg'), // Default image
        ];
    });

    return response()->json($blogs);
    }

    public function store(Request $request)
{
    Log::info("Entering store method");

    // Validate the form data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'author' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imageName = null; // Default to null if no image is uploaded

    // Check if image file is provided
    if ($request->hasFile('image')) {
        Log::info('Image received: ' . $request->file('image')->getClientOriginalName());

        // Store the image in the 'public/images' directory
    $imagePath = $request->file('image')->store('images', 'public');


        // Extract only the filename
        $imageName = basename($imagePath); // e.g., 'Pwu1XWME3Hoov9YnToWvUosHItRQ49vdcUbz.jpg'

        Log::info("Stored image filename: " . $imageName);
    } else {
        Log::info('No image received.');
    }

    // Create the blog post in the database
    $blog = Blog::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'author' => $validated['author'],
        'image_url' => $imageName, // Stores only the filename or null if no image
    ]);

    // Return the response with the created blog
    return response()->json([
        'message' => 'Blog post created successfully!',
        'blog' => $blog,
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response()->json($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($blog->image_url) {
                $oldImagePath = str_replace('/storage/', '', $blog->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store new image
            $path = $request->file('image')->store('blog_images', 'public');
            $validatedData['image_url'] = "/storage/$path";
        }

        $blog->update($validatedData);
        return response()->json(['message' => 'Blog updated successfully', 'blog' => $blog], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Delete the image if it exists
        if ($blog->image_url) {
            $oldImagePath = str_replace('/storage/', '', $blog->image_url);
            Storage::disk('public')->delete($oldImagePath);
        }

        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
}
