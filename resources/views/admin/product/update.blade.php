@extends('layout.admin')

@section('title', "Update Product: $prod->name")

@section('main')
    <div class="container">
        <form action="{{ route('product.update', $prod->id) }}" method="post" enctype="multipart/form-data" role="form">
            @csrf @method('PUT')
            <input type="hidden" name="id" value="{{ $prod->id }}">
            <div class="form-group">
                <label for="name">Product's Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') ?? $prod->name }}"
                    class="form-control rounded-0 @error('name') is-invalid @enderror" placeholder="Product's Name">
                @error('name')
                    <span class="help-text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="price">Product's Price</label>
                    <input type="text" name="price" id="price" value="{{ old('price') ?? $prod->price }}"
                        class="form-control rounded-0 @error('price') is-invalid @enderror" placeholder="Product's Price">
                    @error('price')
                        <span class="help-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-lg-6">
                    <label for="sale_price">Product's Sale Price</label>
                    <input type="text" name="sale_price" id="sale_price"
                        value="{{ old('sale_price') ?? $prod->sale_price }}"
                        class="form-control rounded-0 @error('sale_price') is-invalid @enderror"
                        placeholder="Product's Sale Price">
                    @error('sale_price')
                        <span class="help-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Product's Image</label>
                <input type="file" name="image" id="image"
                    class="form-control rounded-0 @error('name') is-invalid @enderror">
                @error('image')
                    <span class="help-text text-danger">{{ $message }}</span>
                @enderror

                <div class="img" style="width: 10%;">
                    <img src="/uploads/{{ $prod->image }}" alt="" class="card-img">
                </div>
            </div>
            <div class="row align-items-end">
                <div class="form-group col-lg-6">
                    <label for="category_id">Product's Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        @foreach ($categories as $cat)
                            @if ($cat->id == $prod->category_id)
                                <option value="{{ $cat->id }}" selected>{{ $cat->id }} - {{ $cat->name }}
                                </option>
                            @else
                                <option value="{{ $cat->id }}">{{ $cat->id }} - {{ $cat->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="">Product's Status</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="status" id="status" value="1"
                                {{ $prod->status == 1 ? 'checked' : '' }}>
                            In Stock
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="status" id="status0" value="0"
                                {{ $prod->status == 0 ? 'checked' : '' }}>
                            Out Of Stock
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Product's Description</label>
                <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                    placeholder="Product's Description"></textarea>
            </div>
            <button type="submit" class="btn btn-outline-success rounded-0 btn-block">Add</button>
        </form>
    </div>
@endsection
