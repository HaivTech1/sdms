<div class="modal fade hide" id="affective" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-modal="true" role="dialog">
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
                            <h4 class="text-primary">Affective Domain scores</h4>
                            <p class="text-muted font-size-14 mb-4">Upload affective domain scores</p>

                            <form id="createAffective" action="{{ route('result.affective.upload') }}" method="POST">
                                @csrf
                                <input type="hidden" name="student_uuid" id="student_uuid" value="" />
                                <input type="hidden" name="period_id" id="period_id" value="" />
                                <input type="hidden" name="term_id" id="term_id" value="" />
                                        
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Attentiveness" />
                                        <div class="input-group">
                                            <div class="input-group-text">Attentiveness</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Neatness" />
                                        <div class="input-group">
                                            <div class="input-group-text">Neatness</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Initiative" />
                                        <div class="input-group">
                                            <div class="input-group-text">Initiative</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Organization" />
                                        <div class="input-group">
                                            <div class="input-group-text">Organization</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Perseverance" />
                                        <div class="input-group">
                                            <div class="input-group-text">Perseverance</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Perseverance" />
                                        <div class="input-group">
                                            <div class="input-group-text">Perseverance</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Politeness" />
                                        <div class="input-group">
                                            <div class="input-group-text">Politeness</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Self Control" />
                                        <div class="input-group">
                                            <div class="input-group-text">Self Control</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Co-operation" />
                                        <div class="input-group">
                                            <div class="input-group-text">Co-operation</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="title[]" value="Reliability" />
                                        <div class="input-group">
                                            <div class="input-group-text">Reliability</div>
                                            <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" id="psychomotorBtn" class="btn btn-light">Psychomotor</button>
                                    <button id="submit_affective" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>