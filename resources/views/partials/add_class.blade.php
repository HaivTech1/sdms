<div class="modal fade addClass bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="assignClasses">
                             <x-form.input type="hidden" value="" name="user_id" id="user_id" />

                            <div class="col-sm-12 mt-2">
                                <select name="grade_id" class="form-control">
                                    @foreach ($grades as $id => $grade)
                                        <option value="{{ $id }}">
                                            {{ $grade }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-form.error for="grade_id" />
                            </div>

                            <div class="col-sm-12 mt-2">
                                <div class="float-right">
                                    <button id="submit_button" type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>