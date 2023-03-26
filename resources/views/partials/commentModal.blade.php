<div class="modal fade hide" id="comment" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-md mx-auto mb-4">
                        <div class="avatar-title bg-light rounded-circle text-primary h1">
                            <i class="bx bx-customize"></i>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <h4 class="text-primary">Comment and Attendance</h4>
                            <p class="text-muted font-size-14 mb-4">Add comment to result and attendance</p>

                            <form id="createComment" method="POST">
                                @csrf
                                <input type="hidden" name="student_uuid" id="comment_student" />
                                <input type="hidden" name="period_id" id="comment_period" />
                                <input type="hidden" name="term_id" id="comment_term" />
                                        
                                <div class="row mt-2">
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="attendance_duration" value="{{ __('Total times school openned') }}" />
                                        <x-form.input id="attendance_duration" class="block w-full mt-1" type="text" name="attendance_duration"
                                            :value="old('attendance_duration')" id="attendance_duration" autofocus />
                                        <x-form.error for="attendance_duration" />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="attendance_present" value="{{ __('Total times present') }}" />
                                        <x-form.input id="attendance_present" class="block w-full mt-1" type="text" name="attendance_present"
                                            :value="old('attendance_present')" id="attendance_present" autofocus />
                                        <x-form.error for="attendance_present" />
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <x-form.label for="comment" value="{{ __('Comment on result') }}" />
                                                <textarea class="form-control" name="comment" id="summernote">{{ old('comment') }}</textarea>
                                        <x-form.error for="comment" />
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" id="affectiveBtn" class="btn btn-light">Affective</button>
                                    <button type="button" id="psychomotorBtn" class="btn btn-light">Psycomotor</button>
                                    <button id="submit_comment" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>