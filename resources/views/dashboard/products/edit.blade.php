@extends('layout.dashboard')
@section('title','Edit Product')

@section('breadcrumb')
<li class="breadcrumb-item active">Category</li>
<li class="breadcrumb-item active">Edit Category</li>
@parent
@endsection

@section('content')
    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.products._form', [
            'btn_lbl' => 'Update'
        ])
    </form>
@endsection
