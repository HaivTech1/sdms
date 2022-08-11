<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model="period_id">
                                <option value=''>Select Session</option>
                                @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model="term_id">
                                <option value=''>Select Term</option>
                                @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model="grade_id">
                                <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                       @foreach ($students as $student)
                           <h1>{{ $student->firstName }} {{ $student->firstName }}</h1>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>