<x-app-layout>
    @section('title', application('name')." | Assignment Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Assignment</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Available assignments</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-check">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle"> </th>
                                        <th class="align-middle"> Title</th>
                                        <th class="align-middle">Subject</th>
                                        <th class="align-middle">Posted By</th>
                                        <th class="align-middle">Posted Date</th>
                                        <th class="align-middle"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $key => $assignment)
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            {{ $assignment->title() }}
                                        </td>
                                        <td>
                                            {{ $assignment->subject->title() }}
                                        </td>
                                        <td>
                                           {{ $assignment->author()->title() }}. {{ $assignment->author()->name() }}
                                        </td>
                                        <td>
                                           {{ $assignment->createdAt() }}
                                        </td>
                                        <td>
                                            <a href="{{ route('assignment.show', $assignment->id()) }}"
                                                class="btn btn-sm btn-primary"><i class="bx bx-show"></i>
                                            </a>
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

    </div>
</x-app-layout>