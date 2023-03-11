<div class="modal fade syncParentModal bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Re-upload Parents data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="syncAllParents">
                            <div class="row">
                                <p class="message text-danger text-sm mb-2"></p>
                                
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="align-middle">
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" id="select-all">
                                                    </div>
                                                </th>
                                                <th class="align-middle"> Name </th>
                                                <th class="align-middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body2">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                <button type="submit" id="sync_button" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Sync All</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>