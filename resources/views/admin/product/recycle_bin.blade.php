@extends('layout.admin')

@section('title', 'Product')

@section('main')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-primary fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('message') }}</strong>
            </div>

            <script>
                $(".alert").alert();
            </script>
        @endif
        <table class="table mt-3 table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>HandleAction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $prod)
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
                            {{ $prod->categories->name }}
                        </td>
                        <td>{!! $prod->status == 1
                            ? "<span class='badge badge-success rounded-0'>In Stock</span>"
                            : "<span class='badge badge-danger rounded-0'>Out Of Stock</span>" !!}
                        </td>
                        <td>
                            {{ $prod->description }}
                        </td>
                        <td style="width: 20%;">
                            <form action="{{ route('product.force_delete', $prod->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <a href="{{ route('product.restore', $prod->id) }}"
                                    class="btn btn-outline-success rounded-0"><i class="fa fa-trash-restore"></i></a>
                                <button type="submit" class="btn btn-outline-danger rounded-0"
                                    onclick="return confirm('Do you want to force delete this item ?')">
                                    <i class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
