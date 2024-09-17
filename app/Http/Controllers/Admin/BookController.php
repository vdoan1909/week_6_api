<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    const PATH_VIEW = 'admin.books.';
    const PATH_UPLOAD = 'covers';

    public function index()
    {
        $data = Book::latest('id')->paginate(3);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(CreateBookRequest $request)
    {
        $data = $request->except('cover_image');
        // dd($data);
        // dd($request->cover_image);

        try {
            $book = Book::create($data);
            // dd($book);

            if ($book && $request->cover_image) {
                $data['cover_image'] = Storage::put(self::PATH_UPLOAD, $request->cover_image);
                $book->cover_image = $data['cover_image'];
                $book->save();
            }

            notify()->success('Book created successfully!', 'Success');
            return redirect()->route('admin.books.index');
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $book = Book::find($id);
            if (!$book) {
                Log::error('Book not found');
                abort(404, 'Book not found');
            }
            return view(self::PATH_VIEW . __FUNCTION__, compact('book'));
        } catch (\Exception $e) {
            Log::error('Error in edit method: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(UpdateBookRequest $request, $id)
    {
        try {
            $data = $request->except('cover_image');
            $book = Book::find($id);

            if (!$book) {
                Log::error('Book not found');
                abort(404, 'Book not found');
            }

            $current_image = $book->cover_image;
            $is_update = $book->update($data);

            if ($is_update && $request->cover_image) {
                if (Storage::exists($current_image)) {
                    Storage::delete($current_image);
                }

                $data['cover_image'] = Storage::put(self::PATH_UPLOAD, $request->cover_image);
                $book->cover_image = $data['cover_image'];
                $book->save();
            }

            notify()->success('Book updated successfully!', 'Success');
            return redirect()->route('admin.books.index');
        } catch (\Exception $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::find($id);
            if (!$book) {
                Log::error('Book not found');
                abort(404, 'Book not found');
            }

            $current_image = $book->cover_image;
            if (Storage::exists($current_image)) {
                Storage::delete($current_image);
            }

            $book->delete();
            notify()->success('Book deleted successfully!', 'Success');
            return redirect()->route('admin.books.index');
        } catch (\Exception $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->search;
            // $data = Book::search($search)->paginate(3);
            $data = Book::whereFullText(['title', 'author'], $search)->paginate(3);
            // dd($data);
            return view(self::PATH_VIEW . 'index', compact('data', 'search'));
        } catch (\Exception $e) {
            Log::error('Error in search method: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
