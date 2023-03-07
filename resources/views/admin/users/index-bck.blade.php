@extends('admin.layouts.dashboard')

@section('section_title')
    Users
@endsection

@section('content')
    @component('admin.components.box-default')
        @slot('title')
            Users
        @endslot

        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                    Create User
                </a>
            </div>
        </div>
        @component('admin.components.table-full', ['id' => 'user_table1'])
            @slot('header')
                Username|First Name|Last Name|Email|
            @endslot
            @foreach($users as $user)
                <tr role="row">
                    <td class="sorting_1">{{$user->username}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        {{--<div class="btn-group">--}}
                            {{--<button type="button" class="btn btn-info btn-xs">action</button>--}}
                            <a href="{{ route('admin.users.edit', ['user' => $user]) }}" class="btn btn-info btn-xs">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="inline">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info btn-xs btn-danger">
                                    Delete
                                </button>
                            </form>

                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li><a href="{{ route('admin.users.edit', ['user' => $user]) }}">Edit</a></li>--}}
                                {{--<li><button type="submit" class="form-control btn btn-link btn-block">Delete</button></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    </td>
                </tr>
            @endforeach
        @endcomponent

    @endcomponent
@endsection