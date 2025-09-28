<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title ?? 'Question Paper'); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3, h4 { margin: 4px 0; padding: 0; }
        .meta { font-size: 12px; margin-bottom: 8px; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f4f4f4; }
        .q { margin: 10px 0 6px; }
        .opts { margin: 0 0 10px 0; padding-left: 12px; }
        .opt { margin: 2px 0; }
        .watermark { position: fixed; top: 200px; left: 0; right: 0; text-align: center; opacity: 0.08; z-index: 0; }
        .header { position: relative; z-index: 1; margin-bottom: 8px; }
        .hr { border-top: 1px dashed #ccc; margin: 8px 0; }
    </style>
    
</head>
<body>
    
    <div class="watermark">
        <?php if(!empty($school['logo'])): ?>
            <img src="<?php echo e($school['logo']); ?>" alt="logo" style="width: 300px; height: auto; display: inline-block;" />
        <?php endif; ?>
    </div>

    
    <div class="header">
        <table style="width:100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    <?php if(!empty($school['logo'])): ?>
                        <img src="<?php echo e($school['logo']); ?>" alt="<?php echo e($school['name'] ?? ''); ?>" style="max-width: 80px; height: auto;" />
                    <?php endif; ?>
                </td>
                <td style="width:70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:18px; font-weight:700; text-transform:uppercase"><?php echo e($school['name'] ?? ''); ?></div>
                    <?php if(!empty($school['address'])): ?>
                        <div style="font-size:12px"><?php echo e($school['address']); ?></div>
                    <?php endif; ?>
                </td>
                <td style="width:15%; vertical-align: middle; text-align: right; border: none; padding: 0;"></td>
            </tr>
        </table>
    </div>

    <h2 style="text-align:center;"><?php echo e($title ?? 'Question Paper'); ?></h2>
    <div class="meta" style="text-align:center;">
        <span>Grade: <strong><?php echo e($meta['grade'] ?? '-'); ?></strong></span>
        &nbsp;|&nbsp;
        <span>Subject: <strong><?php echo e($meta['subject'] ?? '-'); ?></strong></span>
        &nbsp;|&nbsp;
        <span>Term: <strong><?php echo e($meta['term'] ?? '-'); ?></strong></span>
        &nbsp;|&nbsp;
        <span>Period: <strong><?php echo e($meta['period'] ?? '-'); ?></strong></span>
    </div>

    <div class="hr"></div>

    
    <table style="width:100%; border-collapse: collapse; border: none; margin-bottom: 10px;">
        <tr>
            <td style="border:none; padding: 4px 0;">Name: _______________________________________</td>
            <td style="border:none; padding: 4px 0;">Reg No: ___________________</td>
        </tr>
        <tr>
            <td style="border:none; padding: 4px 0;">Date: _____________________</td>
        </tr>
    </table>

    
    <div style="margin-bottom: 10px;">
        <strong>Instructions:</strong>
        <ol style="margin: 6px 0 0 18px;">
            <li>Answer all questions.</li>
            <li>Choose the correct option for each question.</li>
            <li>Ensure you write your name and class clearly.</li>
        </ol>
    </div>

    
    <?php
        $letters = ['A','B','C','D','E','F'];
        $chunks = array_chunk($questions, 2);
    ?>

    <?php if(empty($questions)): ?>
        <p>No questions available.</p>
    <?php else: ?>
        <table style="width:100%; border-collapse: collapse; border: none;">
            <?php $__currentLoopData = $chunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ridx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php $__currentLoopData = $pair; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cidx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $globalIndex = ($ridx * 2) + $cidx; ?>
                        <td style="width:50%; vertical-align: top; padding: 6px 10px; border: none;">
                            <div class="q"><strong><?php echo e($globalIndex + 1); ?>.</strong> <?php echo $q['question'] ?? ''; ?></div>

                            <?php if(in_array($mode, ['questions', 'questions_answers'])): ?>
                                <?php if(!empty($q['options']) && is_array($q['options'])): ?>
                                    <div class="opts">
                                        <?php $__currentLoopData = $q['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oi => $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="opt"><?php echo e($letters[$oi] ?? chr(65 + $oi)); ?>. <?php echo is_string($opt) ? $opt : json_encode($opt); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($mode === 'questions_answers'): ?>
                                <div style="margin-bottom: 8px; font-size:11px; color:#222;">
                                    <strong>Answer:</strong>
                                    <?php if(isset($q['correct_answer']) && $q['correct_answer'] !== null): ?>
                                        <?php echo e($q['correct_answer']); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if($mode === 'answers'): ?>
                                <div style="margin-bottom: 8px; font-size:12px;">
                                    <strong><?php echo e($globalIndex + 1); ?>.</strong>
                                    <?php if(isset($q['correct_answer']) && $q['correct_answer'] !== null): ?>
                                        <?php echo e($q['correct_answer']); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(count($pair) === 1): ?>
                        <td style="width:50%; border: none;">&nbsp;</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php endif; ?>

</body>
</html>
<?php /**PATH C:\laragon\www\primary\resources\views/pdfs/question_paper.blade.php ENDPATH**/ ?>