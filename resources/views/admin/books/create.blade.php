@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="form-group" action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title">
                        @error('title')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label class="form-label" for="author">Author</label>
                        <input class="form-control" type="text" name="author" id="author">
                        @error('author')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" placeholder="Description" id="description" name="description"></textarea>
                        @error('description')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label class="form-label" for="cover_image">Cover Image</label>
                        <input class="form-control" type="file" name="cover_image" id="cover_image">
                        @error('cover_image')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-secondary w-100">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
