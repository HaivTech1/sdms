<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name') . ' | Student Management'); ?>
    
     <?php $__env->slot('header', null, []); ?> 
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 font-size-20 fw-bold text-primary">
                    <i class="bx bx-group me-2"></i>Student Management
                </h4>
                <p class="text-muted mt-1 mb-0">Manage students and streamline daily academic operations</p>
            </div>
            <div class="col-md-6">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

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

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>Students Directory
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-light text-dark fs-6">
                                Total Students: <span id="total-students">0</span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Search and Action Bar -->
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="position-relative">
                                <input type="text" id="search-students" class="form-control"
                                       placeholder="Search students by name or registration number...">
                                <i class="bx bx-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('student.create')); ?>" 
                                   class="btn btn-success btn-rounded waves-effect waves-light">
                                    <i class="mdi mdi-plus me-1"></i> Add Student
                                </a>
                                <button data-bs-toggle="modal" data-bs-target=".generateStudentList" 
                                        class="btn btn-info btn-rounded waves-effect waves-light">
                                    <i class="bx bx-download me-1"></i> Generate List
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Filters -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body py-3">
                                    <div class="row g-3">
                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Gender</label>
                                            <select class="form-select" id="filter-gender">
                                                <option value="all">All Genders</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Grade/Class</label>
                                            <select class="form-select" id="filter-grade">
                                                <option value="all">All Grades</option>
                                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($grade->id); ?>"><?php echo e($grade?->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Sort Direction</label>
                                            <select class="form-select" id="filter-sort-direction">
                                                <option value="desc">Newest First</option>
                                                <option value="asc">Oldest First</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Order By</label>
                                            <select class="form-select" id="filter-order-by">
                                                <option value="created_at">Created Date</option>
                                                <option value="first_name">First Name</option>
                                                <option value="last_name">Last Name</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Status</label>
                                            <select class="form-select" id="filter-status">
                                                <option value="all">All Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>

                                         <div class="col-lg-2 col-md-4 col-sm-6">
                                            <label class="form-label text-muted fw-semibold">Actions</label>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-primary btn-sm flex-fill" id="filters-reset" type="button">
                                                    <i class="bx bx-refresh"></i>
                                                </button>
                                                <button class="btn btn-outline-success btn-sm flex-fill" id="filters-apply" type="button">
                                                    <i class="bx bx-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                    <table class="table table-hover align-middle table-nowrap table-check"
                        id="students-table"
                        data-profile-url-template="<?php echo e(route('student.show', ['student' => '__STUDENT__'])); ?>"
                        data-edit-url-template="<?php echo e(route('student.edit', ['student' => '__STUDENT__'])); ?>"
                        data-passport-upload-url="<?php echo e(url('student/upload/passport')); ?>"
                        data-generate-qr-url-template="<?php echo e(url('student/generate-qrcode/__STUDENT__')); ?>">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="select-all-students">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle">Photo</th>
                                            <th class="align-middle">Full Name</th>
                                            <th class="align-middle">Class</th>
                                            <th class="align-middle">Role</th>
                                            <th class="align-middle">Reg. Number</th>
                                            <th class="align-middle">Subjects</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="students-table-body">
                                        <tr>
                                            <td colspan="10" class="text-center py-5">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="text-muted mt-3 mb-0">Fetching students...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0" id="students-range">Showing 0 to 0 of 0 students</p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-flex justify-content-md-end" id="students-pagination"></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Partials -->
    <?php echo $__env->make('partials.add_subject', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Modals -->
    <?php echo $__env->make('admin.student.modals.passport-upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.student.modals.generate-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.student.modals.edit-playgroup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.student.modals.qr-code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.student.modals.subject-management', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startSection('scripts'); ?>
        <?php echo $__env->make('admin.student.scripts.main-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views/admin/student/index.blade.php ENDPATH**/ ?>