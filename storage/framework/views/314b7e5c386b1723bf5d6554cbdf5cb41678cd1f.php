<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"><?php echo e($user->user_type); ?></h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    

    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back to !</h5>
                                        <p><?php echo e(application('name')); ?></p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?php echo e(asset('images/profile-img.png')); ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-8">
                                    <div class="avatar-md profile-user-wid">
                                        <img src="<?php echo e(asset('storage/' . $user->image())); ?>" alt=""
                                            class="img-thumbnail rounded-circle avatar-sm">
                                    </div>
                                    <div>
                                        <h5><span class="badge badge-soft-info">Name:</span> <?php echo e($user->name()); ?></h5>
                                        <p class="text-muted mb-1"><span class="badge badge-soft-info">Reg No.:</span>
                                            <?php echo e($user->code()); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <?php
                        $news = \App\Models\News::all();
                        $hairstyles = \App\Models\Hairstyle::all();
                    ?>
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".newsModal">Create school news (<?php echo e($news->count()); ?>)</button>
                    <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".hairstyleModal">Create Hairstyle (<?php echo e($hairstyles->count()); ?>)</button>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-4">
                        <p style="font-weight: bold; font-size: 20px"><?php echo e(application('name')); ?></p>
                        <div class="mt-2">
                            <div class="onoffswitch3">
                                <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox"
                                    id="myonoffswitch3" checked>
                                <label class="onoffswitch3-label" for="myonoffswitch3">
                                    <span class="onoffswitch3-inner">
                                        <span class="onoffswitch3-active">
                                            <marquee class="scroll-text">
                                                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span><?php echo e($event->title()); ?>:
                                                        <?php echo e(strip_tags($event->description())); ?></span>
                                                    <span class="bx bx-caret-right"></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </marquee>
                                            <span class="onoffswitch3-switch">BREAKING NEWS <span
                                                    class="bx bx-x"></span></span>
                                        </span>
                                        <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch">SHOW
                                                BREAKING NEWS</span></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (\Illuminate\Support\Facades\Blade::check('bursal')): ?>
            <div class="row p-4">
                
            </div>
            <?php endif; ?>

            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                        $term_setting = termSetting(term('id'), period('id'))
                                    ?>

                                    <div>
                                        <?php if($term_setting): ?>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Session</p>
                                                        <h5 class="mb-0"><?php echo e($term_setting?->term?->title); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Term</p>
                                                        <h5 class="mb-0"><?php echo e($term_setting->period->title); ?></h5>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Resumption Date</p>
                                                        <h5 class="mb-0">
                                                            <?php echo e($term_setting?->resumption_date?->format('d-M-Y')); ?>

                                                        </h5>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Vacation Date</p>
                                                        <h5 class="mb-0">
                                                            <?php echo e($term_setting?->vacation_date?->format('d-M-Y')); ?>

                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert customize-alert alert-dismissible rounded-pill border-danger text-danger fade show d-flex align-items-center px-2"
                                                role="alert">
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target=".settingModal">Set
                                                </button>
                                                <div class="d-flex align-items-center font-medium me-3 me-md-0">
                                                    <i class="ti ti-info-circle fs-5 me-2 text-danger"></i>
                                                    Current Term setting not set yet. Please attend to this!!!
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    

    <div class="modal fade newsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create school news</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="news" action="<?php echo e(route('news.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'title','value' => ''.e(__('Title')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title','value' => ''.e(__('Title')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => old('title'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('title')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'title']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'description','value' => ''.e(__('Content')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description','value' => ''.e(__('Content')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <textarea class="form-control" name="description"
                                    id="summernote"><?php echo e(old('content')); ?></textarea>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'description']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Make news
                                        public</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="newBtn" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade hairstyleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new hairstyle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="hairstyleForm" action="<?php echo e(route('hairstyle.store')); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'title','value' => ''.e(__('Title')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title','value' => ''.e(__('Title')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => old('title')]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('title'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'title']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'description','value' => ''.e(__('Note')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description','value' => ''.e(__('Note')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <textarea class="form-control" name="description"><?php echo e(old('description')); ?></textarea>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'description']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="side_view_input" class="form-label">Side View:</label>
                                    <input type="file" id="side_view_input" class="form-control" name="side_view"
                                        accept="image/*"
                                        onchange="previewImage('side_view_input', 'side_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="side_view_preview" src="#" alt="Side view preview"
                                            style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="front_view_input" class="form-label">Front View:</label>
                                    <input type="file" id="front_view_input" class="form-control" name="front_view"
                                        accept="image/*"
                                        onchange="previewImage('front_view_input', 'front_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="front_view_preview" src="#" alt="Front view preview"
                                            style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="back_view_input" class="form-label">Back View:</label>
                                    <input type="file" id="back_view_input" class="form-control" name="back_view"
                                        accept="image/*"
                                        onchange="previewImage('back_view_input', 'back_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="back_view_preview" src="#" alt="Back view preview"
                                            style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activate</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="createHair" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>

    <script>
        $(document).ready(function () {
            // Populate student dropdown based on class selection
            $('#class-select').on('change', function () {
                var classId = $(this).val();
                $.ajax({
                    url: '/student/students-by-class',
                    method: 'GET',
                    data: { class: classId },
                }).done((data) => {
                    $('#student-select').empty();
                    $.each(data, function (index, student) {
                        $('#student-select').append('<option value="' + student.uuid + '">' + student.last_name + ' ' + student.first_name + ' ' + student.other_name + '</option>');
                    });
                }).fail((err) => {
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            // Update chart based on student selection
            $(document).on('submit', '#performance', function (e) {
                var existingChart = Chart.getChart("resultChat");

                e.preventDefault();

                toggleAble('#submit', true, 'Fetching...');
                var classId = $('#class-select').val();
                var studentId = $('#student-select').val();
                var term = $('#term-select').val();
                var session = $('#session-select').val();
                $.ajax({
                    url: '/student/performance-by-student',
                    method: 'GET',
                    data: { classId: classId, studentId: studentId, term: term, session: session },
                }).done((data) => {
                    toggleAble('#submit', false);

                    var subjects = [];
                    var scores = [];

                    $.each(data, function (index, result) {
                        var totalScore = result.ca1 + result.ca2 + result.project + result.exam;
                        subjects.push(result.subject);
                        scores.push(totalScore);
                    });

                    if (existingChart) {
                        existingChart.destroy();
                    }

                    var chartData = {
                        labels: subjects,
                        datasets: [
                            {
                                label: 'Total Score',
                                data: scores,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    };

                    var ctx = $('#resultChat');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }).fail((err) => {
                    toggleAble('#submit', false);
                    console.log(err);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $(document).on('submit', '#news', function (e) {
                e.preventDefault();
                toggleAble('#newBtn', true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();
                var method = $(this).attr('method');

                $.ajax({
                    url,
                    method,
                    data
                }).done((res) => {
                    if (res.status === true) {
                        toggleAble('#newBtn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#news')
                        $('.newsModal').modal('toggle');
                    }
                }).fail((err) => {
                    toggleAble('#newBtn', false);
                    console.log(err);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $(document).on('submit', '#settingTermForm', function (e) {
                e.preventDefault();
                toggleAble('#settingTermBtn', true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();
                var method = $(this).attr('method');

                $.ajax({
                    url,
                    method,
                    data
                }).done((res) => {
                    if (res.status === true) {
                        toggleAble('#settingTermBtn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#news')
                        $('.settingModal').modal('toggle');

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                }).fail((err) => {
                    toggleAble('#settingTermBtn', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

        });
    </script>

    <script>

        var audio = document.getElementById("myAudio");

        function playAudio() {
            audio.play();
        }

        function pauseAudio() {
            audio.pause();
        }

        <?php if(auth()->check() && auth()->user()->isAdmin() || auth()->check() && auth()->user()->isSuperAdmin()): ?>
            setInterval(function () {
                $.get({
                    url: '<?php echo e(route('pending.registration')); ?>',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            let data = response.data;
                            new_registration = data.new_registration;
                            if (new_registration > 0) {
                                playAudio();
                                $('#popup-modal').appendTo("body").modal('show');
                            }
                        }
                    },
                });
            }, 10000);
        <?php endif; ?>

        function check_registration() {
            window.location.href = "/index/registration";
        }
    </script>

    <script>
        var studentsData = <?php echo json_encode($studentsData); ?>;

        var years = [];
        var totals = [];

        studentsData.forEach(function (item) {
            years.push(item.year);
            totals.push(item.total);
        });

        var ctx = document.getElementById('studentsChart').getContext('2d');
        var studentsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: years,
                datasets: [{
                    label: 'Total Students per Year',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {

                        }
                    }]
                }
            }
        });
    </script>

    <script>
        $(document).on('submit', '#rankingForm', function (e) {

            e.preventDefault();
            var existingRanking = Chart.getChart("ranking");

            toggleAble('#rankingBtn', true, 'Fetching...');

            var classId = $('#grade-select').val();
            var term = $('#term').val();
            var session = $('#session').val();

            $.ajax({
                url: '/student/class-ranking-student',
                method: 'GET',
                data: { classId: classId, term: term, session: session },
            }).done((response) => {
                if (response.status) {
                    toggleAble('#rankingBtn', false);

                    var labels = [];
                    var data = [];

                    response.data.forEach(function (result) {
                        labels.push(result.name);
                        data.push(result.score);
                    });

                    if (existingRanking) {
                        existingRanking.destroy();
                    }

                    var ctx = document.getElementById('ranking').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Score',
                                data: data,
                                borderColor: 'rgb(75, 192, 192)',
                                fill: false
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                }
            }).fail((err) => {
                console.log(err);
                toggleAble('#rankingBtn', false);
                toastr.error(err.responseJSON.message, 'Failed!');
            });
        });
    </script>

    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.setAttribute('src', e.target.result);
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.setAttribute('src', '#');
                preview.style.display = 'none';
            }
        }
    </script>

    
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\dashboard.blade.php ENDPATH**/ ?>