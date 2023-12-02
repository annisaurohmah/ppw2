@extends('auth.layout')

@section('menubar')
<div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav mx-auto py-0">
        <a href="{{ route('landing') }}#home" class="nav-item nav-link">Home</a>
        <a href="{{ route('landing') }}#about" class="nav-item nav-link">About</a>
        <a href="{{ route('landing') }}#myworks" class="nav-item nav-link">My Works</a>
        <a href="{{ route('landing') }}#contact" class="nav-item nav-link">Contact</a>
        <a href="{{ route('gallery.index') }}" class="nav-item nav-link active">Gallery</a>
        <a href="{{ route('galleryapi.index') }}" class="nav-item nav-link">API Documentation</a>

    </div>
    @guest
    <a href="{{ route('register') }}" class="btn btn-reg btn-secondary-gradient rounded-pill py-2 px-4 d-none d-lg-block {{ (request()->is('register')) ? 'active' : '' }}">Register</a>
    <a href="{{ route('login') }}" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-1 d-none d-lg-block {{ (request()->is('register')) ? 'active' : '' }}">Login</a>
    @else
    <div class="nav-item text-white dropdown">
        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item text-white">
                <a class="dropdown-item" href="{{ route('users') }}">Management Users</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    @endguest

</div>
@endsection

@section('content')

<div class="container-xxl bg-primary hero-header">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div class="card stroke-white bg-primary-gradient text-white">
                        <div class="card-header d-flex justify-content-between align-items-center stroke-white">Edit Image</div>
                        <div class="card-body">
                            <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $title }}">
                                        @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                                    <div class="col-md-6">
                                        <input type="desrciption" class="form-control @error('description') is-invalid @enderror" id="desrciption" name="description" value="{{ $description }}">
                                        @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('desceiption') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">Recent Picture</label>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/posts_image/'.$gallery->picture) }}" alt="" height="100px">
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="picture">
                                        @if ($errors->has('photo'))
                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="mb-3 row g-2">
                                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary-gradient" value="Save">
                                    <a href="/gallery" class="col-md-3 offset-md-5 btn btn-danger"> Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 

@endsection