<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
    
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="fas fa-angle-double-up"></i> <span>Fetch</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th></th>
                                                    <th scope="col" class="text-center">
                                                      Class
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                        Total Subjects
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                        Recorded Subjects
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                      Grand Total
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                      Average
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                      Action
                                                    </th>
                                                  </tr>
                                            </thead>
                                            <tbody class='text-center'>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Name of Student</th>
                                                        <td>{{ $student->firstName() }}</td>
                                                        <td>{{ $student->grade->title() }}</td>
                                                        <td>{{ $student->totalSubjects() }}</td>
                                                        <td>
                                                            {{ $student->results->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $student->grandTotal() }} / {{ $student->grandTotalObtainable() }}
                                                        </td>
                                                        <td>{{ $student->resultPercentage() }} %</td>
                                                        <td>
                                                            <div class="d-flex justify-content-between">
                                                                <button type="button"  class="btn btn-sm btn-primary waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> <span>View</span>
                                                                </button>
                                                                <button type="button"  class="btn btn-sm btn-primary waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> <span>Publish</span>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $students->links('pagination::custom-pagination')}}
                                </div>
                            </div>
                        </div> <!-- end col -->
    
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>