@extends('layout.dashboard')
@section('title','New Role')

@section('breadcrumb')
<li class="breadcrumb-item active">Role</li>
<li class="breadcrumb-item active">New Role</li>
@parent
@endsection

@section('content')

    <form action="{{ route('dashboard.roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.admins._form', [
            'btn_lbl' => 'Save'
        ])
    </form>
@endsection
