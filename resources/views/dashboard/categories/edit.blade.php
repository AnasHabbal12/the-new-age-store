@extends('layout.dashboard')
@section('title','New Category')

@section('breadcrumb')
<li class="breadcrumb-item active">Category</li>
<li class="breadcrumb-item active">Edit Category</li>
@parent
@endsection

@section('content')
    
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.categories._form', [
            'btn_lbl' => 'Update'
        ])
    </form>
@endsection
