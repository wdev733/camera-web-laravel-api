@extends('layouts.app')

@section('content')
    @component('components.breadcrumb')
    @endcomponent
    <div class="mx-4">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">
                            Teams
                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <button
                                    type="button"
                                    class="btn btn-secondary btn-sm"
                                    data-toggle="modal"
                                    data-target="#createModalCenter"
                                >
                                    <i class="fa fa-plus"></i>
                                    Create team
                                </button>
                            </div>
                        </h1>
                        <table class="table table-striped my-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Change Team</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>{{$team->name}}</td>
                                        <td>
                                            @if(auth()->user()->isOwnerOfTeam($team))
                                                <span class="btn-sm btn-success">Owner</span>
                                            @else
                                                <span class="btn-sm btn-primary">Member</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('teams.members.show', $team)}}" class="btn-sm btn-dark">
                                                <i class="fa fa-users"></i> Members
                                            </a>

                                            @if(auth()->user()->isOwnerOfTeam($team))

                                                <a href="{{route('teams.edit', $team)}}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>

                                                <form style="display: inline-block;"
                                                      action="{{route('teams.destroy', $team)}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE"/>
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !== $team->getKey())
                                                <a href="{{route('teams.switch', $team)}}" class="btn-sm btn-danger">
                                                    <i class="fa fa-sign-in"></i>
                                                    Switch
                                                </a>
                                            @else
                                                <span class="btn-info btn-sm">Current team</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">

                        <h4 class="card-header-title">
                            Teams Management
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

    <!-- Modal -->
    @include('teamwork.create')

@endsection
