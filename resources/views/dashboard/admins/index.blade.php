@extends('layout.dashboard')
@section('title','admins')

@section('breadcrumb')

<li class="breadcrumb-item active">Roles</li>
@parent
@endsection

@section('content')

    <a href="{{ route('dashboard.admins.create') }}" class="btn btn-lg btn-outline-primary">New Role</a>


    <br/><br/>
    <x-alert type="success"/>
    <x-alert type="info"/>

    @if($admins -> count())

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    @can('admins.update')
                    <th></th>
                    @endcan
                    @can('admins.delete')
                    <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ( $admins as $admin)
                    <tr>
                        <td>{{$admin->id}}</td>
                        <td><a href="{{route('dashboard.admins.show', $admin->id)}}">{{$admin->name}}</a></td>
                        <td><a href="{{route('dashboard.admins.show', $admin->id)}}">{{$admin->email}}</a></td>
                        <td>{{$admin->created_at}}</td>
                        @can('roles.update')
                        <td>
                            <a href="{{ route('dashboard.admins.edit', $admin->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                        @endcan
                        @can('admins.delete')
                        <td>
                            <form action="{{ route('dashboard.admins.destroy', $admin->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
          </table>

        @else
            <div class=" container">
              <h4>There is no any Admins</h4>
            </div>
        @endif

{{ $admins->withQueryString()->links() }}
@endsection
