@extends('layout.dashboard')
@section('title','roles')

@section('breadcrumb')

<li class="breadcrumb-item active">Roles</li>
@parent
@endsection

@section('content')

    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-lg btn-outline-primary">New Role</a>


    <br/><br/>
    <x-alert type="success"/>
    <x-alert type="info"/>

    @if($roles -> count())

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    @can('roles.update')
                    <th></th>
                    @endcan
                    @can('roles.delete')
                    <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ( $roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td><a href="{{route('dashboard.roles.show', $role->id)}}">{{$role->name}}</a></td>
                        <td>{{$role->created_at}}</td>
                        @can('roles.update')
                        <td>
                            <a href="{{ route('dashboard.roles.edit', $role->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                        @endcan
                        @can('roles.delete')
                        <td>
                            <form action="{{ route('dashboard.roles.destroy', $role->id)}}" method="post">
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
              <h4>There is no any Roles</h4>
            </div>
        @endif

{{ $roles->withQueryString()->links() }}
@endsection
