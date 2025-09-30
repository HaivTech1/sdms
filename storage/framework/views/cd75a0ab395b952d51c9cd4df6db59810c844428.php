<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo e(url('/')); ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
                            height="100" style="border-radius: 100%;">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
                            height="100">
                    </span>
                </a>

                <a href="<?php echo e(url('/')); ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
                            height="120px" width="120px">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
                            height="120px" width="120px">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            

            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.student.cart-counter', [])->html();
} elseif ($_instance->childHasBeenRendered('gti56tm')) {
    $componentId = $_instance->getRenderedChildComponentId('gti56tm');
    $componentTag = $_instance->getRenderedChildComponentTagName('gti56tm');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('gti56tm');
} else {
    $response = \Livewire\Livewire::mount('components.student.cart-counter', []);
    $html = $response->html();
    $_instance->logRenderedChild('gti56tm', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            <div class="dropdown d-inline-block">
                <?php if(Laravel\Jetstream\Jetstream::managesProfilePhotos()): ?>
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-user"></i>
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo e(Auth::user()->name); ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <?php endif; ?>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i> 
                        <span key="t-profile">Profile</span>
                    </a>

                    <?php if (\Illuminate\Support\Facades\Blade::check('student')): ?>
                        <a class="dropdown-item" href="<?php echo e(route('student.parentDetails')); ?>">
                            <i class="bx bx-user font-size-16 align-middle me-1"></i> 
                            <span key="t-profile">Parent Details</span>
                        </a>
                    <?php endif; ?>

                    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                        <a class="dropdown-item d-block" href="#">
                            <i class="bx bx-wrench font-size-16 align-middle me-1"></i> 
                            <span key="t-settings">Settings</span>
                        </a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault(); this.closest('form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                key="t-logout">Logout</span></a>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bxs-crown"></i>
                </button>


                <?php if(Laravel\Jetstream\Jetstream::hasTeamFeatures()): ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> <?php echo e(Auth::user()->currentTeam->name); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', Laravel\Jetstream\Jetstream::newTeamModel())): ?>
                        <a href="<?php echo e(route('teams.create')); ?>" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-dialpad"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-your-order"><?php echo e(__('Create New Team')); ?></h6>

                                </div>
                            </div>
                        </a>
                        <?php endif; ?>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            <?php echo e(__('Switch Teams')); ?>

                        </div>

                        <?php $__currentLoopData = Auth::user()->allTeams(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form method="POST" action="<?php echo e(route('current-team.update')); ?>" x-data>
                            <?php echo method_field('PUT'); ?>
                            <?php echo csrf_field(); ?>

                            <!-- Hidden Team ID -->
                            <input type="hidden" name="team_id" value="<?php echo e($team->id); ?>">
                            <div class="text-reset notification-item">
                                <div href=" #" x-on:click.prevent="$root.submit();">
                                    <?php if(Auth::user()->isCurrentTeam($team)): ?>
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" key="t-your-order"><?php echo e($team->name); ?></h6>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header><?php /**PATH C:\laragon\www\primary\resources\views/partials/header.blade.php ENDPATH**/ ?>