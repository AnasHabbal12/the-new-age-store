@extends('layout.dashboard')
@section('title','categories')

@section('breadcrumb')

<li class="breadcrumb-item active">Categories</li>
@parent
@endsection

@section('content')
    @if(Auth::user()->can('categories.create'))
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-lg btn-outline-primary">New Ctegory</a>
    @endif
    <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-lg btn-outline-primary">Trash</a>
    <br/><br/>
    <x-alert type="success"/>
    <x-alert type="info"/>

     @if($categories -> count())

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
                    <th>Category from</th>
                    <th>Created At</th>
                    <th>Statud</th>
                    <th>Product Numbers</th>
                    @can('categories.update')
                    <th></th>
                    @endcan
                    @can('categories.delete')
                    <th></th>
                    @endcan
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td><a href="{{route('dashboard.categories.show', $category->id)}}">{{$category->name}}</a></td>
                        <td>{{$category->parent ? $category->parent->name : '-'}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>{{$category->status}}</td>
                        <td>{{$category->products_count}}</td>
                        @can('categories.update')
                        <td>
                            <a href="{{ route('dashboard.categories.edit', $category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                        @endcan
                        @can('categories.delete')
                        <td>
                            <form action="{{ route('dashboard.categories.destroy', $category->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                        <td>
                            <img src="{{ asset('storage/'.$category->img ) }}" alt="there is no image" width="50px">
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>

          @else
          <div class=" container">
              <h4>There is no any Categories</h4>
          </div>
          @endif

{{ $categories->withQueryString()->appends(['search'=> 1])->links() }}
@endsection
