@extends('layout.dashboard')
@section('title','categories')

@section('breadcrumb')
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">{{$category->name}}</li>
@parent
@endsection

@section('content')
    
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-lg btn-outline-primary">Back</a>
    <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-lg btn-outline-primary">Trash</a>

    <div>
        <h2>{{$category->name}}</h2>
        <h3>{{$category->id}}</h3>
        <h4>{{$category->status}}</h4>
        <h4>{{$category->created_at}}</h4>
        <h4>{{$category->updated_at}}</h4>
        <p>{{$category->description}}</p>
        <div><img src="{{ asset('storage/'.$category->img ) }}" alt=""></div>
        <h4>products</h4>
        @foreach ($category->products()->with('store')->latest()->paginate(5) as $product)
            <div>
                <h4>{{$product->name}}</h4>
                <h4>{{$product->price}} $</h4>
            </div>
        @endforeach
    </div>
@endsection
