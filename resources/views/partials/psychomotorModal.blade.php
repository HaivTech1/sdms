<div class="modal fade hide" id="psychomotor" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-modal="true" role="dialog">
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
                            <h4 class="text-primary">Psychomotor Domain scores</h4>
                            <p class="text-muted font-size-14 mb-4">Upload psychomotor domain scores</p>

                            <form id="createPsychomotor" action="{{ route('result.psychomotor.upload') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="student_uuid" id="student" value="" />
                                <input type="hidden" name="period_id" id="period" value="" />
                                <input type="hidden" name="term_id" id="term" value="" />
                                        
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Handwriting" />
                                            <div class="input-group">
                                            <div class="input-group-text">Handwriting</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Creativity" />
                                        <div class="input-group">
                                            <div class="input-group-text">Creativity</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Games/Sport" />
                                        <div class="input-group">
                                            <div class="input-group-text">Games/Sport</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Verbal Fluency" />
                                            <div class="input-group">
                                            <div class="input-group-text">Verbal Fluency</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                        <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Handling of tools" />
                                        <div class="input-group">
                                            <div class="input-group-text">Handling</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" id="affectiveBtn" class="btn btn-light">Affective</button>
                                    <button type="button" id="commentBtn" class="btn btn-light">Comment</button>
                                    <button id="submit_psychomotor" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>