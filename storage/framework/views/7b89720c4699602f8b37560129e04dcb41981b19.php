<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <Title>Subject list</Title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        tr:nth-of-type(odd) {
            background: #eee;
        }
    </style>
</head>

<body>
    
    <?php
        // primary color
        $primary = get_settings('primary_color') ?? '#502179';

        // Prepare logo as base64 data URI for DomPDF. Fall back to asset URL if file not accessible.
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
    ?>

    <div style="position: fixed; top: 200px; left: 0; right: 0; text-align: center; opacity: 0.08; z-index: 0;">
        <img src="<?php echo e($logoData ?? asset('storage/' . application('image'))); ?>" alt="logo"
            style="width: 300px; height: auto; display: inline-block;" />
    </div>

    
    <div style="position: relative; z-index: 1; margin-bottom: 8px; width:95%; margin-left:auto; margin-right:auto">
        <table style="width:100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    <img src="<?php echo e($logoData ?? asset('storage/' . application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
                        style="max-width: 80px; height: auto;" />
                </td>
                <td style="width:70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:18px; font-weight:700; text-transform:uppercase">
                        <?php echo e(application('name')); ?></div>
                    <div style="font-size:12px"><?php echo e(application('address')); ?></div>
                    <?php if(application('local')): ?>
                    <div style="font-size:11px"><?php echo e(application('local')); ?></div>
                    <?php endif; ?>
                </td>
                <td style="width:15%; vertical-align: middle; text-align: right; border: none; padding: 0;">
                    
                </td>
            </tr>
        </table>
    </div>

    <h2 style="margin: 0 auto; text-align: center">School Subject list</h2>

    <?php $primary = get_settings('primary_color') ?? '#502179'; ?>

    <table style="position: relative; top: 4px">
        <thead>
            <tr>
                <th style="background: <?php echo $primary; ?>; color: #fff; font-weight: bold; text-align: left; font-size:18px;">#</th>
                <th style="background: <?php echo $primary; ?>; color: #fff; font-weight: bold; text-align: left; font-size:18px;">Name</th>
                <th style="background: <?php echo $primary; ?>; color: #fff; font-weight: bold; text-align: left; font-size:18px;">ID Number</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="padding: 3px">
                <td style="padding: 3px"><?php echo e($key+1); ?></td>
                <td style="padding: 3px" data-column="Name"><?php echo e($subject->title()); ?></td>
                <td style="padding: 3px" data-column="Last Name"><?php echo e($subject->id); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>

</html>
<?php /**PATH C:\laragon\www\primary\resources\views\generate\subject_list.blade.php ENDPATH**/ ?>