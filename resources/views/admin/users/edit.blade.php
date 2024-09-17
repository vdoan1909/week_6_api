@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Profile: {{ Auth::user()->name }}</h3>

                <form class="form-group" action="{{ route('admin.users.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mt-3">
                        <label class="form-label" for="bio">Bio</label>
                        <input class="form-control" type="text" name="bio" id="bio"
                            value="{{ Auth::user()->bio ?? '' }}">
                        @error('bio')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="date_of_birth">Date of birth</label>
                        <input class="form-control" type="date" name="date_of_birth" id="date_of_birth"
                            value="{{ Auth::user()->date_of_birth ?? '' }}">
                        @error('date_of_birth')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="avatar">Avatar</label>
                        <input class="form-control" type="file" name="avatar" id="avatar">
                        @error('avatar')
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
