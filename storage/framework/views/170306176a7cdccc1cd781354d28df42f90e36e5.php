<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="<?php echo e(route('dashboard')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-wrench"></i>
                            <span key="t-ecommerce">Site Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                                <li><a href="<?php echo e(route('user.index')); ?>" key="t-products">Users</a></li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                                <li><a href="<?php echo e(route('permission.index')); ?>" key="t-products">Permissions</a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                                <li><a href="<?php echo e(route('role.index')); ?>" key="t-products">Roles</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('scratchcard_access')): ?>
                    <!-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-devices"></i>
                            <span key="t-ecommerce">Scratch Card</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="<?php echo e(route('user.generatePin')); ?>" key="t-products">Generate Pins</a>
                            </li>
                            <li><a href="<?php echo e(route('user.pins')); ?>" key="t-products">Print Pins</a></li>
                        </ul>
                    </li>  -->
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-command"></i>
                        <span key="t-ecommerce">Settings Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
                            <li><a href="<?php echo e(route('setting.index')); ?>" key="t-products">Setting</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(route('period.index')); ?>" key="t-products">Session</a></li>
                        <li><a href="<?php echo e(route('term.index')); ?>" key="t-products">Term</a></li>
                        <li><a href="<?php echo e(route('house.index')); ?>" key="t-products">House</a></li>
                        <li><a href="<?php echo e(route('club.index')); ?>" key="t-products">Club</a></li>
                        <li><a href="<?php echo e(route('grade.index')); ?>" key="t-products">Class</a></li>
                        
                        <li><a href="<?php echo e(route('subject.index')); ?>" key="t-products">Subjects</a></li>
                        <li><a href="<?php echo e(route('schedule.index')); ?>" key="t-products">Schedule</a></li>
                        <li><a href="<?php echo e(route('admin.hairstyle.index')); ?>" key="t-products">Hairstyles</a></li>
                        <li><a href="<?php echo e(route('admin.week.index')); ?>" key="t-products">Weeks</a></li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fingerprint_access')): ?>
                            <!-- <li><a href="<?php echo e(route('finger_device.index')); ?>" key="t-products">Biometric Device</a></li> -->
                        <?php endif; ?>
                        <li><a href="<?php echo e(route('admin.period.setting')); ?>" key="t-products">Session Settings</a></li>
                    </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('website_access')): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-command"></i>
                        <span key="t-ecommerce">Website Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('design.index')); ?>" key="t-products">School Homepage</a></li>
                        <li><a href="<?php echo e(route('admin.about.index')); ?>" key="t-products">Website Design</a></li>
                        <li><a href="<?php echo e(route('admin.gallery.index')); ?>" key="t-products">School Gallery</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_access')): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-command"></i>
                        <span key="t-ecommerce">Staff Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('teacher.index')); ?>" key="t-products">Teachers</a></li>
                        <li><a href="<?php echo e(route('staff.index')); ?>" key="t-products">Staffs</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('registration_access')): ?>
                <li>
                    <a href="<?php echo e(url('index/registration')); ?>" class="waves-effect">
                        <i class="bx bx-folder"></i>
                        <span key="t-chat">Registrations</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_access')): ?>
                <li>
                    <a href="<?php echo e(route('student.index')); ?>" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-chat">Students</span>
                    </a>
                </li> 
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('promotion_access')): ?>
                <li>
                    <a href="<?php echo e(route('student.batch.promotion')); ?>" class="waves-effect">
                        <i class="bx bx-transfer"></i>
                        <span key="t-chat">Promotion</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('certificate_access')): ?>
                <li>
                    <a href="<?php echo e(route('user.certificate')); ?>" class="waves-effect">
                        <i class="bx bx-paperclip"></i>
                        <span key="t-chat">Certificate</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('messaging_access')): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-chat"></i>
                        <span key="t-ecommerce">Messaging</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('messaging.email')); ?>" key="t-add-product">Email</a></li>
                        <li><a href="<?php echo e(route('messaging.sms')); ?>" key="t-add-product">Bulk SMS</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_access')): ?>
                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-car"></i>
                        <span key="t-ecommerce">Transport Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('vehicle.index')); ?>" key="t-products">Vehicle</a></li>
                        <li><a href="<?php echo e(route('driver.index')); ?>" key="t-add-product">Drivers</a></li>
                        <li><a href="<?php echo e(route('trip.index')); ?>" key="t-add-product">Trips</a></li>
                    </ul>
                </li> -->
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ecommerce_access')): ?>
                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store-alt"></i>
                        <span key="t-ecommerce">Ecommerce Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('product.index')); ?>" key="t-add-product">Products</a></li>
                        <li><a href="<?php echo e(route('order.index')); ?>" key="t-add-product">Orders</a></li>
                    </ul>
                </li> -->
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_access')): ?>
                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxl-whatsapp"></i>
                        <span key="t-ecommerce">Bot Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.whatsapp.messages')); ?>" key="t-add-product">Sent Messages</a></li>
                        <li><a href="<?php echo e(route('admin.whatsapp.contacts')); ?>" key="t-add-product">Contacts</a></li>
                    </ul>
                </li> -->
            <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result_access')): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-folder-open"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result_create')): ?>
                                <li><a href="<?php echo e(route('result.batch.midterm.upload')); ?>" key="t-products">Subject Mid-term Upload </a></li>
                                <li><a href="<?php echo e(route('result.create')); ?>" key="t-products">Subject Exam Upload</a></li>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('playgroup_result_access')): ?>
                                    <li><a href="<?php echo e(route('result.playgroup.upload')); ?>" key="t-products">Playgroup Result Upload </a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo e(route('result.midterm.upload')); ?>" key="t-products">Student Mid-term Upload </a></li>
                                <li><a href="<?php echo e(route('result.singleUpload')); ?>" key="t-products">Student Exam Upload</a></li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('broadsheet_access')): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Broadsheet</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="<?php echo e(route('result.subject.broadsheet')); ?>">View Subject</a></li>
                                        <li><a href="<?php echo e(route('result.class.broadsheet')); ?>">View Class</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class_setting')): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Result CAS</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="<?php echo e(route('result.cas.comment')); ?>">Comment</a></li>
                                        <li><a href="<?php echo e(route('result.cas.affective')); ?>">Affective</a></li>
                                        <li><a href="<?php echo e(route('result.cas.psychomotor')); ?>">Psychomotor</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('statistic_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('result.statistic.show')); ?>" key="t-products">
                                        Score Statistics
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result_show')): ?>
                                <li>
                                    <a href="<?php echo e(route('result.view.results')); ?>" key="t-products">
                                        View Results
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(route('result.midterm')); ?>" key="t-products">Check Mid-term Scores</a></li>
                            <li><a href="<?php echo e(route('result.primary')); ?>" key="t-products">Check Exam Scores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php echo $__env->make('partials.nav.bursal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('partials.nav.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_fee_access')): ?>
                    <li>
                        <a href="<?php echo e(route('student.fees')); ?>" class="waves-effect">
                            <i class="bx bx-credit-card"></i>
                            <span key="t-chat">Fee</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_result_access')): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span key="t-ecommerce">Result</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_midterm_access')): ?>
                                <li><a href="<?php echo e(route('result.midtermIndex')); ?>" key="t-products">Mid-Term Result</a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_exam_access')): ?>
                                <li><a href="<?php echo e(route('result.index')); ?>" key="t-products">Exam Result</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_assignment_access')): ?>
                    <li>
                        <a href="<?php echo e(route('assignment.get')); ?>" class="waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span key="t-chat">Assignment</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_lesson_access')): ?>
                    <li>
                        <a href="<?php echo e(route('lesson.index')); ?>" class="waves-effect">
                            <i class="bx bx-video"></i>
                            <span key="t-chat">Visual Class</span>
                        </a>
                    </li>
                <?php endif; ?>

            
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_market_access')): ?>
                    <li>
                        <a class="waves-effect" href="<?php echo e(route('user.product.index')); ?>">
                            <i class="bx bx-store-alt"></i> 
                            <span key="t-chat">Market</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('timetable_access')): ?>
                    <li>
                        <a href="<?php echo e(route('timetable.index')); ?>" class="waves-effect">
                            <i class="mdi mdi-clock-outline"></i>
                            <span key="t-chat">Timetable</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('calendar_access')): ?>
                    <li>
                        <a class="waves-effect" href="<?php echo e(route('calendar.index')); ?>">
                            <i class="bx bx-calendar"></i> 
                            <span key="t-chat">School Calender</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('schoolbus_access')): ?>
                    <!-- <li>
                        <a class="waves-effect" href="<?php echo e(route('user.schoolbus.index')); ?>">
                            <i class="bx bx-car"></i> 
                            <span key="t-chat">School Bus</span>
                        </a>
                    </li> -->
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views\partials\sidenav.blade.php ENDPATH**/ ?>