<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    const PATH_UPLOAD = 'covers';

    public function index()
    {
        $data = Book::latest('id')->paginate(3);
        return new BookCollection($data);
    }

    public function store(CreateBookRequest $request)
    {
        $data = $request->validated();

        $book = Book::create($data);

        if ($book) {
            if ($request->cover_image) {
                $data['cover_image'] = Storage::put(self::PATH_UPLOAD, $request->cover_image);
            }

            $book->cover_image = $data['cover_image'];
            $book->save();
        }

        return new BookResource($book);
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $data = $request->validated();

        $book = Book::find($id);

        if (!$book) {
            return response()->json(
                [
                    'message' => 'Book not found',
                ],
                404
            );
        }

        $current_image = $book->cover_image;

        $is_update = $book->update($data);

        if ($is_update && $request->cover_image) {
            if (Storage::exists($current_image)) {
                Storage::delete($current_image);

                $data['cover_image'] = Storage::put(self::PATH_UPLOAD, $request->cover_image);
            }

            $book->cover_image = $data['cover_image'];
            $book->save();
        }

        return new BookResource($book);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $current_image = $book->cover_image;

        if (Storage::exists($current_image)) {
            Storage::delete($current_image);
        }

        if (!$book) {
            return response()->json(
                [
                    'message' => 'Book not found',
                ],
                404
            );
        }

        $book->delete();

        return response()->json(
            null,
            204
        );
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $data = Book::search($search)->paginate(3);
        }

        // dd($data);

        return new BookCollection($data);
    }
}
