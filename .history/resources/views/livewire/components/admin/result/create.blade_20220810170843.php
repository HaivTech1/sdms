<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class='row'>
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="gender">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="sortBy">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="orderBy">
                                    <option value=''>Class</option>
                                        @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>