@extends('layouts.app')

@section('content')
    @component('components.breadcrumb')
        <span>{{$team->name}}</span>
    @endcomponent
    <div class="mx-4">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-10 col-xs-12">
                <!-- Members Card -->
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">
                            Members of team "{{$team->name}}"
                            <!-- Is it needed since we have breadcrumbs?
                            <a href="{{route('teams.index')}}" class="btn btn-sm btn-secondary float-right">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            -->
                        </h1>
                        <table class="table table-striped my-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach($team->users AS $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>Role</td>
                                    <td>
                                        <form
                                            style="display: inline"
                                            action="{{route('teams.members.edit', [$team, $user])}}"
                                            method="get"
                                        >
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="GET"/>
                                            <button class="btn-info btn-sm">
                                                Edit Role
                                            </button>
                                        </form>
                                        <form
                                            style="display: inline"
                                            action="{{route('teams.members.destroy', [$team, $user])}}"
                                            method="post"
                                        >
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE"/>
                                            <button class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                    <!--
                                    <td>
                                        @if(auth()->user()->isOwnerOfTeam($team))
                                            @if(auth()->user()->getKey() !== $user->getKey())
                                                <form
                                                    style="display: inline-block;"
                                                    action="{{route('teams.members.destroy', [$team, $user])}}"
                                                    method="post"
                                                >
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="_method" value="DELETE"/>
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    -->
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pending Invitations -->
            <div class="col-lg-5 col-md-10 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Pending invitations</h1>
                        <table class="table table-striped my-4">
                            <thead class="thead-dark">
                            <tr>
                                <th>E-Mail</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            @foreach($team->invites AS $invite)
                                <tr>
                                    <td>{{$invite->email}}</td>
                                    <td>
                                        <a
                                            href="{{route('teams.members.resend_invite', $invite)}}"
                                            class="btn-sm btn-dark"
                                        >
                                            <i class="fa fa-envelope-o"></i>
                                            Resend invite
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Invite to team "{{$team->name}}"</h1>
                        <form class="form-horizontal my-4" method="post" action="{{route('teams.members.invite', $team)}}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label">E-Mail Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-btn fa-envelope-o"></i> Invite to Team
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-10 col-sm-10 col-xs-12">
                <div class="card">
                    <div class="card-header">

                        <h4 class="card-header-title">
                            Members Management
                        </h4>
                        <br>
                    </div>
                    <div class="card-body">
                        <p>
                            In this page you can manage your teams and select your current one.
                            You can also get inside the members list for every team.
                        </p>
                        <p>
                            In this page you can manage your teams and select your current one.
                            You can also get inside the members list for every team.
                        </p>
                        <button class="btn btn-block btn-info">
                            Get more info
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
