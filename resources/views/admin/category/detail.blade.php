@extends('layout.admin')

@section('title', "Detail Category: $category->name ")

@section('main')
    <div class="container-fluid">
        <div class="heading">
            <p>Products Quantity: {{ $category->products->count() }}</p>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category->products as $prod)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{ $prod->id }}</td>
                        <td>{{ $prod->name }}</td>
                        <td>{{ $prod->price }}</td>
                        <td>{{ $prod->sale_price }}</td>
                        <td style="width: 10%;">
                            <img src="/uploads/{{ $prod->image }}" alt="" class="card-img">
                        </td>
                        <td>
                            {{ $catgory->name }}
                        </td>
                        <td>{!! $prod->status == 1
                            ? "<span class='badge badge-success rounded-0'>Show</span>"
                            : "<span class='badge badge-danger rounded-0'>Hide</span>" !!}
                        </td>
                        <td>
                            {{ $prod->description }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
