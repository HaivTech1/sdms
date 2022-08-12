<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model="subject_id">
                                    <option value=''>Subject</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-lg-3">
                                <select class="form-control " wire:model="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
    
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
                        </form>
                    </div>
                    <div class='row mt-4'>
                        <div class='col-xs-12 col-sm-12 col-md-12 text-center mb-4'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <span>Session:
                                                @if ($selectedPeriod)
                                                {{ $selectedPeriod->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Term:
                                                @if ($selectedTerm)
                                                {{ $selectedTerm->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Class:
                                                @if ($selectedGrade)
                                                {{ $selectedGrade->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Subject:
                                                @if ($selectedSubject)
                                                {{ $selectedSubject->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Sudent:
                                                @if ($selectedSubject)
                                                {{ $selectedSubject->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>