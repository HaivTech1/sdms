  <div class="row">
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

      <div class="col-12">
          <div class="card">
              <div class="card-body">
                    <?php if (\Illuminate\Support\Facades\Blade::check('hasPaid')): ?>
                        <form wire:submit.prevent="fetchResult" class="repeater" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo e($user->student->grade_id); ?>" name="grade_id" />
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="row">
                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Grade</label>
                                        <select class="form-control " wire:model.defer="grade_id">
                                            <option value=''>Choose...</option>
                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($grade); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'grade_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'grade_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Session</label>
                                        <select class="form-control " wire:model.defer="period_id">
                                            <option value=''>Choose...</option>
                                            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($period); ?></option>
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

                                    <div class="mb-3 col-lg-3">
                                        <label for="email">Term</label>
                                        <select id="formrow-inputState" class="form-select" wire:model.defer="term_id">
                                            <option selected>Choose...</option>
                                            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($term); ?></option>
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

                                    <div class="col-lg-3 align-self-center">
                                        <div class="d-grid">
                                            <button data-repeater-delete type="submit" class="btn btn-primary">
                                                <i class="bx bx-download"></i>
                                                Fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <?php if($student && $period_id && $term_id && $grade_id): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">
                                                        Class
                                                    </th>
                                                    

                                                    <th scope="col" class="text-center" id="action">
                                                        Action
                                                    </th>
                                                    
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class='text-center'><?php echo e($student->grade->title()); ?></td>
                                                    
                                                    
                                                    <td class='d-flex justify-content-center align-items-center'>
                                                        
                                                        <form action="<?php echo e(route('result.midterm.pdf')); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>

                                                            <input type="hidden" name="student_id" value="<?php echo e($student->id()); ?>" />
                                                            <input type="hidden" name="grade_id" value="<?php echo e($student->grade->id()); ?>" />
                                                            <input type="hidden" name="period_id" value="<?php echo e($period_id); ?>" />
                                                            <input type="hidden" name="term_id" value="<?php echo e($term_id); ?>" />

                                                            <button class="btn btn-sm btn-primary" type="submit">
                                                                <i class="bx bxs-file-pdf"></i> Download Result
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php elseif(!$student && $period_id && $term_id && $grade_id): ?>
                                    <div class="text-center">No result found!</div>
                                <?php else: ?>
                                    <div class="text-center">
                                        <i class="bx bx-search"></i><span>Search for results!</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="home-wrapper">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                            <div class="maintenance-img">
                                                <img src="<?php echo e(asset('images/maintenance.svg')); ?>" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="mt-5">You are owing <?php echo e(trans('global.naira')); ?> <?php echo e(number_format(hasPaidFullFee(auth()->user(), auth()->user()->student->grade_id)['owing'], 2)); ?></h3>
                                    <p> You can only have access to this page if you have paid your tuition fee for the term!</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
              </div>
          </div>
      </div>
  </div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\result\midterm.blade.php ENDPATH**/ ?>