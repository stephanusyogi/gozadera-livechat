@extends('layout.app')

@section('main')
<main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">Add New Administrator</h2>
                </div>
                <div class="right-part"></div>
            </div>
            <div class="card border-0">
                <div class="card-body pt-3">
                    <form id="addAdminForm" action="{{ route('all-administrator.add-action') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label @if ($errors->has('name')) text-danger @elseif(old('name') && !$errors->has('name'))text-success @endif">Name</label>
                                    <input type="text" class="form-control @if ($errors->has('name')) is-invalid text-danger @elseif(old('name') && !$errors->has('name')) is-valid text-success @endif" id="name" value="{{ old('name') }}" name="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username" class="form-label @if ($errors->has('username')) text-danger @elseif(old('username') && !$errors->has('username')) text-success @endif">Username</label>
                                    <input type="text" class="form-control @if ($errors->has('username')) is-invalid text-danger @elseif(old('username') && !$errors->has('username')) is-valid text-success @endif" id="username" value="{{ old('username') }}" name="username" placeholder="Username">
                                    @error('username')
                                        <small class="mt-2 text-danger float-start">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="type" class="@if ($errors->has('type')) text-danger @elseif(old('type') && !$errors->has('type')) text-success @endif">Type</label>
                                <select class="form-control form-control @if ($errors->has('type')) border-danger @elseif(old('type') && !$errors->has('type')) border-success @endif" id="type" name="type">
                                    <option value="">Choose Type...</option>
                                    <option value="Super Admin" {{ old('type') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="Basic Admin" {{ old('type') == 'Basic Admin' ? 'selected' : '' }}>Basic Admin</option>
                                </select>
                                @error('type')
                                    <small class="mt-2 text-danger float-start">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="@if ($errors->has('password')) text-danger @elseif(old('password') && !$errors->has('password')) text-success @endif">Password</label>
                                <input type="password" class="form-control @if ($errors->has('password')) is-invalid text-danger @elseif(old('password') && !$errors->has('password')) is-valid text-success @endif" id="password" placeholder="Password" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <small class="mt-2 text-danger float-start">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="@if ($errors->has('password_confirmation')) text-danger @elseif(old('password_confirmation') && !$errors->has('password_confirmation')) text-success @endif">Password Confirmation</label>
                                <input type="password" class="form-control @if ($errors->has('password_confirmation')) is-invalid text-danger @elseif(old('password_confirmation') && !$errors->has('password_confirmation')) is-valid text-success @endif" id="password_confirmation" placeholder="Password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <small class="mt-2 text-danger float-start">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection