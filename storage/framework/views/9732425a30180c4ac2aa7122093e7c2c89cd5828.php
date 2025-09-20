<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Messaging</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Email Messaging</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form id="send-mail-form" role="form" method="post" action="<?php echo e(route('messaging.sendMail')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <?php if(isset($_GET['mail'])) { ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['type' => 'email','id' => 'inputEmail','name' => 'to[]','class' => 'block w-full mt-1','value' => ''.$_GET['mail'].' ']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','id' => 'inputEmail','name' => 'to[]','class' => 'block w-full mt-1','value' => ''.$_GET['mail'].' ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php echo '</div>'; }else{ ?>
                                    <select class="form-control block w-full mt-1 select2-multiple" name="to[]"
                                        multiple="multiple" data-placeholder="Choose Receipient..." id="num-selector"
                                        name="to[]">
                                        <optgroup label="Select Recepient">
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->email()); ?>"><?php echo e($user->name()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                        <optgroup label="Select guardian">
                                            <?php $__currentLoopData = $guardians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guardian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($guardian->email()); ?>"><?php echo e($guardian->fullName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'emails','type' => 'text','placeholder' => 'Type in comma seperated emails and click add','class' => 'form-control','ariaLabel' => 'Recipient\'s email','ariaDescribedby' => 'basic-addon2']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'emails','type' => 'text','placeholder' => 'Type in comma seperated emails and click add','class' => 'form-control','aria-label' => 'Recipient\'s email','aria-describedby' => 'basic-addon2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <button id="add-num" type="button"
                                            class="btn btn-primary block waves-effect waves-light pull-right">
                                            Add</button>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => []]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Subject <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['type' => 'text','id' => 'inputSubject','name' => 'subject','class' => 'block w-full mt-1','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'inputSubject','name' => 'subject','class' => 'block w-full mt-1','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                        </div>

                        <textarea class="form-control" id="demo-mail-textarea" rows="5" name="message"
                            placeholder="type in your message"></textarea>

                        <div class="d-flex justify-content-center flex-wrap mt-5">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Send
                                Mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/demo/mail.js')); ?>"></script>

    <script>
        // for email manual number input
      
          $(document).ready(function () {
              $('#add-num').click(function () {
                  if (!$('#emails').val()) {
                      return;
                  }

                  var items = $('#emails').val().split(',');

                  $('#emails').val('');

                  $.each(items, function (i, item) {
                      //$("#list").append('<li class="list-group-item d-flex justify-content-between align-items-center">'+ item +'  <span class="badge badge-danger badge-pill"><i onClick="rm_num(this);" class="btn fa fa-trash"></i></span></li>');
                      $('#num-selector').append($('<option>', {
                          value: item,
                          text: item,
                          selected: 'selected'
                      }, '</option>'));
                  });
                  var val = $('#num-selector').text().split(',');
                  $('#num-selector').selectpicker('refresh');
                  alert('Added ' + items);
                  $.each(val, function (i, item) {});
              });
      
              //add group function
          });
          //selected="selected" value="' + item +'" >'+ item +'</option>'
          function rm_num(d) {
              var text = $(d).parent().parent().text();
              var input = $("#num-selector option[value='" + text + "']").remove();
              var ll = $('#list ' + d).remove();
          }
    </script>
    <?php $__env->stopSection(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\messaging\email.blade.php ENDPATH**/ ?>