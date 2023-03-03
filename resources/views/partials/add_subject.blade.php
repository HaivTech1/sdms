<div class="modal fade addSubject bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="createSubjects">
                            <x-form.input type="hidden" value="" name="student_id" id="student_id" />
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <select name="subjects[]" class="select2 form-control" multiple="multiple" style="height: 300px">
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id() }}">
                                                {{ $subject->title() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                <button type="submit" id="submit_button" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>