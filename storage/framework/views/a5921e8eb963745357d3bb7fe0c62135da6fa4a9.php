<!DOCTYPE html>
<html>
<head>
    <?php $__env->startSection('title', "Student List"); ?>
    <style>
        #body_content {
            position: relative;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bg_img {
            position: absolute;
            opacity: 0.1;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .header {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .header-item {
            display: table-cell;
            vertical-align: middle;
            text-align: center;    
        }

        .header-item:first-child {
            text-align: left;
            width: 10%
        }

        .header-item:last-child {
            text-align: right;
            width: 10%
        }

        .majorContainer {
            width: 100%;
            margin-bottom: 1em;
        }

        .majorContainer::after {
            content: '';
            display: table;
            clear: both;
            vertical-align: middle;
        }

        .mainContainer {
            float: left;
            width: 40%;
        }

        .minorContainer {
            float: right;
            width: 30%;
        }

        .affectiveContainer {
            float: left;
            width: 45%;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table th,
        .result-table td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .beh-d th, beh-d td{
            padding: 2px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-item {
            font-size: 15px;
        }

        .affect-table {
            width: 100%;
            border-collapse: collapse;
        }

        .affect-table th,
        .affect-table td {
            padding: 2px;
            border: 1px solid #000;
            text-align: center;
        }

        .affect-table th {
            background-color: #f2f2f2;
        }

        .affect-item {
            font-size: 8px;
        }

        .rotate-header {
            transform: rotate(270deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            
            
            vertical-align: middle;
            
            
            transform-origin: bottom right;
            
            text-orientation: mixed;
        }
    </style>
</head>
<body>
    <div id="body_content">
        <?php
            // Prepare logo from application settings as base64 for DomPDF; fallback to asset URL
            $logoData = null;
            $logo = application('image');
            if ($logo) {
                $logoPath = storage_path('app/public/' . $logo);
                if (!file_exists($logoPath)) {
                    $logoPath = public_path('storage/' . $logo);
                }

                if (file_exists($logoPath)) {
                    $type = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION)) ?: 'png';
                    $data = @file_get_contents($logoPath);
                    if ($data !== false) {
                        $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                }
            }

            // Prepare authenticated user's image as base64 if available
            $userLogoData = null;
            $userImage = optional(auth()->user())->image();
            if ($userImage) {
                $uPath = storage_path('app/public/' . $userImage);
                if (!file_exists($uPath)) {
                    $uPath = public_path('storage/' . $userImage);
                }

                if (file_exists($uPath)) {
                    $uType = strtolower(pathinfo($uPath, PATHINFO_EXTENSION)) ?: 'png';
                    $uData = @file_get_contents($uPath);
                    if ($uData !== false) {
                        $userLogoData = 'data:image/' . $uType . ';base64,' . base64_encode($uData);
                    }
                }
            }
        ?>

        <div class="bg_img">
            <img src="<?php echo e($logoData ?? asset('storage/' . application('image'))); ?>" alt="<?php echo e(application('name')); ?>" width="300px">
        </div>

        <div>
            <div class="header">
                <div class="header-item">
                    <img src="<?php echo e($logoData ?? asset('storage/' . application('image'))); ?>" width="70" height="70" alt="Profile Image">
                </div>
                <div class="header-item">
                    <div style="font-weight: bold; text-align: center; text-transform: uppercase"><?php echo e(application('name')); ?></div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('address')); ?>

                    </div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('line1')); ?>, <?php echo e(application('line2')); ?>

                    </div>
                </div>
                 <div class="header-item">
                    <img src="<?php echo e($userLogoData ?? asset('storage/' . optional(auth()->user())->image())); ?>" width="70" height="70" alt="user">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase"><?php echo e($grade->title()); ?> List</div>
            </div>


            <div>
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="text-align: left">Name</th>
                            <th style="text-align: left">ID Number</th>
                            <th style="text-align: left">Created At</th>                
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="padding: 4px; text-align: left">
                                <td style="padding: 3px; text-align: left"><?php echo e($key+1); ?></td>
                                <td style="padding: 3px; text-align: left" data-column="Name"><?php echo e($student->lastName()); ?> <?php echo e($student->firstName()); ?> <?php echo e($student->otherName()); ?></td>
                                <td style="padding: 3px; text-align: left" data-column="Id Number"><?php echo e($student->user->code()); ?></td>
                                <td style="padding: 3px; text-align: left" data-column="Date"><?php echo e($student->created_at->format('F j, Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\primary\resources\views\generate\student_list.blade.php ENDPATH**/ ?>