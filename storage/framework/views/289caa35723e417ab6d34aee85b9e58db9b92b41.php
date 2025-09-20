<div>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.loading','data' => []]); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="d-flex gap-2">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                        <div>
                                            <button class="btn btn-sm btn-primary" data-grade="" data-period="" data-term="" style="display:none" id="publishSelected"><i class="bx bx-publsih"></i> Publish Results</button>
                                        </div>
                                        <div>
                                            <button data-bs-toggle="modal" data-bs-target=".refreshResultModal" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Reset Midterm Result</button>
                                        </div>
                                    <?php endif; ?>
                                    <!-- <div class="">
                                        <button class="btn btn-sm btn-secondary" 
                                            data-bs-toggle="modal"
                                            data-bs-target=".excelResultModal" 
                                        >
                                            <i class="bx bxs-file-doc"></i> 
                                            Upload Excel Result
                                        </button>
                                    </div> -->
                                    <?php if (\Illuminate\Support\Facades\Blade::check('superadmin')): ?>
                                        <!-- <div>
                                            <button data-bs-toggle="modal" data-bs-target=".generateResultModal" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Generate Midterm Result</button>
                                        </div> -->
                                        <!-- <div>
                                            <button data-bs-toggle="modal" data-bs-target=".setCummulative" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Set Cumulative</button>
                                        </div> -->
                                    <?php endif; ?>
                                </div>
                                <div class="mt-2">
                                    <form id="fetchResultForm">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <select class="form-control" id="grade_id" name="grade_id">
                                                    <option value=''>Class</option>
                                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-3">
                                                <select class="form-control" id="period_id" name="period_id">
                                                    <option value=''>Select Session</option>
                                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'period_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'period_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <select class="form-control" id="term_id" name="term_id">
                                                    <option value=''>Select Term</option>
                                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'term_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'term_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="d-flex justify-content-center align-item-center">
                                                    <button type="submit" id="fetchResultButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="search-box me-2 mb-2">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search student..." id="input-search">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div>

                                <!-- <?php
                                    $currentTerm = $terms->firstWhere('status', true);
                                    $currentTermId = $currentTerm ? $currentTerm->id : null;
                                ?>
                                
                                <div class="mt-2 mb-2">
                                    <h4 class="font-bold">Result Cummulative</h4>
                                
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="terms[]" value="<?php echo e($term->id); ?>" <?php if($currentTermId && $term->id <= $currentTermId): ?> checked
                                                <?php endif; ?>>
                                                <span><?php echo e($term->title); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <div class="table-responsive">
                                <table id="result-data" class="table search-table table-bordered table-striped table-nowrap mb-0">
                                    <thead class="table-light header-item">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center">Name of Student</th>
                                            <th scope="col" class="text-center">
                                                Recorded Subjects
                                            </th>
                                            <th scope="col" class="text-center" id="action">
                                                Action
                                            </th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody class="search-row">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade excelResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload excel result sheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="excelResultUpload" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <select class="form-control" name="grade_id" id="excel_grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 student-select">
                                    <select class="form-control" name="student_id">
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control " name="period_id">
                                        <option value=''>Select Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'period_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'period_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control select2" name="term_id">
                                        <option value=''>Select Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'term_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'term_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-lg-2">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'excel','class' => 'block w-full','type' => 'file','name' => 'excel_file']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'excel','class' => 'block w-full','type' => 'file','name' => 'excel_file']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="excel_upload_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createCommentModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comment and Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12 mt-4">

                                <form id="createComment" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="student_uuid" id="student" />
                                    <input type="hidden" name="period_id" id="periodC" />
                                    <input type="hidden" name="term_id" id="termC" />

                                    <div class="row mt-2">
                                        <div class="col-sm-6 mb-3">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'attendance_duration','value' => ''.e(__('Total times school openned')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'attendance_duration','value' => ''.e(__('Total times school openned')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'attendance_duration','class' => 'block w-full mt-1','type' => 'text','name' => 'attendance_duration','value' => old('attendance_duration'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'attendance_duration','class' => 'block w-full mt-1','type' => 'text','name' => 'attendance_duration','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('attendance_duration')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'attendance_duration']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'attendance_duration']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'attendance_present','value' => ''.e(__('Total times present')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'attendance_present','value' => ''.e(__('Total times present')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'attendance_present','class' => 'block w-full mt-1','type' => 'text','name' => 'attendance_present','value' => old('attendance_present'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'attendance_present','class' => 'block w-full mt-1','type' => 'text','name' => 'attendance_present','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('attendance_present')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'attendance_present']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'attendance_present']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'comment','value' => ''.e(__('Comment on result')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'comment','value' => ''.e(__('Comment on result')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <textarea class="form-control" name="comment" id="attendance_comment"></textarea>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'comment']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'comment']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
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

    <div id="createPrincipalCommentModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Principal's Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12 p-2">

                                <form id="createPrincipalComment" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="student_uuid" id="student_principal" />
                                    <input type="hidden" name="period_id" id="period_principal" />
                                    <input type="hidden" name="term_id" id="term_principal" />

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'principal_comment','value' => ''.e(__('Principal Comment')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'principal_comment','value' => ''.e(__('Principal Comment')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <textarea class="form-control" name="principal_comment" id="attendance_principal_comment" cols="5" rows="5" placeholder="Type in your comment here..."></textarea>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'principal_comment']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'principal_comment']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'promotion_comment','value' => ''.e(__('Promotion Comment')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'promotion_comment','value' => ''.e(__('Promotion Comment')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <textarea class="form-control" name="promotion_comment" id="attendance_promotion_comment" cols="10" rows="5" placeholder="Type in your promotional comment here..."></textarea>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'promotion_comment']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'promotion_comment']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div> -->
                                    </div>

                                    <div class="modal-footer">
                                        <button id="submit_principal_comment" type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createAffectiveModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Affective domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12">

                                <form id="createAffective" action="<?php echo e(route('result.affective.upload')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" id="affective_student_id" name="student_uuid" />
                                    <input type="hidden" id="affective_period_id" name="period_id" />
                                    <input type="hidden" id="affective_term_id" name="term_id" />

                                    <?php
$affectives = get_settings('affective_domain');
$psychomotors = get_settings('psychomotor_domain');
                                    ?>
                                            
                                    <div class="row mt-2">
                                        <?php if($affectives): ?>
                                            <?php $__currentLoopData = $affectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $affectives): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-sm-12 mb-2">
                                                    <input type="hidden" name="title[]" value="<?php echo e($affectives); ?>" />
                                                    <div class="input-group">
                                                        <div class="input-group-text"><?php echo e($affectives); ?></div>
                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="row justify-content-center align-items-center mt-2">
                                        <button id="affective_button" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createPsychomotorModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Psychomotor domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12">

                                <form id="createPsychomotor" action="<?php echo e(route('result.psychomotor.upload')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" id="psychomotor_student_id" name="student_uuid" />
                                    <input type="hidden" id="psychomotor_period_id" name="period_id" />
                                    <input type="hidden" id="psychomotor_term_id" name="term_id" />
                                    
                                    <div class="row mt-2">
                                        <?php if($psychomotors): ?>
                                            
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $psychomotors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psychomotor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-sm-12 mb-2">
                                                <input type="hidden" name="title[]" value="<?php echo e($psychomotor); ?>" />
                                                    <div class="input-group">
                                                    <div class="input-group-text"><?php echo e($psychomotor); ?></div>
                                                    <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <div class="row justify-content-center align-items-center mt-2">
                                        <button id="psychomotor_button" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteResultModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirm Delete Result!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-title">Are you sure you want to delete this result?</p>
                </div>
                 <div class="modal-footer">
                    <form wire:submit.prevent="destroyResult">
                        <div class="">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" type="submit">Yes delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade previewResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Result Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                            <div class="row">

                                <div class="card">
                                    <div class="card-header">
                                        <button data-student-id="" class="btn btn-sm btn-secondary addResult" ><i class="bx bx-plus"></i> Add Result</button>
                                    </div>
                                </div>

                                <input name="result_id" id="result_id" type="hidden" />

                                <div class="col-sm-12 mb-2">
                                    <?php
