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
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="{{ route('product.create') }}" class="btn btn-outline-primary rounded-0" title="Add New Product"><i
                        class="fa fa-plus"></i></a>
                <a href="{{ route('product.recycle_bin') }}" class="btn btn-outline-warning rounded-0" title="RecycleBin"><i
                        class="fa fa-trash"></i></a>
            </div>
            <div class="col-lg-4">
                <form action="" method="get">
                    <label for="order">FilterBy</label>
                    <div class="form-group d-flex">
                        <select class="form-control rounded-0" name="order" id="order">
                            <option value="">------Order By------</option>
                            <option value="id-DESC">ID (High - Low)</option>
                            <option value="id-ASC">ID (Low - High)</option>
                            <option value="name-DESC">Name (z - a)</option>
                            <option value="name-ASC">Name (a - z)</option>
                            <option value="price-DESC">Price (High - Low)</option>
                            <option value="price-ASC">Price (Low - High)</option>
                        </select>
                        <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-filter"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <form action="" method="get">
                    <label for="keyword">Search</label>
                    <div class="form-group d-flex">
                        <input type="text" class="form-control rounded-0" id="keyword" name="keyword"
                            placeholder="Search...">
                        <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>


        </div>

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
                            <form action="{{ route('product.destroy', $prod->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <a href="{{ route('product.edit', $prod->id) }}"
                                    class="btn btn-outline-success rounded-0"><i class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-outline-danger rounded-0"><i
                                        class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
