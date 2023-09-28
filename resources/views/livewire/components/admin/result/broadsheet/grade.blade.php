<div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @php
                        $grades = \App\Models\Grade::all();
                        $periods = \App\Models\Period::all();
                        $terms = \App\Models\Term::all();
                    @endphp

                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="grade_id" id="gradeSelect">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="period_id" id="periodSelect">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="period_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="term_id" id="gradeTerm">
                                    <option value=''>Term</option>
                                    @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" id="fetch_btn" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                        Fetch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">

                            @php
                                $midterm = get_settings('midterm_format');
                                $exam = get_settings('exam_format');
                            @endphp

                            @if ($studentResults)
                                <table id="tech-companies-1" class="table table-striped">
                                   
                                </table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
