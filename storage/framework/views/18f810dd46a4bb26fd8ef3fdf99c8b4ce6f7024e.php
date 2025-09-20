<div>
    <div class="row mt-2 mb-2">
        <?php if($selectedRows): ?>
            <div class="col-sm-1">
                <div class="btn-group btn-group-example" role="group">
                    <button wire:click.prevent="deleteAll" type="button"
                        class="btn btn-outline-danger w-sm">
                        <i class="bx bx-trash"></i>
                        Delete All
                </button>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-sm-1">
            <form action="<?php echo e(route('trip.download-pdf')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="btn-group btn-group-example" role="group">
                    <button type="submit"
                        class="btn btn-sm btn-primary w-sm">
                        Trips list
                    </button>
                </div>
            </form>
        </div>
        <div class="col-sm-1">
            <div class="btn-group btn-group-example" role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target=".generateTripPaidList" 
                    class="btn btn-sm btn-success w-sm">
                    Paid List
                </button>
            </div>
        </div>
        <div class="col-sm-1">
            <div class="btn-group btn-group-example" role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target=".generateTripUnPaidList"
                    class="btn btn-sm btn-danger w-sm">
                    Debtors list
                </button>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-8'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 20px;" class="align-middle">
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        wire:model="selectPageRows">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th class="align-middle"> Address </th>
                            <th class="align-middle"> Space</th>
                            <th class="align-middle"> Price </th>
                            <th class="align-middle"> Status </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" value="<?php echo e($trip->id()); ?>"
                                        type="checkbox" id="<?php echo e($trip->id()); ?>"
                                        wire:model="selectedRows">
                                    <label class="form-check-label" for="<?php echo e($trip->id()); ?>"></label>
                                </div>
                            </td>
                            <td>
                                <?php echo e($trip->address()); ?>

                            </td>
                            <td>
                                <?php echo e($trip->studentsCount()); ?>

                            </td>
                            <td>
                                <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($trip->price(), 2)); ?>

                            </td>
                            <td>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $trip,'field' => 'status'])->html();
} elseif ($_instance->childHasBeenRendered($trip->id())) {
    $componentId = $_instance->getRenderedChildComponentId($trip->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($trip->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($trip->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $trip,'field' => 'status']);
    $html = $response->html();
    $_instance->logRenderedChild($trip->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger btn-sm" wire:click="delete(<?php echo e($trip->id()); ?>)"><i class="bx bx-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <?php echo e($trips->links('pagination::custom-pagination')); ?>

            </div>
        </div>

        <div class='col-sm-4'>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add new trip</h4>
                    <form id="tripForm" method="POST" action="<?php echo e(route('trip.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'address','value' => ''.e(__('Address')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'address','value' => ''.e(__('Address')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'address','class' => 'block w-full mt-1','type' => 'text','name' => 'address','value' => old('address'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'address','class' => 'block w-full mt-1','type' => 'text','name' => 'address','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('address')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'address']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'address']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                         <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'price','value' => ''.e(__('Price')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'price','value' => ''.e(__('Price')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'price','class' => 'block w-full mt-1','type' => 'text','name' => 'price','value' => old('price'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'price','class' => 'block w-full mt-1','type' => 'text','name' => 'price','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('price')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'price']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'no_of_students','value' => ''.e(__('No of space')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'no_of_students','value' => ''.e(__('No of space')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'no_of_students','class' => 'block w-full mt-1','type' => 'text','name' => 'no_of_students','value' => old('no_of_students'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'no_of_students','class' => 'block w-full mt-1','type' => 'text','name' => 'no_of_students','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('no_of_students')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'no_of_students']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'no_of_students']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="split">Enable Split Payment: </label>
                                <input type="checkbox" id="split" name="split" value="1">
                            </div>
                        </div>

                        <div class="form-group mb-2" id="splitTypeField" style="display: none">
                            <label for="split_type">Split Type:</label>
                            <select name="split_type" id="split_type" class="form-control">
                                <option value="">Select payment type</option>
                                <option value="daily">Daily</option>
                                <option value="monthly">Monthly</option>
                                <option value="termly">Termly</option>
                            </select>
                        </div>

                         <div class="d-flex flex-wrap gap-2">
                            <button id="submit_trip" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade generateTripPaidList" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate trip paid list</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modalErrorr"></div>

                        <div class="row">
                            <form action="<?php echo e(route('trip.generate.paid')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                
                                <?php
                                    $grades = \App\Models\Grade::all();
                                    $periods = \App\Models\Period::all();
                                    $terms = \App\Models\Term::all();
                                ?>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" name="trip_id">
                                            <option value=''>Select Trip</option>
                                            <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trip->id()); ?>"><?php echo e($trip->address()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="grade_id">
                                            <option value=''>Class</option>
                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" name="period_id">
                                            <option value=''>Session</option>
                                            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="term_id">
                                            <option value=''>Term</option>
                                            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="generate_paid_list" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate List
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade generateTripUnPaidList" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate trip unpaid list</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modalErrorr"></div>

                        <div class="row">
                            <form action="<?php echo e(route('trip.generate.unpaid')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                
                                <?php
                                    $grades = \App\Models\Grade::all();
                                    $periods = \App\Models\Period::all();
                                    $terms = \App\Models\Term::all();
                                ?>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" name="trip_id">
                                            <option value=''>Select Trip</option>
                                            <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trip->id()); ?>"><?php echo e($trip->address()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="grade_id">
                                            <option value=''>Class</option>
                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" name="period_id">
                                            <option value=''>Session</option>
                                            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="term_id">
                                            <option value=''>Term</option>
                                            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="generate_paid_list" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate List
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->startSection('scripts'); ?>

        <script>
            $(document).ready(function() {
                $('#split').change(function() {
                    if ($(this).is(':checked')) {
                        $('#splitTypeField').show();
                    } else {
                        $('#splitTypeField').hide();
                    }
                });
            });
        </script>

        <script>
            $(document).on('submit', '#tripForm', function (e) {
                e.preventDefault();

                var button = $('#submit_trip');
                toggleAble(button, true, 'Submitting...');
                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#tripForm')
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000)
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\trip\index.blade.php ENDPATH**/ ?>