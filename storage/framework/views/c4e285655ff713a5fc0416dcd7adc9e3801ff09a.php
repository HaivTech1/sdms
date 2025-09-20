<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Settings Page"); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Setting</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card" x-data="{ currentTab: $persist('general')}">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li @click.prevent="currentTab = 'general'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'general' ? 'active' : ''" data-bs-toggle="tab" href="#general" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">General</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'mail'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'mail' ? 'active' : ''" data-bs-toggle="tab" href="#mail" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Mail</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'payment'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'payment' ? 'active' : ''" data-bs-toggle="tab" href="#payment" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Payment method</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'formats'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'formats' ? 'active' : ''" data-bs-toggle="tab" href="#formats" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-th-large"></i></span>
                                <span class="d-none d-sm-block">Formats</span>
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'notification'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'notification' ? 'active' : ''" data-bs-toggle="tab" href="#notification" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Actions</span>    
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane" :class="currentTab === 'general' ? 'active' : ''" id="general" role="tabpanel">
                            <div class="row">
                                <?php if (\Illuminate\Support\Facades\Blade::check('superadmin')): ?>
                                    <div class="col-md-12 mb-3 mt-3">
                                        <div class="card">
                                            <div class="card-body" style="padding-bottom: 12px">
                                                <div class="row">
                                                    <?php ($config = get_application_settings('maintenance_mode')); ?>
                                                    <div class="col-6">
                                                        <h5 class="text-capitalize">
                                                            <i class="bx bx-cog"></i>
                                                            <?php echo e(translate('messages.maintenance_mode')); ?>

                                                        </h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="switch ml-3 float-right">
                                                            <input type="checkbox" class="form-check-input status" onclick="maintenance_mode()"
                                                                <?php echo e(isset($config) && $config ? 'checked' : ''); ?>>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('manager.application', [])->html();
} elseif ($_instance->childHasBeenRendered('YN5ktvX')) {
    $componentId = $_instance->getRenderedChildComponentId('YN5ktvX');
    $componentTag = $_instance->getRenderedChildComponentTagName('YN5ktvX');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YN5ktvX');
} else {
    $response = \Livewire\Livewire::mount('manager.application', []);
    $html = $response->html();
    $_instance->logRenderedChild('YN5ktvX', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            </div> 
                        </div>

                        <!-- New Formats tab-pane -->
                        <div class="tab-pane" :class="currentTab === 'formats' ? 'active' : ''" id="formats" role="tabpanel">
                            <div class="card">
                            <div class="card-body">
                                <h1 class="card-title mt-2 mb-2">Marks format for midterm and exam control unit</h1>

                                <div class="row mb-2">
                                    <button type="button" onclick="copyDataFormat()" class="btn btn-sm btn-primary">Copy marks format</button>
                                </div>

                                <form id="settingForm" enctype="multipart/form-data" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <table class="table table-bordered" id="settingTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = \App\Models\Setting::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(!in_array($setting->key, ['mail_config', 'digital_payment',
                                                    'paystack', 'cash', 'over_ten', 'over_twenty', 'over_fourty',
                                                    'over_sixty', 'over_hundred', 'exam_grade', 'exam_grade_jun',
                                                    'exam_remark', 'exam_remark_jun', 'affective_domain',
                                                    'psychomotor_domain', 'app_type', "paypal"]) && $setting->value != 1
                                                    && $setting->value != 0): ?>
                                                        <?php $data = json_decode($setting->value, true); ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[<?php echo e($loop->index); ?>][key]" value="<?php echo e($setting->key); ?>" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[<?php echo e($loop->index); ?>][value]"
                                                                    value="<?php echo e(implode(',', array_map(function ($key, $value) { $v = is_array($value) ? $value : ['full_name' => (string)$value, 'mark' => '']; return $key.':'.($v['full_name'] ?? '').':'.($v['mark'] ?? ''); }, array_keys((array)$data), (array)$data))); ?>"
                                                                    class="form-control"
                                                                    placeholder="Enter data in the format: code:title:mark eg - first_test:First Test:15,entry_2:Entry 2:20,ca:Continuous Assessment:30,project:Project:25"
                                                                />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php if(\App\Models\Setting::count() == 0): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="addmore[0][key]"
                                                                placeholder="Enter your name" class="form-control" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="addmore[0][value]"
                                                                placeholder="Enter data in the format: code:title:mark eg - first_test:First Test:15,entry_2:Entry 2:20,ca:Continuous Assessment:30,project:Project:25" class="form-control" />
                                                        </td>
                                                        <td>
                                                            <button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        
                                    </div>

                                    <div class="float-right">
                                        <button id="settingBtn" class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title mt-2 mb-2">Grading and Color control unit</h1>
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <button type="button" onclick="copyColorFormat()" class="btn btn-sm btn-primary">Copy color format</button>
                                        </div>
                                        <div class="col-sm-6">

                                            <?php $__currentLoopData = colorArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $hex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <button onclick="copyToColorClipboard('<?php echo e($hex); ?>')" class="btn btn-sm text-white" style="background-color: <?php echo e($hex); ?>;"><?php echo e($name); ?></button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                    <form id="colorForm" enctype="multipart/form-data" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <table class="table table-bordered" id="colorTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $settings = \App\Models\Setting::whereIn('key', [
                                                            'over_ten', 'over_twenty', 'over_fourty', 'over_sixty', 'over_hundred',
                                                        ])->get();
                                                    ?>
                                                    
                                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $data = json_decode($setting->value, true); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][key]" value="<?php echo e($setting->key); ?>" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][value]"
                                                                        value="<?php echo e(implode(',', array_map(function ($key, $value) { $v = is_array($value) ? $value : ['from' => '', 'color' => (string)$value]; return $key.':'.($v['from'] ?? '').':'.($v['color'] ?? ''); }, array_keys((array)$data), (array)$data))); ?>"
                                                                        class="form-control"
                                                                        placeholder="Enter data in the format: markfrom:markto:color eg - 8.5:10:#ff0022"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="addColor" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($settings->count() == 0): ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[0][key]"
                                                                    placeholder="Enter your name" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[0][value]"
                                                                    placeholder="Enter data in the format: markfrom:markto:color eg - 8.5:10:#ff0022" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="addColor" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                        <div class="float-right">
                                            <button id="colorBtn" class="btn btn-success" type="submit">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title mt-2 mb-2">Exam grade and remark control unit</h1>
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <button type="button" onclick="copyToGradeClipboard()" class="btn btn-sm btn-primary">Copy grade format</button>
                                        </div>
                                    </div>
                                    <form id="gradeForm" enctype="multipart/form-data" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <table class="table table-bordered" id="gradeTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $settings = \App\Models\Setting::whereIn('key', [
                                                            'exam_grade', 'exam_remark', 'exam_grade_jun', 'exam_remark_jun'
                                                        ])->get();
                                                    ?>
                                                    
                                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $data = json_decode($setting->value, true); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][key]" value="<?php echo e($setting->key); ?>" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][value]"
                                                                        value="<?php echo e(implode(',', array_map(function ($key, $value) { $v = is_array($value) ? $value : ['from' => '', 'text' => (string)$value]; return $key.':'.($v['from'] ?? '').':'.($v['text'] ?? ''); }, array_keys((array)$data), (array)$data))); ?>"
                                                                        class="form-control"
                                                                        placeholder="Enter data in the format: markfrom:markto:text eg - 8.5:10:A"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="addGrade" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($settings->count() == 0): ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[0][key]"
                                                                    placeholder="Enter your name" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[0][value]"
                                                                    placeholder="Enter data in the format: markfrom:markto:text eg - 8.5:10:A" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="addGrade" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                        <div class="float-right">
                                            <button id="gradeBtn" class="btn btn-success" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title mt-2 mb-2">Affective and Psychomotor Domain</h1>

                                    <form id="affectiveForm" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <table class="table table-bordered" id="affectiveTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $domains = \App\Models\Setting::whereIn('key', [
                                                            'affective_domain', 'psychomotor_domain'
                                                        ])->get();
                                                    ?>
                                                    
                                                    <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $data = json_decode($domain->value, true); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][key]" value="<?php echo e($domain->key); ?>" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="addmore[<?php echo e($loop->index); ?>][value]"
                                                                        value="<?php echo e(implode(',', array_map(function ($key, $value) { 
                                                                                return is_array($value) ? implode('|', $value) : (string)$value; 
                                                                            }, 
                                                                            array_keys((array)$data), (array)$data))); ?>"
                                                                        class="form-control"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="addAffective" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($domains->count() == 0): ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[0][key]"
                                                                    placeholder="Enter domain" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[0][value]"
                                                                    placeholder="eg. hand-writing" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="addAffective" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                        <div class="float-right">
                                            <button id="affectiveBtn" class="btn btn-success" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" :class="currentTab === 'mail' ? 'active' : ''" id="mail" role="tabpanel">

                            <div class="row pb-2">
                                <div class="col-md-6 col-sm-8 card">
                                    <div class="card-body">
                                        <div>
                                            <p class="text-danger text-lg"><?php echo e(translate('test_your_email_integration')); ?></p>
                                        </div>

                                        <form class="config_form">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">
                                                            <?php echo e(translate('mail')); ?></label>
                                                        <input type="email" id="test-email" class="form-control"
                                                            placeholder="Ex : jhon@email.com">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <button type="submit" id="config_test" class="btn btn-primary mb-2 btn-block">
                                                        <i class="bx bx-paper-plane"></i>
                                                        <?php echo e(translate('send_mail')); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row gx-2 gx-lg-3">
                                <?php ($config = \App\Models\Setting::where(['key' => 'mail_config'])->first()); ?>
                                <?php ($data = $config ? json_decode($config['value'], true) : null); ?>

                                <form id="mail-setup" class="card-body" action="<?php echo e(route('appSetting.mail_config')); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                    
                                    <div class="col-sm-12 from-group mb-2 text-center">
                                        <label class="control-label h3"><?php echo e(translate('smtp_mail_config')); ?></label>
                                    </div>
                                    <div class="col-sm-12 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('status')); ?></label>
                                    </div>
                                    <div class="col-sm-12 from-group mb-2 mt-2">
                                        <input type="radio" name="status" value="1"
                                            <?php echo e(isset($data['status']) && $data['status'] == 1 ? 'checked' : ''); ?>>
                                        <label style="padding-left: 10px"><?php echo e(translate('Active')); ?></label>
                                        <br>
                                    </div>
                                    <div class="col-sm-12 from-group mb-2">
                                        <input type="radio" name="status" value="0"
                                            <?php echo e(isset($data['status']) && $data['status'] == 0 ? 'checked' : ''); ?>>
                                        <label style="padding-left: 10px"><?php echo e(translate('Inactive')); ?></label>
                                        <br>
                                    </div>
                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.mailer')); ?>

                                            <?php echo e(translate('messages.name')); ?></label><br>
                                        <input type="text" placeholder="ex : Alex" class="form-control" name="name"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['name'] ?? '' : ''); ?>" required>
                                    </div>

                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.host')); ?></label><br>
                                        <input type="text" class="form-control" name="host"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['host'] ?? '' : ''); ?>" required>
                                    </div>
                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.driver')); ?></label><br>
                                        <input type="text" class="form-control" name="driver"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['driver'] ?? '' : ''); ?>" required>
                                    </div>
                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.port')); ?></label><br>
                                        <input type="text" class="form-control" name="port"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['port'] ?? '' : ''); ?>" required>
                                    </div>

                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.username')); ?></label><br>
                                        <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="username"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['username'] ?? '' : ''); ?>" required>
                                    </div>

                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.email')); ?>

                                            <?php echo e(translate('messages.id')); ?></label><br>
                                        <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="email"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['email_id'] ?? '' : ''); ?>" required>
                                    </div>

                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.encryption')); ?></label><br>
                                        <input type="text" placeholder="ex : tls" class="form-control" name="encryption"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['encryption'] ?? '' : ''); ?>" required>
                                    </div>

                                    <div class="col-sm-6 from-group mb-2">
                                        <label style="padding-left: 10px"><?php echo e(translate('messages.password')); ?></label><br>
                                        <input type="text" class="form-control" name="password"
                                            value="<?php echo e(env('APP_MODE') != 'local' ? $data['password'] ?? '' : ''); ?>" required>
                                    </div>

                                    <button id="mail-btn" type="submit" class="btn btn-primary mb-2"><?php echo e(translate('messages.save')); ?>

                                    </button>

                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane" :class="currentTab === 'payment' ? 'active' : ''" id="payment" role="tabpanel">
                            <div class="row">
                                <div class="row" style="padding-bottom: 20px">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body" style="padding: 20px">
                                                <h5 class="text-center"><?php echo e(translate('messages.payment')); ?> <?php echo e(translate('messages.method')); ?></h5>
                                                <?php ($config = get_application_settings('cash')); ?>
                                                <form action="<?php echo e(route('appSetting.payment-method-update',['cash'])); ?>"
                                                    method="post">
                                                    <?php echo csrf_field(); ?>
                                                    
                                                        <div class="form-group mb-2">
                                                            <label class="control-label"><?php echo e(translate('messages.cash')); ?></label>
                                                        </div>
                                                        <div class="form-group mb-2 mt-2">
                                                            <input type="radio" name="status" value="1" <?php echo e($config?($config['status']==1?'checked':''):''); ?>>
                                                            <label style="padding-left: 10px"><?php echo e(translate('messages.active')); ?></label>
                                                            <br>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <input type="radio" name="status" value="0" <?php echo e($config?($config['status']==0?'checked':''):''); ?>>
                                                            <label
                                                                style="padding-left: 10px"><?php echo e(translate('messages.inactive')); ?></label>
                                                            <br>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mb-2"><?php echo e(translate('messages.save')); ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body" style="padding: 20px">
                                                <h5 class="text-center"><?php echo e(translate('messages.payment')); ?> <?php echo e(translate('messages.method')); ?></h5>
                                                <?php ($digital_payment = get_application_settings('digital_payment')); ?>
                                                <form action="<?php echo e(route('appSetting.payment-method-update',['digital_payment'])); ?>"
                                                    method="post">
                                                    <?php echo csrf_field(); ?>
                                                        <div class="form-group mb-2">
                                                            <label
                                                                class="control-label text-capitalize"><?php echo e(translate('messages.digital')); ?> <?php echo e(translate('messages.payment')); ?></label>
                                                        </div>
                                                        <div class="form-group mb-2 mt-2">
                                                            <input type="radio" class="digital_payment" name="status" value="1" <?php echo e($digital_payment?($digital_payment['status']==1?'checked':''):''); ?>>
                                                            <label style="padding-left: 10px"><?php echo e(translate('messages.active')); ?></label>
                                                            <br>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <input type="radio" class="digital_payment" name="status" value="0" <?php echo e($digital_payment?($digital_payment['status']==0?'checked':''):''); ?>>
                                                            <label
                                                                style="padding-left: 10px"><?php echo e(translate('messages.inactive')); ?></label>
                                                            <br>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mb-2"><?php echo e(translate('messages.save')); ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row digital_payment_methods" style="padding-bottom: 20px">

                                    <div class="col-md-6" style="margin-top: 26px!important;">
                                        <div class="card">
                                            <div class="card-body" style="padding: 20px">
                                                <h5 class="text-center"><?php echo e(translate('messages.paystack')); ?></h5>
                                                <span class="badge badge-soft-danger"><?php echo e(translate('messages.paystack_callback_warning')); ?></span>
                                                <?php ($config=get_application_settings('paystack')); ?>
                                                <form
                                                    action="<?php echo e(env('APP_MODE')!='demo'?route('appSetting.payment-method-update',['paystack']):'javascript:'); ?>"
                                                    method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <?php if(isset($config)): ?>
                                                        <div class="form-group mb-2">
                                                            <label class="control-label"><?php echo e(translate('messages.paystack')); ?></label>
                                                        </div>
                                                        <div class="form-group mb-2 mt-2">
                                                            <input type="radio" name="status" value="1" <?php echo e($config['status']==1?'checked':''); ?>>
                                                            <label style="padding-left: 10px"><?php echo e(translate('messages.active')); ?></label>
                                                            <br>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <input type="radio" name="status" value="0" <?php echo e($config['status']==0?'checked':''); ?>>
                                                            <label style="padding-left: 10px"><?php echo e(translate('messages.inactive')); ?></label>
                                                            <br>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label
                                                                style="padding-left: 10px"><?php echo e(translate('messages.publicKey')); ?></label><br>
                                                            <input type="text" class="form-control" name="publicKey"
                                                                value="<?php echo e(env('APP_MODE')!='demo'?$config['publicKey']:''); ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="text-capitalize" style="padding-left: 10px"><?php echo e(translate('messages.secret')); ?> <?php echo e(translate('messages.key')); ?> </label><br>
                                                            <input type="text" class="form-control" name="secretKey"
                                                                value="<?php echo e(env('APP_MODE')!='demo'?$config['secretKey']:''); ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="text-capitalize" style="padding-left: 10px"><?php echo e(translate('messages.payment')); ?> <?php echo e(translate('messages.url')); ?></label><br>
                                                            <input type="text" class="form-control" name="paymentUrl"
                                                                value="<?php echo e(env('APP_MODE')!='demo'?$config['paymentUrl']:''); ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="text-capitalize" style="padding-left: 10px"><?php echo e(translate('messages.merchant')); ?> <?php echo e(translate('messages.email')); ?></label><br>
                                                            <input type="text" class="form-control" name="merchantEmail"
                                                                value="<?php echo e(env('APP_MODE')!='demo'?$config['merchantEmail']:''); ?>">
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"
                                                                onclick="<?php echo e(env('APP_MODE')!='demo'?'':'call_demo()'); ?>"
                                                                class="btn btn-primary mb-2"><?php echo e(translate('messages.save')); ?></button>
                                                            <button type="button" class="btn btn-info mb-2 pull-right" onclick="copy_text('<?php echo e(url('/')); ?>/paystack-callback')"><?php echo e(translate('messages.copy_callback')); ?></button>        
                                                        </div>

                                                        
                                                    <?php else: ?>
                                                        <button type="submit"
                                                                class="btn btn-primary mb-2"><?php echo e(translate('messages.configure')); ?></button>
                                                        

                                                        
                                                    <?php endif; ?>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" :class="currentTab === 'notification' ? 'active' : ''" id="notification" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mt-2 mb-2">Toggle notification settings</h4>

                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Father Notification</h5>
                                            <div>
                                                <input type="checkbox" id="father_notification" switch="success" data-field="father_notification" <?php if(get_settings('father_notification') === 1): ?> checked <?php endif; ?> />
                                                <label for="father_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Mother Notification</h5>
                                            <div>
                                                <input type="checkbox" id="mother_notification" switch="success" data-field="mother_notification" <?php if(get_settings('mother_notification') === 1): ?> checked <?php endif; ?> />
                                                <label for="mother_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Guardian Notification</h5>
                                            <div>
                                                <input type="checkbox" id="guardian_notification" switch="success" data-field="guardian_notification" <?php if(get_settings('guardian_notification') === 1): ?> checked <?php endif; ?> />
                                                <label for="guardian_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mt-2 mb-2">Application settings</h4>
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Registration Link</h5>
                                            <div>
                                                <input type="checkbox" id="registration_link" switch="success" data-field="registration_link" <?php if(get_settings('registration_link') === 1): ?> checked <?php endif; ?> />
                                                <label for="registration_link" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Check students payment</h5>
                                            <div>
                                                <input type="checkbox" id="check_payment" switch="success" data-field="check_payment" <?php if(get_settings('check_payment') === 1): ?> checked <?php endif; ?> />
                                                <label for="check_payment" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Activate mid term upload</h5>
                                            <div>
                                                <input type="checkbox" id="mid_upload" switch="success" data-field="mid_upload" <?php if(get_settings('mid_upload') === 1): ?> checked <?php endif; ?> />
                                                <label for="mid_upload" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Activate Exam upload</h5>
                                            <div>
                                                <input type="checkbox" id="exam_upload" switch="success" data-field="exam_upload" <?php if(get_settings('exam_upload') === 1): ?> checked <?php endif; ?> />
                                                <label for="exam_upload" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <?php if (\Illuminate\Support\Facades\Blade::check('superadmin')): ?>
                                            <div class="col-sm-4">
                                                <h5 class="font-size-14 mb-3">Application Type</h5>
                                                <div>
                                                    <input type="checkbox" id="result_template" switch="info" data-field="result_template" <?php if(get_settings('result_template') === 1): ?> checked <?php endif; ?> />
                                                    <label for="result_template" data-on-label="Sec" data-off-label="Pri"></label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <h5 class="font-size-14 mb-3">App Debug</h5>
                                                <div>
                                                    <input type="checkbox" id="app_debug" switch="success" data-field="app_debug" <?php if(get_settings('app_debug') === 1): ?> checked <?php endif; ?> />
                                                    <label for="app_debug" data-on-label="True" data-off-label="False"></label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <h5 class="font-size-14 mb-3">App ENV</h5>
                                                <div>
                                                    <input type="checkbox" id="app_env" switch="success" data-field="app_env" <?php if(get_settings('app_env') === 1): ?> checked <?php endif; ?> />
                                                    <label for="app_env" data-on-label="Live" data-off-label="Local"></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Formats moved to the Formats tab -->

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('settings_create')): ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title mt-2 mb-2">General Settings</h1>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.admin.settings', [])->html();
} elseif ($_instance->childHasBeenRendered('n7gR3Lg')) {
    $componentId = $_instance->getRenderedChildComponentId('n7gR3Lg');
    $componentTag = $_instance->getRenderedChildComponentTagName('n7gR3Lg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('n7gR3Lg');
} else {
    $response = \Livewire\Livewire::mount('components.admin.settings', []);
    $html = $response->html();
    $_instance->logRenderedChild('n7gR3Lg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>

            $('#mail-setup').on('submit', function (e) {
               e.preventDefault();
               toggleAble('#mail-btn', true, 'Submitting...');

               var data = $(this).serializeArray();
               var url = $(this).attr('action');

               $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#mail-btn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#guardianUpdate');
                        window.location.reload();
                    }else{
                        toggleAble('#mail-btn', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#mail-btn', false);
                });
            });
            
            function ValidateEmail(inputText) {
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (inputText.match(mailformat)) {
                    return true;
                } else {
                    return false;
                }
            }

            $('.config_form').on('submit', function(e){
                e.preventDefault();
                Swal.fire({
                    title: '<?php echo e(translate('Are you sure?')); ?>?',
                    text: "<?php echo e(translate('a_test_mail_will_be_sent_to_your_email')); ?>!",
                    showCancelButton: true,
                    confirmButtonColor: '#377dff',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '<?php echo e(translate('Yes')); ?>!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "<?php echo e(route('appSetting.mail.send')); ?>",
                            method: 'GET',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function() {
                                toggleAble('#config_test', true, 'Sending...');

                            },
                            success: function(data) {
                                if (data.status) {
                                    toastr.success(
                                        '<?php echo e(translate('email_configured_perfectly!')); ?>!'
                                    );
                                }else {
                                    toastr.info(
                                        '<?php echo e(translate('email_status_is_not_active')); ?>!'
                                    );
                                }
                            },
                            complete: function() {
                                toggleAble('#config_test', false);
                            }
                        });
                    }
                })
            });
        </script>

        <script>
            <?php if(!isset($digital_payment) || $digital_payment['status']==0): ?>
                $('.digital_payment_methods').hide();
            <?php endif; ?>

            $(document).ready(function () {
                $('.digital_payment').on('click', function(){
                    if($(this).val()=='0')
                    {
                        $('.digital_payment_methods').hide();
                    }
                    else
                    {
                        $('.digital_payment_methods').show();
                    }
                })
            });

            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();

                toastr.success("<?php echo e(translate('messages.text_copied')); ?>");
            }

            function copyToColorClipboard(hex) {
                const el = document.createElement('textarea');
                el.value = hex;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                toastr.success("<?php echo e(translate('messages.text_copied')); ?>");
            }

            function copyToGradeClipboard() {
                const el = document.createElement('textarea');
                el.value = 'markfrom:markto:text';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                toastr.success("<?php echo e(translate('messages.text_copied')); ?>");
            }

        </script>

        <script>
            function maintenance_mode() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Be careful before you turn on/off maintenance mode',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#377dff',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                    $.get({
                        url: '<?php echo e(route('appSetting.maintenance-mode')); ?>',
                        contentType: false,
                        processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        toastr.success(data.message);
                    },
                    complete: function () {
                        $('#loading').hide();
                        },
                        });
                    } else {
                        location.reload();
                    }
                })
            };

            function readURL(input, viewer) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + viewer).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#customFileEg1").change(function() {
                readURL(this, 'viewer');
            });

            $("#favIconUpload").change(function() {
                readURL(this, 'iconViewer');
            });
        </script>

        <script>
            const inputFields = document.querySelectorAll('[data-field]');

            inputFields.forEach(inputField => {
                inputField.addEventListener('change', function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    const field = this.dataset.field;
                    const value = this.checked ? 1 : 0;

                    const formData = new FormData();
                    formData.append(field, value);

                    $.ajax({
                        method: 'POST',
                        url: '/appSetting/update-notification',
                        data: formData, // use "data" instead of "body"
                        processData: false,
                        contentType: false
                    }).then(response => {
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000)
                    }).catch(error => {
                        toastr.error('There was a problem with the fetch operation:', error);
                    });
                });
            });
        </script>

        <script type="text/javascript">
            function copyDataFormat() {
                var format = 'code:name:mark,code:name:mark,code:name:mark,code:name:mark';
                var tempInput = document.createElement('textarea');
                tempInput.value = format;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                toastr.success('Copied!');
            }

            function copyColorFormat() {
                var format = 'markfrom:markto:color';
                var tempInput = document.createElement('textarea');
                tempInput.value = format;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                toastr.success('Copied!');
            }

            var i = 0;
            $("#add").click(function(){
                ++i;
                $("#settingTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
            });
        
            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
            });

            $('#settingForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#settingForm')[0]);
                toggleAble('#settingBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/mark/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#settingBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    console.log(error);
                    toggleAble('#settingBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });

            $('#colorForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#colorForm')[0]);
                toggleAble('#colorBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/color/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#colorBtn', false);
                    toastr.success(response.message);
                    // regenerate theme.css so the new colors are written to public/css/theme.css
                    $.ajax({
                        url: '<?php echo e(route('admin.theme.regenerate')); ?>',
                        method: 'POST',
                        data: {},
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    }).done(function(res){
                        toastr.success(res.message || 'Theme regenerated');
                        setTimeout(() =>{ window.location.reload(); }, 800);
                    }).fail(function(err){
                        // non-fatal: notify user but still reload so inline CSS vars pick up
                        toastr.warning('Theme regenerate failed: '+ (err.responseJSON?.message || '')); 
                        setTimeout(() =>{ window.location.reload(); }, 800);
                    });
                }).catch((error) => {
                    toggleAble('#colorBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });

            $('#gradeForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#gradeForm')[0]);
                toggleAble('#gradeBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/grade/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#gradeBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    toggleAble('#gradeBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });
        </script>

        <script>
             var i = 0;
                $("#addColor").click(function(){
                    ++i;
                    $("#colorTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
                });
            
                $(document).on('click', '.remove-tr', function(){  
                    $(this).parents('tr').remove();
                });
        </script>

        <script>
            var i = 0;
            $("#addGrade").click(function(){
                ++i;
                $("#gradeTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
            });
        
            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
            });
        </script>

        <script>
            var i = 0;
            $("#addAffective").click(function(){
                ++i;
                $("#affectiveTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter domain" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="eg. hand-writing" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
            });
        
            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
            });

            $('#affectiveForm').on('submit' , function(e){
                e.preventDefault();
                var data = $(this).serializeArray();
                toggleAble('#affectiveBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/affective/domain",
                    method: 'post',
                    data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#affectiveBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    toggleAble('#affectiveBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\manager\application\index.blade.php ENDPATH**/ ?>