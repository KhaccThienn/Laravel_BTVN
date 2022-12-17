@extends('layout.admin')

@section('title', 'Update Category')

@section('main')
    <div class="container">
        <form action="{{ route('category.update', $cat->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $cat->id }}">
            <div class="form-group">
                <label for="namee">Category's Name</label>
                <input type="text" name="name" id="name"
                    class="form-control rounded-0 @error('name') is-invalid @enderror"
                    value="{{ $cat->name ?? old('name') }}" placeholder="Category's Name">
                @error('name')
                    <span class="help-text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Status</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="status" id="status" value="1"
                            {{ $cat->status == 1 ? 'checked' : '' }}>
                        Show
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="status" id="status0" value="0"
                            {{ $cat->status == 0 ? 'checked' : '' }}>
                        Hide
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-success rounded-0 btn-block">Add</button>
        </form>
    </div>
@endsection
