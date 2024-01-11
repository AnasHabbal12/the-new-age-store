@extends('layout.dashboard')
@section('title','users')

@section('breadcrumb')

<li class="breadcrumb-item active">Users</li>
@parent
@endsection

@section('content')

    <a href="{{ route('dashboard.users.create') }}" class="btn btn-lg btn-outline-primary">New Role</a>


    <br/><br/>
    <x-alert type="success"/>
    <x-alert type="info"/>

    @if($users -> count())

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    @can('users.update')
                    <th></th>
                    @endcan
                    @can('users.delete')
                    <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ( $users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td><a href="{{route('dashboard.users.show', $user->id)}}">{{$user->name}}</a></td>
                        <td><a href="{{route('dashboard.users.show', $user->id)}}">{{$user->email}}</a></td>
                        <td>{{$user->created_at}}</td>
                        @can('roles.update')
                        <td>
                            <a href="{{ route('dashboard.users.edit', $user->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                        @endcan
                        @can('users.delete')
                        <td>
                            <form action="{{ route('dashboard.users.destroy', $user->id)}}" method="post">
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
              <h4>There is no any users</h4>
            </div>
        @endif

{{ $users->withQueryString()->links() }}
@endsection
