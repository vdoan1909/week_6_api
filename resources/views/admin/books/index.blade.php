@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.books.create') }}" class="btn btn-secondary">Create</a>

                    <div class="d-flex justify-content-end align-items-center gap-2">
                        @if (isset($search))
                            <a href="{{ route('admin.books.index') }}" class="btn-close" aria-label="Close"></a>
                        @endif

                        <form class="form-group d-flex gap-2" action="{{ route('admin.books.search') }}"
                            method="post">
                            @csrf

                            <input class="form-control" type="text" name="search" value="{{ $search ?? '' }}"
                                placeholder="Search by title or author...">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </form>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Title</th>
                            <th>Cover Image</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Manage</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <img width='100' src="{{ Storage::url($item->cover_image) }}" alt="">
                                </td>
                                <td>{{ $item->author }}</td>
                                <td>{{ Str::limit($item->description, 69) }}</td>
                                <td>
                                    <a href="{{ route('admin.books.edit', $item->id) }}"
                                        class="btn btn-warning mb-2">Edit</a>

                                    <form action="{{ route('admin.books.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Yet sure???')" type="submit"
                                            class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
