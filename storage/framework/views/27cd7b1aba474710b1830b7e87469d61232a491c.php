<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Mid Term Result Page"); ?>

    <?php $__env->startSection('styles'); ?>
        <style>
            .mainContainer {
                width: 60%;
            }
            .minorContainer{
                width: 30%
            }
            .majorContainer{
                display: flex; 
                flex-wrap: wrap;
                justify-content: space-between; 
                margin-top: 1px
            }
            .appName{
                font-size: 35px; 
                font-weight: bold; 
                text-transform : uppercase
            }

            
            @media  screen and (max-width: 480px) {
                .mainContainer{
                    width: 100%;
                }
                .minorContainer{
                    width: 100%;
                }
                .majorContainer{
                    margin-top: 5px;
                    flex-direction: column;
                }
                .appName{
                    font-size: 15px;
                    margin: 10px;
                }
            }

            .rotate-header {
                transform: rotate(-180deg);
                writing-mode: vertical-lr;
                white-space: nowrap;
                font-size: 10px;
                font-weight: bold;
                text-align: left;
                vertical-align: middle;
                width: 5%; 
                font-weight: 900;
            }
        </style>
    <?php $__env->stopSection(); ?>

    <div class="row" id="resultPrintMargin">
        <div class="col-lg-12">
            <div class='parent'>
                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                    <img class='img-rounded img-responsive' src='<?php echo e(asset('storage/'.application('image'))); ?>' alt='<?php echo e(application(' name')); ?>' />
                </div>

                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                    <h1 class="appName"> <?php echo e(application('name')); ?></h1>
                        <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                            <?php echo e(application('address')); ?>

                        </p>
                </div>

                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                    <img src='<?php echo e(asset('storage/'.$student->user->image())); ?>' class='img-rounded img-responsive' alt='<?php echo e($student->firstName()); ?>' />
                </div>
            </div>

            <div style="margin-bottom: 10px">
                <p style="font-weight: bold; text-align: center; text-transform : uppercase">Mid-Term Evaluation Report Sheet</p>
                <p style="font-weight: bold; text-align: center; text-transform : uppercase"><?php echo e($term->title()); ?> <?php echo e($period->title()); ?> Academic Session</p>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Surname</th>
                                <td><?php echo e(ucfirst($student->lastName())); ?></td>
                                <th>Other Names:</th>
                                <td><?php echo e(ucfirst($student->firstName())); ?> <?php echo e(ucfirst($student->otherName())); ?></td>
                            </tr>
                            <tr>
                                <th>Class:</th>
                                <td><?php echo e($student->grade->title()); ?></td>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th>House:</th>
                                <td><?php echo e(ucfirst($student->house?->title())); ?> </td>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="minorContainer">
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <th>Sex</th>
                                <td><?php echo e(ucfirst($student->gender())); ?></td>
                            </tr>
                            <tr>
                                <th>No. In Class:</th>
                                <td><?php echo e($student->grade->students->count()); ?></td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td>
                                    <?php
                                        $year = Carbon\Carbon::parse($student->dob())->age
                                    ?>
                                    <?php echo e($year); ?>

                                </td>
                            </tr>
                            <tr>
                                <th>Admission No.</th>
                                <td><?php echo e($student->user->code()); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-wrapper table-responsive">
                <table class="table table-bordered table-condensed">
                    <?php
                        $midterm = get_settings('midterm_format');
                    ?>
                    <?php if($midterm !== null): ?>
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                            </tr>
                            
                            <tr>
                                <th rowspan="3" style="width: 30%; padding-left: 10px">Subjects</th>
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header">Total</th>
                                <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header">Percentage</th>
                            </tr>
                        </thead>
                        <tbody style="">

                                <?php
                                    $totalSum = 0;
                                ?>
                                <tr style="text-align: center; color: green;">
                                    <td></td>
                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">
                                            <?php echo e($value['mark']); ?>

                                            <?php
                                                $totalSum += $value['mark'];
                                            ?>
                                        </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center"><?php echo e($totalSum); ?></td>
                                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100%</td>
                                </tr>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if($result->subject->title() != null): ?>
                                        <td style="padding-left: 10px"><?php echo e($result->subject->title()); ?></td>
                                    <?php endif; ?>
                                   <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <td style="font-size: 10px; font-weight: 400; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e($result->total()); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(round(divnum($result->total() * 100, $totalSum))); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    <?php endif; ?>
                </table>
            </div>

            <div style="margin: 0 10px">
                <span style="font-weight: bold; font-size: 15px">Comment: </span><span><?php echo e($comment); ?></span>
            </div>

            
        
        </div>
    </div>

    <div class="row">
        <div class="d-print-none">
            <div class="float-end">
                
                <a href="javascript:window.print()"
                    class="btn btn-success waves-effect waves-light me-1"><i
                        class="fa fa-print"></i>
                </a>
                <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                    <button class="btn btn-sm btn-primary w-md waves-effect waves-light" type="button" id='cummulative' onClick="publish('<?php echo e($student->id()); ?>, <?php echo e($period->id()); ?>, <?php echo e($term->id()); ?>, <?php echo e($student ->grade->id()); ?>')">
                        <i class="mdi mdi-upload d-block font-size-16"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            function generatePDF() {
                toggleAble('#downloadPdf', true);
                const style = document.createElement('style');
                style.innerHTML = 'td, th { line-height: 2; padding: 5px}';
                document.head.appendChild(style);
                const container = document.getElementById("resultPrintMargin");

                html2canvas(container, {
                    scale: 2,
                    allowTaint: false,
                    }).then(function(canvas) {
                    const imgData = canvas.toDataURL("image/png");

                    const pdfDocDefinition = {
                        pageSize: 'A4',
                        watermark: {text: ''+<?php echo json_encode(application('name'), 15, 512) ?>, color: 'gray', opacity: 0.1, bold: true, fontSize: 30,},
                        pageOrientation: 'portrait',
                        content: [
                            {
                                image: imgData,
                                width: 500,
                                height: 500
                            }
                        ],
                        styles: {
                            header: {
                                fontSize: 18,
                                bold: false,
                                margin: [0, 0, 0, 0]
                            },
                            body: {
                                fontSize: 12,
                                margin: [0, 0, 0, 0]
                            }
                        }
                    };

                    pdfMake.createPdf(pdfDocDefinition).open();
                });
                document.head.removeChild(style);
                toggleAble('#downloadPdf', false);
            }

            function publish(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];
                toggleAble('#cummulative', true);

                $.ajax({
                    url: '<?php echo e(route('result.midterm.publish')); ?>' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#cummulative', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative', false);
                            toastr.error(res.message, 'Success!');
                        }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative', false);
                });              
            }
        </script>
    <?php $__env->stopSection(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/midterm_show.blade.php ENDPATH**/ ?>