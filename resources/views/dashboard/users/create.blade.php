@extends('layout.dashboard')
@section('title','New User')

@section('breadcrumb')
<li class="breadcrumb-item active">User</li>
<li class="breadcrumb-item active">New User</li>
@parent
@endsection

@section('content')

    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.users._form', [
            'btn_lbl' => 'Save'
        ])
    </form>
@endsection
