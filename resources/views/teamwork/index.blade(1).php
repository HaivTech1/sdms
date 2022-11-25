<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Teams</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <x-search />
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route('teams.create')}}" type="button"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Create Team</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($teams as $team)
                            <tr>
                                <td>{{$team->name}}</td>
                                <td>
                                    @if(auth()->user()->isOwnerOfTeam($team))
                                    <span class="label label-success">Owner</span>
                                    @else
                                    <span class="label label-primary">Member</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_null(auth()->user()->currentTeam) ||
                                    auth()->user()->currentTeam->getKey() !== $team->getKey())
                                    <a href="{{route('teams.switch', $team)}}" class="btn btn-sm btn-default">
                                        <i class="fa fa-sign-in"></i> Switch
                                    </a>
                                    @else
                                    <span class="label label-default">Current team</span>
                                    @endif

                                    <a href="{{route('teams.members.show', $team)}}" class="btn btn-sm btn-default">
                                        <i class="fa fa-users"></i> Members
                                    </a>

                                    @if(auth()->user()->isOwnerOfTeam($team))

                                    <a href="{{route('teams.edit', $team)}}" class="btn btn-sm btn-default">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>

                                    <form style="display: inline-block;" action="{{route('teams.destroy', $team)}}"
                                        method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                            Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>