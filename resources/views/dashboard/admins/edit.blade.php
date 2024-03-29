@extends('layout.dashboard')
@section('title','New Role')

@section('breadcrumb')
<li class="breadcrumb-item active">Role</li>
<li class="breadcrumb-item active">Edit Role</li>
@parent
@endsection

@section('content')

    <form action="{{ route('dashboard.admins.update', $admin->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.admins._form', [
            'btn_lbl' => 'Update'
        ])
    </form>
@endsection
