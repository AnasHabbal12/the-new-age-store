@extends('layout.dashboard')
@section('title','Products')

@section('breadcrumb')

<li class="breadcrumb-item active">Products</li>
@parent
@endsection

@section('content')
    
    <a href="{{ route('dashboard.categories.create')}}" class="btn btn-lg btn-outline-primary">New Product</a>
    <a href="{{-- route('dashboard.categories.trash') --}}" class="btn btn-lg btn-outline-primary">Trash</a>
    <br/><br/>
    <x-alert type="success"/>
    <x-alert type="info"/>

     @if($products -> count())

    <form action="" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <br/>
        <select name="status" class="form-control mx-2">
            <option value="">All </option>
            <option value="active" @selected(request('status') == 'active')>Active </option>
            <option value="archived" @selected(request('status') == 'archived')>Archived </option>
        </select>
        <br/>
        <div class="container"><button class="btn btn-dark mx-2">Filter</button></div>
        <br/>
    </form>
          <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->category()->first('name')}}</td>
                        <td>{{$product->store->name}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->status}}</td>
                        <td><a href="{{ route('dashboard.products.edit', $product->id)}}" class="btn btn-sm btn-outline-success">Edit</a></td>
                        <td>
                            <form action="{{ route('dashboard.categories.destroy', $product->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                        <td>
                            <img src="{{ asset('storage/'.$product->img ) }}" alt="there is no image" width="50px">
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          
          @else
          <div class=" container">
              <h4>There is no any Product</h4>
          </div>
          @endif
          
{{ $products->withQueryString()->appends(['search'=> 1])->links() }}
@endsection