$examForm = get_settings('exam_format');
$midtermForm = get_settings('midterm_format');
                                    ?>
                                    <div class="table-responsive">
                                        <table id="students-result" class="table table-borderless">

                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <?php $__currentLoopData = $examForm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <th><?php echo e($value['full_name']); ?></th>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" id="scoreInput" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveScoreBtn">Save</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade addResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="resultUpload" method="POST">
                            <?php echo csrf_field(); ?>
                            <input name="student_id" id="add_student_id" type="hidden" />

                            <?php
$examForm = get_settings('exam_format');
$subjects = \App\Models\Subject::all();
                            ?>

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="subject_id">
                                        <option value=''>Subject</option>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id()); ?>"><?php echo e($subject->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select id="format-select" class="form-control">
                                        <option value="">Select test type</option>
                                        <?php $__currentLoopData = $examForm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($value['full_name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 70px','class' => 'text-center required exam-input','type' => 'number','name' => '','value' => '','step' => '0.01','onblur' => 'validateInput(this)','disabled' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 70px','class' => 'text-center required exam-input','type' => 'number','name' => '','value' => '','step' => '0.01','onblur' => 'validateInput(this)','disabled' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="submit_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade refreshResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset midterm scores for class exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="refreshResult" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php
$grades = \App\Models\Grade::all();
$periods = \App\Models\Period::all();
$terms = \App\Models\Term::all();
                            ?>

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id">
                                        <option value=''>Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id">
                                        <option value=''>Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="refresh_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Refresh Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade generateResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate midterm scores from midterm exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="generateResult" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php
$grades = \App\Models\Grade::all();
$periods = \App\Models\Period::all();
$terms = \App\Models\Term::all();
                            ?>

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id">
                                        <option value=''>Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id">
                                        <option value=''>Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="generate_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Generate Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade editPlayModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="uploadPlaygroupResult" action="<?php echo e(route('result.playgroup.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" id="edit_playgroup_student" value="" name="student_id" />
                            <input type="hidden" id="edit_playgroup_period" value="" name="period_id" />
                            <input type="hidden" id="edit_playgroup_term" value="" name="term_id" />
                        
                            <div class='table-responsive'>
                                <table class="table align-middle table-nowrap" id="edit-play-result">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subjects</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                <button type="submit" id="upload_playgroup_btn"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Update Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade setCummulative" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update class Cummulative</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="setCummulative" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php
$grades = \App\Models\Grade::all();
$periods = \App\Models\Period::all();
$terms = \App\Models\Term::all();
                            ?>

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id">
                                        <option value=''>Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id">
                                        <option value=''>Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="set_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Cummulate Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>

    <script>
        $('#fetchResultForm').on('submit', function(e){
            e.preventDefault();
            var button = $('#fetchResultButton');
            toggleAble(button, true, 'Fetching...');

            var grade = $('#grade_id').val();
            var period = $('#period_id').val();
            var term = $('#term_id').val();

            $('#publishSelected').data('period', period);
            $('#publishSelected').data('term', term);
            $('#publishSelected').data('grade', grade);

            $.ajax({
                url: '<?php echo e(route("result.check.exam", ["period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':grade_id', grade),
                type: 'GET',
                dataType: 'json',
            }).done((response) => {
                toggleAble(button, false);
                var students = response.students;
                var userPermissions = <?php echo json_encode(userPermissions(), 15, 512) ?>;
                var templateType = <?php echo json_encode(get_application_settings('result_template'), 15, 512) ?>;
                var classPosition = <?php echo json_encode(get_application_settings('class_position'), 15, 512) ?>;
                var gradePosition = <?php echo json_encode(get_application_settings('grade_position'), 15, 512) ?>;

                var html = '';
                $.each(students, function(index, student) {
                        html += '<tr class="search-items">';
                            html += '<td class="text-center">';
                            html += '<div class="form-check">';
                            html += '<input type="checkbox" class="form-check-input actionCheck" id="' + student.id + '" name="ids[]" value="' + student.id + '" />';
                            html += '</div>';
                            html += '</td>';
                            html += '<td class="">' + student.name + '</td>';
                            html += '<td class="text-center">' + student.recorded_subjects + '</td>';

                            if(student.recorded_subjects > 0)
                            {
                                html += '<td>';
                                html += '<button class="btn btn-sm btn-secondary recorded" data-grade="'+response.grade+'" data-period="'+response.period+'" data-term="'+response.term+'" data-student="' + student.id + '"><i class="fa fa-cogs"></i> View Recorded</button>';
                                // if (userPermissions.includes('result_comment')) {
                                //         html += '<button class="btn btn-sm btn-info editCom" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-conversation"></i> Comment</button>';
                                // }

                                if (response.grade_name === 'Playgroup') {

                                        html += '<button class="btn btn-sm btn-danger editPlayResult" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '"><i class="bx bx-edit"></i> Edit</button>';
                                        
                                        if (userPermissions.includes('result_show')) {
                                            html += '<a target="_blank" href="<?php echo e(route('result.playgroup.show', ['student' => ':student'])); ?>'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                                        }

                                        if (userPermissions.includes('result_download')) {
                                            html += '<form action="<?php echo e(route('result.playgroup.pdf')); ?>" method="POST">';
                                            html += '<?php echo csrf_field(); ?>';
                                            html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                                            html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                                            html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                                            html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                                            html += '<button class="btn btn-sm btn-info" type="submit">';
                                            html += '<i class="bx bxs-file-pdf"></i> PDF';
                                            html += '</button>';
                                            html += '</form>';
                                        }


                                }else{
                                        if(gradePosition == 0 || classPosition == 0){
                                            if (userPermissions.includes('result_show')) {
                                                html += '<a target="_blank" href="<?php echo e(route('result.primary.show', ['student' => ':student'])); ?>'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                                            }

                                            if (userPermissions.includes('result_download')) {
                                                html += '<form action="<?php echo e(route('result.exam.pdf')); ?>" method="POST">';
                                                html += '<?php echo csrf_field(); ?>';
                                                html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                                                html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                                                html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                                                html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                                                html += '<button class="btn btn-sm btn-info" type="submit">';
                                                html += '<i class="bx bxs-file-pdf"></i> PDF';
                                                html += '</button>';
                                                html += '</form>';
                                            }
                                        }else{
                                            if(student.position_state && student.position_subject_state && templateType === 1){
                                                if (userPermissions.includes('result_show')) {
                                                    html += '<a target="_blank" href="<?php echo e(route('result.primary.show', ['student' => ':student'])); ?>'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                                                }

                                                if (userPermissions.includes('result_download')) {
                                                    html += '<form action="<?php echo e(route('result.exam.pdf')); ?>" method="POST">';
                                                    html += '<?php echo csrf_field(); ?>';
                                                    html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                                                    html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                                                    html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                                                    html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                                                    html += '<button class="btn btn-sm btn-info" type="submit">';
                                                    html += '<i class="bx bxs-file-pdf"></i> PDF';
                                                    html += '</button>';
                                                    html += '</form>';
                                                }
                                            }
                                        }
                                        
                                }

                                    // if (userPermissions.includes('affective_create')) {
                                    //     html += '<button class="btn btn-sm btn-secondary uploadAffective" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                                    //     html += '<i class="fas fa-compress-arrows-alt"></i> Affective';
                                    //     html += '</button>';
                                    // }

                                    // if (userPermissions.includes('affective_create')) {
                                    //     html += '<button class="btn btn-sm btn-secondary uploadPsychomotor gap-2" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                                    //     html += '<i class="fas fa-compress-arrows-alt"></i> Psychomotor';
                                    //     html += '</button>';
                                    // }

                                    if (userPermissions.includes('principal_comment')) {
                                        html += '<button class="btn btn-sm btn-danger editPrincipalCom" data-period="' + response.period + '" data-term="' + response.term + '" data-id="' + student.id + '" target="_blank"><i class="bx bx-conversation"></i> Principal Comment</button>';
                                    }
                                    
                                    if(student.position_state && student.position_subject_state && templateType === 1){
                                        if (userPermissions.includes('result_publish')) {
                                            if(student.publish_state){
                                                html += '<button type="button" class="btn btn-sm btn-success" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                                                html += '<span class="">Published</span>';
                                                html += '</button>';
                                            }else{
                                                html += '<button type="button" class="btn btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                                                html += '<span>Publish</span>';
                                                html += '</button>';
                                            } 
                                        }
                                    }
                                    
                                    
                                    if (userPermissions.includes('position_access')) {
                                        if(gradePosition == 1){
                                            if(student.position_state == false && templateType === 1){
                                                html += '<button class="btn btn-sm btn-danger studentPositionSync" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-cog"></i> Term Position</button>';
                                            }
                                        }

                                        if(classPosition == 1){
                                            if(student.position_subject_state == false && templateType === 1){
                                                html += '<button class="btn btn-sm btn-danger studentSinglePositionSync" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-cog"></i> Subject Grade Position</button>';
                                            }
                                        }
                                    }
                                
                                html += '</td>';
                            }else{
                            html += '<td>';
                            html += '<p>No Results available</p>';
                            html += '</td>';
                        }
                        html += '</tr>';
                    });

                $('#result-data tbody').html(html);

                $(".studentPositionSync").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.student.sync.position', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response);
                        toastr.success(response.message, "Successfully.");
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".studentSinglePositionSync").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.student.sync.single.position', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response);
                        toastr.success(response.message, "Successfully.");
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $('.recorded').on('click', function(e){
                    var button = $(this);
                    toggleAble(button, true)

                    var id = $(this).data('student');
                    var classId = $(this).data('grade');
                    var sessionId = $(this).data('period');
                    var termId = $(this).data('term');

                    $.ajax({
                        url: '<?php echo e(route("result.fetch.exam", ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"])); ?>'.replace(':student_id', id).replace(':period_id', sessionId).replace(':term_id', termId).replace(':grade_id', classId),
                        type: 'GET',
                        dataType: 'json',
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;

                        var html = '';
                        $.each(results, function(index, result) {
                        html += '<tr>';
                        html += '<td>' + result.subject_name + '</td>';

                        var resultScores = results;
                        var examFormat = JSON.parse('<?php echo json_encode($examForm); ?>');

                        $.each(examFormat, function(examKey, examValue) {
                            var score = '-';
                            if (examKey in result) {
                                score = result[examKey];
                            }
                            html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="' + examKey + '">' + score + '</td>';
                        });

                        html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + result.result_id + '"><i class="bx bx-trash"></button></td>';
                        html += '</tr>';
                        });

                        $('#students-result tbody').html(html);
                        $('.addResult').data('student-id', id)
                        $('.previewResultModal').modal('toggle');

                        $('.score-cell').click(function() {
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var examKey = $(this).data('exam-key');
                            var currentScore = $(this).text();
                            $('#scoreInput').val(currentScore);
                            $('#saveScoreBtn').data('result-id', resultId);
                            $('#saveScoreBtn').data('subject-id', subjectId);
                            $('#saveScoreBtn').data('exam-key', examKey);
                            $('#editModal').modal('show');
                        });

                        $('#saveScoreBtn').click(function() {
                            var button = $(this);
                            toggleAble(button, true, 'Updating...');
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var examKey = $(this).data('exam-key');
                            var editedScore = $('#scoreInput').val();

                            Swal.fire({
                                title: 'Confirm Submission',
                                text: 'Are you sure you want to update the score?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#502179',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Update'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                    });
                                    
                                    $.ajax({
                                        url: '<?php echo e(route('result.update.exam')); ?>',
                                        type: 'POST',
                                        data: {result_id: resultId, subject_id: subjectId, field: examKey, score: editedScore},
                                    }).done((response) => {
                                        toggleAble(button, false);
                                        Swal.fire('Updated!', response.message, 'success');
                                        $('.score-cell[data-subject-id="' + subjectId + '"][data-exam-key="' + examKey + '"]').text(editedScore);
                                        $('#editModal').modal('toggle');
                                    }).fail((error) => {
                                        toggleAble(button, false);
                                        console.log(error);
                                        toastr.error(error.responseJSON.message, 'Failed!');
                                    });
                                }else{
                                    toggleAble(button, false);
                                }
                            });
                        });

                        $('.addResult').click(function(){
                            $('.previewResultModal').modal('toggle');
                            var student = $(this).data('student-id');
                            document.getElementById('add_student_id').value = student;
                            $('.addResultModal').modal('toggle');
                        });

                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                        console.log(error);
                    });

                });

                $(".editCom").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.student.comment', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response.comment);
                        if(response.comment != undefined || response.comment != null){
                            var total = response.comment.total;
                            var present = response.comment.present;
                            var comment = response.comment.comment;

                            document.getElementById('attendance_duration').value=total;
                            document.getElementById('attendance_present').value=present;
                            document.getElementById('attendance_comment').value=comment;
                        }else{
                            document.getElementById('attendance_duration').value = '';
                            document.getElementById('attendance_present').value = '';
                            document.getElementById('attendance_comment').value = '';
                        }

                        document.getElementById("student").value=id;
                        document.getElementById('periodC').value=period;
                        document.getElementById('termC').value=term;
                        $("#createCommentModal").modal('toggle');

                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".editPrincipalCom").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.student.principalComment', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        console.log(response)
                        toggleAble(button, false);

                        if(response.comment != undefined || response.comment != null || response.comment != []){
                            var comment = response.comment.principal_comment;
                            var promotion_comment = response.comment.promotion_comment;
                            document.getElementById('attendance_principal_comment').value = comment ?? '';
                            // document.getElementById('attendance_promotion_comment').value = promotion_comment ?? '';
                        }else{
                            document.getElementById('attendance_principal_comment').value = '';
                            // document.getElementById('attendance_promotion_comment').value = '';
                        }

                        document.getElementById("student_principal").value = id;
                        document.getElementById('period_principal').value = period;
                        document.getElementById('term_principal').value = term;
                        $("#createPrincipalCommentModal").modal('toggle');

                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".uploadAffective").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createAffectiveModal").modal('toggle');

                    document.getElementById("affective_student_id").value = student;
                    document.getElementById('affective_period_id').value = period;
                    document.getElementById('affective_term_id').value = term;
                });

                $(".uploadPsychomotor").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createPsychomotorModal").modal('toggle');

                    document.getElementById("psychomotor_student_id").value = student;
                    document.getElementById('psychomotor_period_id').value = period;
                    document.getElementById('psychomotor_term_id').value = term;
                });

                $('.editPlayResult').click(function(e){
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.playgroup.student', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;
                        var html = '';

                        $.each(results, function(index, result) {
                            if (typeof result.remark !== 'string') {
                                var formattedRemark = [];

                                for( var key in result.remark) {
                                    if(result.remark.hasOwnProperty(key)){
                                        formattedRemark.push(key + ': ' + result.remark[key]);
                                    }
                                }

                                result.remark   = formattedRemark.join('. ');

                            }

                            html += '<tr>';
                            html += '<td style="width: 5%">';
                            html += '<p class="text-left">' + result.subject_name + '</p>';
                            html += '</td>';
                            html += '<td>';
                            html += '<input type="hidden" value="' + result.subject_id + '" name="subject_id[]" />';
                            html += '<input type="text" name="remark[' + result.subject_id + ']" class="form-control block w-full mt-1" style="height: 60px" value="'+ result.remark+'" />';
                            html += '</td>';
                            html += '</tr>';

                        });

                        document.getElementById('edit_playgroup_student').value = response.student_id;
                        document.getElementById('edit_playgroup_period').value = response.period_id;
                        document.getElementById('edit_playgroup_term').value = response.term_id;

                        $('#edit-play-result tbody').html(html);
                        $(".editPlayModal").modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

            }).fail((error) => {
                toggleAble(button, false);
                toastr.error(error.responseJSON.message);
                console.log(error);
            });
        });

        $(document).on('submit', '#uploadPlaygroupResult', function(e){
            e.preventDefault();
            
            var button = "#upload_playgroup_btn"
            toggleAble(button, true, 'Submitting Result...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');

            $.ajax({
                method: 'POST',
                url,
                data
            }).done((response) => {
                toggleAble(button, false);
                resetForm($(this));
                toastr.success(response.message, 'Submitted Successfully!');
                $('.editPlayModal').modal('toggle');
            }).fail((error) => {
                toggleAble(button, false);
                console.log(error.responseJSON.message);
            });
           
        });

        $(document).ready(function(){
            $('.exam-input').prop('disabled', true);

            $('#format-select').on('change', function() {
                var selectedFormat = $(this).val();
                $('.exam-input').prop('disabled', true);
                
                if (selectedFormat !== '') {
                    $('.exam-input').prop('disabled', false);
                    $('.exam-input').attr('name', selectedFormat);
                    } else {
                    $('.exam-input').attr('name', '');
                }
            });
        });

        function validateInput(input) {
            var selectedFormat = $('#format-select').val();
            var marks = JSON.parse('<?php echo json_encode($examForm); ?>');
            var mark = parseFloat(marks[selectedFormat].mark);
            var value = parseFloat(input.value);

            if (value > mark) {
                input.classList.add('is-invalid');
                input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
            } else {
                input.nextElementSibling.textContent = '';
                input.classList.remove('is-invalid');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            var student_uuid = $("input[name=student_uuid]").val();
            var period_id = $("input[name=period_id]").val();
            var term_id = $("input[name=term_id]").val();
            
            $('#createAffective').submit((e) => {
                e.preventDefault();
                toggleAble('#affective_button', true, 'Submitting...');

                var data = $('#createAffective').serializeArray();
                var url = "<?php echo e(route('result.affective.upload')); ?>";

                $.ajax({
                    type: "POST",
                    url,
                    data,
                }).done((res) => {
                    toggleAble('#affective_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createAffective');
                     $("#createAffectiveModal").modal('toggle');
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#affective_button', false);
                });
            });

            $('#createPsychomotor').submit((e) => {
                e.preventDefault();
                toggleAble('#psychomotor_button', true, 'Submitting...');

                var data = $('#createPsychomotor').serializeArray();
                var url = "<?php echo e(route('result.psychomotor.upload')); ?>";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#psychomotor_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createPsychomotor');
                    $("#createPsychomotorModal").modal('toggle');

                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#psychomotor_button', false);
                });

                
            });

            $('#createComment').submit((e) => {
                e.preventDefault();
                toggleAble('#submit_comment', true, 'Submitting...');

                var data = $('#createComment').serializeArray();
                var url = '/result/cognitive/upload';
                var type = $(this).attr('method')

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit_comment', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createCommentModal").modal('toggle');
                        
                    }
                }).fail((res) => {
                    toggleAble('#submit_comment', false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $('#createPrincipalComment').submit((e) => {
                e.preventDefault();
                var button = "#submit_principal_comment";
                toggleAble(button, true, 'Submitting...');

                var data = $('#createPrincipalComment').serializeArray();
                var url = '<?php echo e(route('result.principal.comment.upload')); ?>';

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createPrincipalCommentModal").modal('toggle');
                    }
                }).fail((res) => {
                    toggleAble(button, false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.psychomotor.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                psy = data
                if(data.length > 0){
                    $("#psychomoting").css("display", "none");
                }
            });

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.affective.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#affecting").css("display", "none");
                }
            })

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.cummulative.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#cummulative").css("display", "none");
                }
            })
            
        });
    </script>

    <script>
        function publish(student){
            var data = student.split(",");
            var student_id = data[0];
            var period_id = data[1];
            var term_id = data[2];
            var grade_id = data[3];
            
            toggleAble('#cummulative'+ student_id, true);

            $.ajax({
                url: '<?php echo e(route('result.primary.publish')); ?>' ,
                method: 'GET',
                data: {student_id, period_id, term_id, grade_id }
            }).done((res) => {
                toggleAble('#cummulative'+ student_id, false);
                toastr.success(res.message, 'Success!');
            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#cummulative'+ student_id, false);
            });
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $(document).on('click', '.remove', function(e) {
            e.preventDefault();
            var button = $(this);
            toggleAble(button, true);
            var resultId = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                    title: 'Confirm Deletion',
                    text: 'Are you sure you want to delete this item?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    $.ajax({
                        url: "<?php echo e(route('result.delete.exam', ["result_id" => ":result_id"])); ?>".replace(':result_id', resultId),
                        method: 'DELETE',
                        success: function(response) {
                            toggleAble(button, false);
                            Swal.fire('Deleted!', response.message, 'success');
                            row.remove();
                            setTimeout(function(){
                                window.location.reload();
                            },1000)
                        },
                        error: function(response) {
                            toggleAble(button, false);
                            console.log(response.responseJSON.message);
                        }
                    });
                    
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#resultUpload').on('submit', function(event) {
            event.preventDefault();
            var button = $('#submit_button')
            toggleAble(button, true, 'Submitting...');
            var selectedFormat = $('#format-select').val();

            if (selectedFormat === '') {
                toastr.info('Please select the score type', 'Note!');
                toggleAble(button, false);
                return;
            }else{
                let inputs = $('.midterm-input.required');
                let invalid = false;

                inputs.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').html('This field is required.');
                        invalid = true;
                    }
                });

                if (invalid) {
                    toggleAble(button, false);
                    toastr.error('Please fill in all required fields.', 'Validation Error!');
                    return;
                }

                var url = "<?php echo e(route('result.add.exam')); ?>";
                var data = $('#resultUpload').serializeArray();

                var period = $('#period_id').val();
                var term = $('#term_id').val();

                data.push({ 
                    name: 'format', value: selectedFormat,
                });

                data.push({ 
                    name: 'period_id', value: period,
                });

                data.push({ 
                    name: 'term_id', value: term,
                });

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#resultUpload');
                }).fail((err) => {
                    toggleAble(button, false);
                    let allErrors = Object.values(err.responseJSON).map(el => (
                    el = `<li>${el}</li>`
                    )).reduce((next, prev) => (next = prev + next));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>${allErrors}</ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;

                    $('.modalErrorr').html(setErrors);
                });
            }
        })

        $('#refreshResult').on('submit', function(e){
            e.preventDefault();
            var button = $('#refresh_button');
            toggleAble(button, true, 'Refreshing...');

            var url = "<?php echo e(route('result.add.exam')); ?>";
            var data = $('#refreshResult').serializeArray();

            Swal.fire({
                title: 'Confirm Refreshing',
                text: 'Are you sure you want to refresh the scores?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Refresh'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    
                    $.ajax({
                        url: '<?php echo e(route('result.refresh')); ?>',
                        type: 'POST',
                        data,
                    }).done((response) => {
                        toggleAble(button, false);
                        Swal.fire('Updated!', response.message, 'success');
                        resetForm('#refreshResult');
                        $('.refreshResultModal').modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#setCummulative').on('submit', function(e){
            e.preventDefault();
            var button = $('#set_button');
            toggleAble(button, true, 'Setting cummulative...');

            var url = "<?php echo e(route('result.calculate.class.cummulative')); ?>";
            var data = $('#setCummulative').serializeArray();

            Swal.fire({
                title: 'Confirm Setting cummulative',
                text: 'Are you sure you want to set the cummulatives?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cummulate'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    
                    $.ajax({
                        url,
                        type: 'POST',
                        data,
                    }).done((response) => {
                        toggleAble(button, false);
                        Swal.fire('Updated!', response.message, 'success');
                        resetForm('#setCummulative');
                        
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#generateResult').on('submit', function(e){
            e.preventDefault();
            var button = $('#generate_button');
            toggleAble(button, true, 'Refreshing...');

            var url = "<?php echo e(route('result.generate.midterm')); ?>";
            var data = $('#generateResult').serializeArray();

            Swal.fire({
                title: 'Confirm Refreshing',
                text: 'Are you sure you want to generate the scores?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Generate'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    
                    $.ajax({
                        url,
                        type: 'POST',
                        data,
                    }).done((response) => {
                        toggleAble(button, false);
                        Swal.fire('Updated!', response.message, 'success');
                        resetForm('#refreshResult');
                        $('.generateResultModal').modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $(document).on('submit', '#excelResultUpload', function (e) {
            e.preventDefault();
            var button = $('#excel_upload_button')
            let formData = new FormData($('#excelResultUpload')[0]);
            toggleAble(button, true, 'Uploading Result...');

            Swal.fire({
                title: 'Confirm Uploading of Result',
                text: 'Are you sure you want to upload the file?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Upload'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    $.ajax({
                        method: "POST",
                        url: "<?php echo e(route('result.excel.exam.upload')); ?>",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        resetForm('#excelResultUpload')
                        $('.excelResultModal').modal('toggle');
                        Swal.fire('Uploaded!', res.message, 'success');
                    }).fail((err) => {
                        console.log(err);
                        toggleAble(button, false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#excel_grade_id').change(function(){
            var grade = $(this).val();
            var select = $('.student-select select');
            select.empty();

            $.ajax({
                url: "<?php echo e(route("result.get.students", ["grade_id" => ":grade_id"])); ?>".replace(':grade_id', grade),
                method: 'GET',
                success: function(response) {
                    var students = response;
                    select.empty();
                    $.each(students, function (index, student) {
                        var option = $('<option>');
                        option.attr('value', student.uuid);
                        option.text(student.last_name + ' ' + student.first_name + ' ' + student.other_name);
                        select.append(option);
                    });

                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        });

        $('#publishSelected').on('click', function(){
            var button = $(this);
            toggleAble(button, true, 'Publishing...');

            var selectedStudents = [];
            $('input[name="ids[]"]:checked').each(function() {
                var id = $(this).val();
                selectedStudents.push({
                    id: id,
                });
            });

            var studentsIds = JSON.stringify(selectedStudents);
            var period_id = $(this).data('period');
            var term_id = $(this).data('term');
            var grade_id = $(this).data('grade');

            var postData = {
                studentsIds: studentsIds,
                period_id: period_id,
                term_id: term_id,
                grade_id: grade_id
            };

            var url = "<?php echo e(route('admin.result.multipleExamPublish')); ?>";

            $.ajax({
                method: "POST",
                url,
                data: postData
            }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
            }).fail((err) => {
                toggleAble(button, false);
                toastr.error(err.responseJSON.message, 'Failed!');
            });
        });

    </script>
    <?php $__env->stopSection(); ?>

</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\result\check-primary.blade.php ENDPATH**/ ?>