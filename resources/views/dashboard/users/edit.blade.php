@extends('layout.dashboard')
@section('title','New User')

@section('breadcrumb')
<li class="breadcrumb-item active">User</li>
<li class="breadcrumb-item active">Edit User</li>
@parent
@endsection

@section('content')

    <form action="{{ route('dashboard.admins.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.users._form', [
            'btn_lbl' => 'Update'
        ])
    </form>
@endsection
