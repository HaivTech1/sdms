<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title ?? 'Attendance Export'); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    
    <div style="position: fixed; top: 200px; left: 0; right: 0; text-align: center; opacity: 0.08; z-index: 0;">
        <img src="<?php echo e(asset('storage/' . application('image'))); ?>" alt="logo" style="width: 300px; height: auto; display: inline-block;" />
    </div>

    
    <div style="position: relative; z-index: 1; margin-bottom: 8px;">
        <table style="width:100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    <img src="<?php echo e(asset('storage/' . application('image'))); ?>" alt="<?php echo e(application('name')); ?>" style="max-width: 80px; height: auto;" />
                </td>
                <td style="width:70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:18px; font-weight:700; text-transform:uppercase"><?php echo e(application('name')); ?></div>
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
    <h2><?php echo e($title ?? 'Attendance Export'); ?></h2>
    <p>Type: <?php echo e(ucfirst($type ?? 'all')); ?></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Reg No</th>
                <th>Grade</th>
                <th>Date</th>
                <th>AM Time</th>
                <th>PM Time</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($r['person']['name'] ?? '-'); ?></td>
                    <td><?php echo e($r['person']['reg_no'] ?? '-'); ?></td>
                        <td><?php echo e($r['person']['grade'] ?? '-'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($r['date'])->format('j M Y')); ?></td>
                        <td>
                            <?php if(!empty($r['am_check_in_at'])): ?>
                                <?php echo e(\Carbon\Carbon::parse($r['am_check_in_at'])->format('g:i A')); ?>

                            <?php else: ?>
                                Absent
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($r['pm_check_out_at'])): ?>
                                <?php echo e(\Carbon\Carbon::parse($r['pm_check_out_at'])->format('g:i A')); ?>

                            <?php else: ?>
                                Absent
                            <?php endif; ?>
                        </td>
                    <td><?php echo e($r['note'] ?? ''); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\primary\resources\views\pdfs\attendance.blade.php ENDPATH**/ ?>