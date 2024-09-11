@extends('layout.app')

@section('main')
<main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">Update Table</h2>
                </div>
                <div class="right-part"></div>
            </div>
            <div class="card border-0">
                <div class="card-body pt-3">
                    <form id="addTableForm" action="{{ route('all-table.edit-action', $data_table->id) }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label @if ($errors->has('name')) text-danger @elseif(old('name') && !$errors->has('name'))text-success @endif">Name</label>
                                    <input type="text" class="form-control @if ($errors->has('name')) is-invalid text-danger @elseif(old('name') && !$errors->has('name')) is-valid text-success @endif" id="name" value="{{ old('name') ? old('name') : $data_table->name }}" name="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="code" class="form-label @if ($errors->has('code')) text-danger @elseif(old('code') && !$errors->has('code')) text-success @endif">Table Code</label>
                                    <input type="text" class="form-control @if ($errors->has('code')) is-invalid text-danger @elseif(old('code') && !$errors->has('code')) is-valid text-success @endif" id="code" value="{{ old('code') ? old('code') : $data_table->code }}" name="code" placeholder="Table Code">
                                    @error('code')
                                        <small class="mt-2 text-danger float-start">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
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