<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name') . " | $title"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"><?php echo e($description); ?></h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

      <div class="row mt-2 mb-2">
        <div class="col-sm-4">
            <div class="search-box me-2 mb-2 d-inline-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." id="input-search">
                    <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="">
                <button type="button"
                    class="btn btn-outline-primary w-sm createContact" data-type="mother">
                    Save Mother's Contact
                </button>
                <button type="button"
                    class="btn btn-outline-primary w-sm createContact" data-type="father">
                    Save Father's Contact
                </button>
                <button id="createNewContact" type="button"
                    class="btn btn-outline-secondary w-sm">
                    <i class="bx bx-edit"></i>
                   Create Contact
                </button>
                <button id="sendMultipleMessage" type="button"
                    class="btn btn-primary w-sm">
                   Send Message
                </button>
                <button id="scheduleMultipleMessage" type="button"
                    class="btn btn-secondary w-sm">
                   Schedule Message
                </button>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check search-table">
                    <thead class="table-light header-item">
                        <tr>
                            <th style="width: 20px;" class="align-middle">
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        wire:model="selectPageRows">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th class="align-middle"> Name </th>
                            <th class="align-middle"> Number</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody class="search-row">
                        <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="search-items">
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input schedule-checkbox" data-rows-group-id="data" id="<?php echo e($contact['id']); ?>" data-id="<?php echo e($contact['phone_number']); ?>" value="<?php echo e($contact['phone_number']); ?>"
                                            type="checkbox">
                                        <label class="form-check-label" for="<?php echo e($contact['id']); ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <?php echo e($contact['name']); ?>

                                </td>
                                <td>
                                    <?php echo e($contact['phone_number']); ?>

                                </td>
                                <td>
                                    <?php if($contact['status'] == 1): ?>
                                        <span class="badge bg-success"><i class="bx bx-check"></i> Active </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bx bx-times"></i> Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-danger btn-sm" data-id="<?php echo e($contact['id']); ?>"><i class="bx bx-trash"></i></button>
                                        <button class="btn btn-primary btn-sm sendMessage" data-id="<?php echo e($contact['id']); ?>" data-phone="<?php echo e($contact['phone_number']); ?>"><i class="bx bx-send"></i></button>
                                        <button class="btn btn-success btn-sm scheduleMessage" data-id="<?php echo e($contact['id']); ?>"><i class="bx bx-time"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <?php if(count($contacts) > 0): ?>
                    <?php echo e($contacts->links('pagination::bootstrap-4')); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade createNewContactModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a new contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="card-title">Add new contact</h4>
                    <form id="contactForm" action="<?php echo e(route('admin.whatsapp.storeContact')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'name','value' => ''.e(__('Name')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'name','value' => ''.e(__('Name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'name','class' => 'block w-full mt-1','type' => 'text','name' => 'name','value' => old('name'),'placeholder' => 'John Doe']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'name','class' => 'block w-full mt-1','type' => 'text','name' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name')),'placeholder' => 'John Doe']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'name']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                         <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'phone_number','value' => ''.e(__('Phone number')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'phone_number','value' => ''.e(__('Phone number')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'phone_number','class' => 'block w-full mt-1','type' => 'text','name' => 'phone_number','value' => old('phone_number'),'placeholder' => '09066100815']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'phone_number','class' => 'block w-full mt-1','type' => 'text','name' => 'phone_number','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('phone_number')),'placeholder' => '09066100815']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'phone_number']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'phone_number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>


                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'type','value' => ''.e(__('Type')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'type','value' => ''.e(__('Type')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <select class="form-control" name="type">
                                <option>Select</option>
                                <option value="default">Default</option>
                                <option value="group">Group</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_contact" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade parentContactModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Parent's to Impression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="parentContactCreate" method="POST">
                        <?php echo csrf_field(); ?>
                        <div>
                            <div class="table-responseive">
                                <table class="parent-contact">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkParentContactAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <button id="btn_contact" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade sendMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send message to contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendMessageForm" action="<?php echo e(route('admin.whatsapp.sendMessage')); ?>">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="phone_number" id="send_phone_number" />

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'message','value' => ''.e(__('Message')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'message','value' => ''.e(__('Message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_single_message" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade sendMessageMultipleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Message To Parent's Whatsapp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendMultipleMessageForm" action="<?php echo e(route('admin.whatsapp.sendMultipleMessage')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- <div class="col-sm-12 mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input success" type="checkbox" id="success-check" value="mother" name="to">
                                        <label class="form-check-label" for="success-check">Mother</label>
                                    </div>
                                </div>
                        
                                <div class="col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input success" type="checkbox" id="success-check" value="father" name="to">
                                        <label class="form-check-label" for="success-check">Father</label>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'message','value' => ''.e(__('Message')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'message','value' => ''.e(__('Message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <textarea rows="7" class="form-control" id="bulk_message" value="old('message')" name="message"></textarea>
                        </div>


                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_multiple_message" type="button" class="btn btn-primary block waves-effect waves-light pull-right">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scheduleMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule message for contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleMessageForm" action="<?php echo e(route('admin.whatsapp.scheduleMessage')); ?>">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="contacts[]" id="schedule_phone_id" />

                        <div class="row">
                            
                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'from','value' => ''.e(__('From')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'from','value' => ''.e(__('From')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'from','class' => 'block w-full mt-1','type' => 'date','name' => 'from']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'from','class' => 'block w-full mt-1','type' => 'date','name' => 'from']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'from']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'from']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'to','value' => ''.e(__('To')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'to','value' => ''.e(__('To')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'to','class' => 'block w-full mt-1','type' => 'date','name' => 'to']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'to','class' => 'block w-full mt-1','type' => 'date','name' => 'to']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'to']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'to']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'time','value' => ''.e(__('Time')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'time','value' => ''.e(__('Time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'time','class' => 'block w-full mt-1','type' => 'time','name' => 'time']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'time','class' => 'block w-full mt-1','type' => 'time','name' => 'time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'time']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'method','value' => ''.e(__('Method')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'method','value' => ''.e(__('Method')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <select class="form-control" name="method" :value="old('method')">
                                    <option>Select</option>
                                    <option value="once">Once</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'message','value' => ''.e(__('Message')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'message','value' => ''.e(__('Message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_single_schedule" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scheduleMultipleMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule message for contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleMultipleMessageForm" action="<?php echo e(route('admin.whatsapp.scheduleMessage')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            
                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'from','value' => ''.e(__('From')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'from','value' => ''.e(__('From')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'from','class' => 'block w-full mt-1','type' => 'date','name' => 'from']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'from','class' => 'block w-full mt-1','type' => 'date','name' => 'from']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'from']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'from']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'to','value' => ''.e(__('To')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'to','value' => ''.e(__('To')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'to','class' => 'block w-full mt-1','type' => 'date','name' => 'to']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'to','class' => 'block w-full mt-1','type' => 'date','name' => 'to']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'to']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'to']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'time','value' => ''.e(__('Time')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'time','value' => ''.e(__('Time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'time','class' => 'block w-full mt-1','type' => 'time','name' => 'time']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'time','class' => 'block w-full mt-1','type' => 'time','name' => 'time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'time']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'method','value' => ''.e(__('Method')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'method','value' => ''.e(__('Method')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <select class="form-control" name="method" :value="old('method')">
                                    <option>Select</option>
                                    <option value="once">Once</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'message','value' => ''.e(__('Message')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'message','value' => ''.e(__('Message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_multiple_schedule" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $('#submit_contact').on('click', function(){
                var button = $(this);
                toggleAble(button, true, "Creating...");

                var url = $('#contactForm').attr('action');
                var data = $('#contactForm').serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#createNewContact').on('click', function(){
                $('.createNewContactModal').modal('show');
            });

            $('.createContact').on('click', function() {
                var button = $(this);
                toggleAble(button, true);
                var type = $(this).data('type');
                var url = "<?php echo e(route('admin.whatsapp.merge_contact', ['type' => ':type'])); ?>".replace(':type', type);

                $.ajax({
                    method: "GET",
                    url,
                }).done((response) => {
                        toggleAble(button, false);
                        contacts = response.data;
                        displayContacts(contacts);
                        $('.parentContactModal').modal('show');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#parentContactCreate').submit(function(event) {
                event.preventDefault(); 
                var button = $('#btn_contact');
                toggleAble(button, true, 'Creating...');

                var selectedContacts = [];
                $('input[name="ids[]"]:checked').each(function() {
                    var id = $(this).val();
                    var name = $('#' + id + '-name').val();
                    var number = $('#' + id + '-number').val();

                    selectedContacts.push({
                        id: id,
                        name: name,
                        phone_number: number,
                    });
                });

                var url = "<?php echo e(route('admin.whatsapp.createMultipleContacts')); ?>";
                var jsonData = JSON.stringify(selectedContacts);

                $.ajax({
                    method: "POST",
                    url,
                    contentType: 'application/json',
                    data: jsonData
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

            
            $("#input-search").on("keyup", function () {
                var rex = new RegExp($(this).val(), "i");
                $(".search-table .search-items:not(.header-item)").hide();
                $(".search-table .search-items:not(.header-item)")
                    .filter(function () {
                        return rex.test($(this).text());
                    })
                .show();
            });

            $('.sendMessage').on('click', function(){
                var number = $(this).data('phone');
                $('#send_phone_number').val(number);
                $('.sendMessageModal').modal('show');
            });

            $('#submit_single_message').on('click', function(){
                var button = $(this);
                toggleAble(button, true, "Sending...");

                var url = $('#sendMessageForm').attr('action');
                var data = $('#sendMessageForm').serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        $('.sendMessageModal').modal('hide');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#sendMultipleMessage').on('click', function(){
                $('.sendMessageMultipleModal').modal('show');
            });

            // $('#submit_multiple_message').on('click', function(){
            //     var contacts = $('.contact-checkbox:checked').map(function () {
            //         return $(this).val();
            //     }).get();

            //     console.log(contacts);

            //         var button = $(this);
            //         toggleAble(button, true, "Sending...");

            //         var url = $('#sendMultipleMessageForm').attr('action');
            //         var data = $('#sendMultipleMessageForm').serializeArray();
            //         data.push({ name: 'contacts', value: contacts });

            //         $.ajax({
            //             method: "POST",
            //             url,
            //             data,
            //         }).done((res) => {
            //                 toggleAble(button, false);
            //                 toastr.success(res.message, 'Success!');
            //                 $('.sendMessageMultipleModal').modal('hide');
            //         }).fail((err) => {
            //             toggleAble(button, false);
            //             toastr.error(err.responseJSON.message, 'Failed!');
            //         });
              
            // });

            const sendMultipleMessage = new DashboardActionComponent(
                "#submit_multiple_message",
                'input[data-rows-group-id="data"]:checked',
                "<?php echo e(route('admin.whatsapp.sendMultipleMessage')); ?>",
                "broadcast",
                "bulk_message"
            );

            $('.scheduleMessage').on('click', function(){
                var id = $(this).data('id');
                $('#schedule_phone_id').val(id);
                $('.scheduleMessageModal').modal('show');
            });

            $('#scheduleMultipleMessage').on('click', function(){
                $('.scheduleMultipleMessageModal').modal('show');
            });

            $('#scheduleMessageForm').submit(function(event) {
                event.preventDefault(); 
                var button = $('#submit_single_schedule');
                toggleAble(button, true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#scheduleMessageForm');
                        $('.scheduleMessageModal').modal('hide');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#scheduleMultipleMessageForm').submit(function(event) {
                event.preventDefault(); 
                var button = $('#submit_multiple_schedule');
                toggleAble(button, true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                var contacts = $('.schedule-checkbox:checked').map(function () {
                    return $(this).data('id');
                }).get();

                data.push({'name': 'contacts', 'value': contacts});

                if (contacts.length > 0){
                    $.ajax({
                        method: "POST",
                        url,
                        data
                    }).done((res) => {
                            toggleAble(button, false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#scheduleMultipleMessageForm');
                            $('.scheduleMultipleMessageModal').modal('hide');
                    }).fail((err) => {
                        toggleAble(button, false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                }else{
                    toastr.info('Please select a contacts', 'Info');
                    toggleAble(button, false);
                }
            });

            function displayContacts(data){
                var tableRows = '';

                data.forEach(function(contact) {
                    tableRows += `
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input contact-checkbox" id="${contact['phone_number']}" name="ids[]" value="${contact['phone_number']}"} />
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control w-full" id="${contact['phone_number']}-name" name="names[]" value="${contact['name']}"} />
                            </td>
                            <td>
                                <input type="text" class="form-control w-full" id="${contact['phone_number']}-number" name="numbers[]" value="${contact['phone_number']}"} disabled />
                            </td>
                        </tr>
                    `;
                });

                $('.parent-contact tbody').html(tableRows);
            }

            document.getElementById("checkParentContactAll").addEventListener("change", function () {
                const isChecked = this.checked;
                const checkboxes = document.querySelectorAll(".contact-checkbox");

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\whatsapp\contact.blade.php ENDPATH**/ ?>