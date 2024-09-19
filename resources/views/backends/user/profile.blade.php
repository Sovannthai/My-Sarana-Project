@extends('backends.master')
@section('title', 'Profile')
<style>
    .card-hover {
        transition: 0.5s;
    }

    .card-hover:hover {
        transform: 5s;
        transform: translateY(-15px);
    }
</style>
@section('content-header','Profile')
@section('contents')
    {{-- <div class="text-center">
        <h3>@lang('Profile')</h3>
    </div> --}}
    <div class="row card-hover">
        <div class="col-md-12">
            <div class="card card-profile">
                <div class="card-header" style="background-image: url('{{ asset('backends/assets/img/blogpost.jpg') }}')">
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            <a class="example-image-link" href="{{ auth()->user()->image ? asset('uploads/all_photo/' . auth()->user()->image) : auth()->user()->avatar }}"
                                data-lightbox="lightbox-' . $user->id . '">
                                <img class="example-image image-thumbnail"
                                    src="{{ auth()->user()->image ? asset('uploads/all_photo/' . auth()->user()->image) : auth()->user()->avatar }}" alt="profile" width="90px"
                                    height="90px" style="cursor:pointer" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name"><b>@lang('Name')</b>: {{ $user->name }}</div>
                        <div class="email"><b>@lang('Email')</b>: {{ $user->email }}</div>
                        <div class="role"><b>@lang('Role')</b>: {{ $user->roles->first()->name }}</div>
                        {{-- <div class="desc">A man who hates loneliness</div> --}}
                        <div class="social-media mt-2">
                            <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                <span class="btn-label just-icon"><i class="icon-social-twitter"></i>
                                </span>
                            </a>
                            <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="icon-social-facebook"></i>
                                </span>
                            </a>
                            <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="icon-social-instagram"></i>
                                </span>
                            </a>
                        </div>
                        {{-- <div class="view-profile">
                        <a href="#" class="btn btn-secondary w-100">View Full Profile</a>
                    </div> --}}
                    </div>
                </div>
                {{-- <div class="card-footer">
                <div class="row user-stats text-center">
                    <div class="col">
                        <div class="number">125</div>
                        <div class="title">Post</div>
                    </div>
                    <div class="col">
                        <div class="number">25K</div>
                        <div class="title">Followers</div>
                    </div>
                    <div class="col">
                        <div class="number">134</div>
                        <div class="title">Following</div>
                    </div>
                </div>
            </div> --}}
            </div>
        </div>
    </div>
@endsection
