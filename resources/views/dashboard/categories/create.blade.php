@extends('layout.dashboard')
@section('title','New Category')

@section('breadcrumb')
<li class="breadcrumb-item active">Category</li>
<li class="breadcrumb-item active">New Category</li>
@parent
@endsection

@section('content')
    
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form', [
            'btn_lbl' => 'Save'
        ])
    </form>
@endsection
