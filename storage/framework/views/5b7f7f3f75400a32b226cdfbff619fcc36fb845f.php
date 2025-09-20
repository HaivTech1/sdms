<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Events"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Event</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Manage Event</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid">
                                <button class="btn font-16 btn-primary" id="btn-new-event"><i
                                        class="mdi mdi-plus-circle-outline"></i> Create
                                    New Event</button>
                            </div>



                            <div id="external-events" class="mt-2">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event fc-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New Event Planning
                                </div>
                                <div class="external-event fc-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                </div>
                                <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating Reports
                                </div>
                                <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create New theme
                                </div>
                            </div>

                            <div class="row justify-content-center mt-5">
                                <img src="assets/images/verification-img.png" alt="" class="img-fluid d-block">
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>

            <div style='clear:both'></div>


            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-3 px-4 border-bottom-0">
                            <h5 class="modal-title" id="modal-title">Event</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>

                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Event Name</label>
                                            <input class="form-control" placeholder="Insert Event Name" type="text"
                                                name="title" id="event-title" required value="" />
                                            <div class="invalid-feedback">Please provide a valid event name</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Duration</label>
                                             <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-m-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                    <input type="text" class="form-control" name="start" placeholder="Start Date" id="event-start" />
                                                    <input type="text" class="form-control" name="end" placeholder="End Date" id="event-end" />
                                            </div>
                                            <div class="invalid-feedback">Please provide a valid event duration</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-control form-select" name="category"
                                                id="event-category">
                                                <option selected> --Select-- </option>
                                                <option value="bg-danger">Danger</option>
                                                <option value="bg-success">Success</option>
                                                <option value="bg-primary">Primary</option>
                                                <option value="bg-info">Info</option>
                                                <option value="bg-dark">Dark</option>
                                                <option value="bg-warning">Warning</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid event category</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Period</label>
                                            <select class="form-control form-select" name="period_id"
                                                id="event-period">
                                                <option selected> --Select-- </option>
                                                <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Term</label>
                                            <select class="form-control form-select" name="term_id"
                                                id="event-term">
                                                <option selected> --Select-- </option>
                                                <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger"
                                            id="btn-delete-event">Delete</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1"
                                            data-bs-dismiss="modal">Close</button>
                                        <button id="modal-submit" type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->

        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            !(function (g) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            "use strict";
            function e() {}
            (e.prototype.init = function () {
                var l = g("#event-modal"),
                    t = g("#modal-title"),
                    b = g("#modal-submit"),
                    a = g("#form-event"),
                    i = null,
                    r = null,
                    s = document.getElementsByClassName("needs-validation"),
                    i = null,
                    r = null,
                    e = new Date(),
                    n = e.getDate(),
                    d = e.getMonth(),
                    o = e.getFullYear();

                new FullCalendarInteraction.Draggable(
                    document.getElementById("external-events"),
                    {
                        itemSelector: ".external-event",
                        eventData: function (e) {
                            return {
                                title: e.innerText,
                                className: g(e).data("class"),
                            };
                        },
                    }
                );

                var c = <?php echo json_encode($events, 15, 512) ?>,
                v = (document.getElementById("external-events"), document.getElementById("calendar"));

                function u(e) {
                    l.modal("show"),
                        a.removeClass("was-validated"),
                        a[0].reset(),
                        g("#event-title").val(),
                        g("#event-category").val(),
                        g("#event-period").val(),
                        g("#event-term").val(),
                        t.text("Add Event"),
                        (r = e);
                }
                var m = new FullCalendar.Calendar(v, {
                    plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                    editable: !0,
                    droppable: !0,
                    selectable: !0,
                    defaultView: "dayGridMonth",
                    themeSystem: "bootstrap",
                    header: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
                    },
                    eventClick: function (e) {
                        l.modal("show"),
                             a[0].reset(),
                            (i = e.event),
                            g("#event-title").val(i.title),
                            g("#event-category").val(i.classNames[0]),
                            g("#event-period").val(i.classNames[0]),
                            g("#event-term").val(i.classNames[0]),
                            (r = null),
                            t.text("Edit Event"),
                            b.text("Update"),
                            (r = null);

                        var title = g("#event-title").val();
                        var category = g("#event-category").val();
                        var start = g("#event-start").val();
                        var end = g("#event-end").val();

                        var start_date = moment(start).format('YYYY-MM-DD');
                        var end_date = moment(end).format('YYYY-MM-DD');
                        var id = i._def.groupId;

                        
                    },
                    dateClick: function (e) {
                        u(e);
                    },
                    events: c,
                });
                m.render(),

                g(a).on("submit", function (e) {
                    e.preventDefault();
                    g("#form-event :input");
                    var t,
                        a = g("#event-title").val(),
                        n = g("#event-category").val();
                        period = g("#event-period").val();
                        term = g("#event-term").val();
                        var start = g("#event-start").val();
                        var end = g("#event-end").val();

                        var start_date = moment(start).format('YYYY-MM-DD');
                        var end_date = moment(end).format('YYYY-MM-DD');

                    !1 === s[0].checkValidity()
                    ? (event.preventDefault(),
                      event.stopPropagation(),
                      s[0].classList.add("was-validated")
                    ):(
                        $.ajax({
                            url:"<?php echo e(route('event.store')); ?>",
                            type:"POST",
                            dataType:'json',
                            data:{ title: a, start_date, end_date, period, term, n  },
                            success:function(response)
                            {          
                                if(response.status === 'success') {
                                    toastr.success(response.message, 'Success!');
                                    i ? (i.setProp("title", a), i.setProp("classNames", [n]))
                                    : ((t = { title: response.data.title, start: response.data.start, allDay: r.allDay, className: response.data.category}),
                                    m.addEvent(t), l.modal("hide"), window.reload())
                                }else{
                                    toastr.error(response.message, 'Failed!');
                                    l.modal("hide");
                                }                 
                            },
                            error:function(error)
                            {
                                if(error.responseJSON.errors) {
                                    $('#invalid-feedback').html(error.responseJSON.errors.title);
                                }
                            },
                        })
                    );
                }),

                g("#btn-delete-event").on("click", function (e) {
                         if(confirm(`Are you sure want to remove ${i._def.title}`)){
                            var id = i._def.groupId;
                            $.ajax({
                                url:"<?php echo e(route('event.destroy', '')); ?>" +'/'+ id,
                                type:"DELETE",
                                dataType:'json',
                                success:function(response)
                                {
                                    if(response.status === 'success') {
                                        toastr.success(response.message, 'Success!');
                                        i.remove(), (i = null), 
                                        l.modal("hide")
                                    }else{
                                        toastr.error(response.message, 'Failed!');
                                    }
                                },
                                error:function(error)
                                {
                                    console.log(error);
                                        toastr.error(error, 'Failed!');
                                },
                            });
                         }                    
                }),

                g("#btn-new-event").on("click", function (e) {
                    u({ date: new Date(), allDay: !0 });
                });
            }),

            (g.CalendarPage = new e()),
            (g.CalendarPage.Constructor = e);

        })(window.jQuery),
            (function () {
                "use strict";
                window.jQuery.CalendarPage.init();
        })();

        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\event\index.blade.php ENDPATH**/ ?>