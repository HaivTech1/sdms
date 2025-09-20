<?php if($student_details): ?>
<div id="viewResult" class="modal fade" tabindex="-1" aria-labelledby="#viewResultLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewResultLabel">Checking result for - <?php echo e($student_details->firstName()); ?> <?php echo e($student_details->lastName()); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" class="text-center">
                                    xs<br>
                                    <span class="fw-normal">&lt;576px</span>
                                </th>
                                <th scope="col" class="text-center">
                                    sm<br>
                                    <span class="fw-normal">≥576px</span>
                                </th>
                                <th scope="col" class="text-center">
                                    md<br>
                                    <span class="fw-normal">≥768px</span>
                                </th>
                                <th scope="col" class="text-center">
                                    lg<br>
                                    <span class="fw-normal">≥992px</span>
                                </th>
                                <th scope="col" class="text-center">
                                    xl<br>
                                    <span class="fw-normal">≥1200px</span>
                                </th>
                                <th scope="col" class="text-center">
                                    xxl<br>
                                    <span class="fw-normal">≥1400px</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-nowrap" scope="row">Grid behavior</th>
                                <td>Horizontal at all times</td>
                                <td colspan="5">Collapsed to start, horizontal above breakpoints</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Max container width</th>
                                <td>None (auto)</td>
                                <td>540px</td>
                                <td>720px</td>
                                <td>960px</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Class prefix</th>
                                <td><code>.col-</code></td>
                                <td><code>.col-sm-</code></td>
                                <td><code>.col-md-</code></td>
                                <td><code>.col-lg-</code></td>
                                <td><code>.col-xl-</code></td>
                                <td><code>.col-xxl-</code></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row"># of columns</th>
                                <td colspan="6">12</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Gutter width</th>
                                <td colspan="6">24px (12px on each side of a column)</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Custom gutters</th>
                                <td colspan="6">Yes</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Nestable</th>
                                <td colspan="6">Yes</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Offsets</th>
                                <td colspan="6">Yes</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Column ordering</th>
                                <td colspan="6">Yes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                        class="fa fa-print"></i></a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\modal.blade.php ENDPATH**/ ?>