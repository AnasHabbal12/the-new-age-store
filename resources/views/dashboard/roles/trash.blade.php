@extends('layout.dashboard')
@section('title','Trashed Categories')

@section('breadcrumb')
<li class="breadcrumb-item">Categories</li>
<li class="breadcrumb-item active">Trashed Categories</li>
@parent
@endsection

@section('content')
    
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-lg btn-outline-primary">Categories</a>
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
                    <th>Parent</th>
                    <th>Deleted at</th>
                    <th>Statud</th>
                    <th></th>
                    <th></th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->parent_name}}</td>
                        <td>{{$category->deleted_at}}</td>
                        <td>{{$category->status}}</td>
                        <td>
                            <form action="{{ route('dashboard.categories.restore', $category->id)}}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.categories.force-delete', $category->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Force Delete</button>
                            </form>
                        </td>
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
