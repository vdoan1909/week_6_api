@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Xin chao`: {{ Auth::user()->name }}</div>

                    <div class="card-body">
                        <div class="card" style="width: 18rem;">
                            @if (isset(Auth::user()->avatar))
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" class="card-img-top"
                                    alt="{{ Auth::user()->name }}">
                            @else
                                <img src="https://i1.sndcdn.com/artworks-ECfBpscAgzofi8Op-iGoyXQ-t500x500.jpg"
                                    class="card-img-top" alt="{{ Auth::user()->name }}">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">Name: {{ Auth::user()->name }}</h5>
                                <p class="card-text">
                                    Date Of Birth:
                                    @if (isset(Auth::user()->date_of_birth))
                                        {{ Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('d/m/Y') }}
                                    @endif
                                </p>
                                <p class="card-text">{{ Auth::user()->bio }}</p>
                            </div>

                            <a href="{{ route('admin.users.edit') }}" class="btn btn-primary">Update profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
