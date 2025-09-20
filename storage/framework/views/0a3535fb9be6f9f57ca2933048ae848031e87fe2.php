 <!doctype html>
 <html>

 <head>
     <meta charset="utf-8">
     <title><?php echo e('Payment Receipt'); ?></title>
     <style>
         body {
             font-family: DejaVu Sans, sans-serif;
             font-size: 12px;
             color: #000;
         }

         table {
             width: 100%;
             border-collapse: collapse;
         }

         th,
         td {
             padding: 6px;
             vertical-align: top;
         }

         th {
             background: #f4f4f4;
             font-weight: 700;
         }

         .muted {
             color: #666;
             font-size: 11px
         }

         .right {
             text-align: right
         }

         .center {
             text-align: center
         }

         .watermark {
             position: fixed;
             top: 180px;
             left: 0;
             right: 0;
             text-align: center;
             opacity: 0.08;
             z-index: 0
         }

         .header-table td {
             vertical-align: middle;
         }

         .note {
             font-size: 10px;
             margin-top: 8px
         }

         @media  print {
             .no-print {
                 display: none !important
             }
         }
     </style>
 </head>

 <body>

    
    <?php
        // attempt to embed the logo as a base64 data URI so DomPDF can render it reliably
        $logoDataUri = null;
        $logoRel = application('image') ?? '';
        if (!empty($logoRel)) {
            $publicPath = public_path('storage/' . $logoRel);
            $storagePath = storage_path('app/' . $logoRel);
            if (file_exists($publicPath)) {
                $mime = @mime_content_type($publicPath) ?: 'image/png';
                $logoDataUri = 'data:'.$mime.';base64,'.base64_encode(file_get_contents($publicPath));
            } elseif (file_exists($storagePath)) {
                $mime = @mime_content_type($storagePath) ?: 'image/png';
                $logoDataUri = 'data:'.$mime.';base64,'.base64_encode(file_get_contents($storagePath));
            }
        }
    ?>
    <div class="watermark">
        <img src="<?php echo e($logoDataUri ?? asset('storage/' . application('image'))); ?>" alt="logo"
            style="width: 300px; height: auto; display: inline-block;" />
    </div>

     
     <div style="position: relative; z-index: 1; margin-bottom: 6px;">
         <table style="width:100%; border-collapse: collapse; border: none;">
             <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    <img src="<?php echo e($logoDataUri ?? asset('storage/' . application('image'))); ?>" alt="<?php echo e(application('name')); ?>"
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
                 <td
                     style="width:15%; vertical-align: middle; text-align: right; border: none; padding: 0; font-size: 11px;">
                     <div>Receipt</div>
                     <div class="muted"><?php echo e($payment->referenceId()); ?></div>
                 </td>
             </tr>
         </table>
     </div>

     <h2 style="margin-bottom:6px">Payment Receipt</h2>

     <table style="margin-bottom:6px; border: 1px solid #eee">
         <tbody>
             <tr>
                 <th style="width:25%">Paid By</th>
                 <td style="width:40%"><?php echo e($payment->paidBy()); ?></td>
                 <th style="width:15%">Trans Id</th>
                 <td style="width:20%"><?php echo e($payment->transactionId()); ?></td>
             </tr>
             <tr>
                 <th>Term / Session</th>
                 <td><?php echo e($payment->term->title() ?? '-'); ?> - <?php echo e($payment->period->title() ?? '-'); ?></td>
                 <th>Paid For</th>
                 <td><?php echo e($payment->category ?? '-'); ?></td>
             </tr>
         </tbody>
     </table>

     <table style="border: 1px solid #ddd; margin-bottom:8px;">
         <thead>
             <tr>
                 <th style="width:40%">Name</th>
                 <th style="width:20%">Class</th>
                 <th style="width:20%">Payable</th>
                 <th style="width:20%">Paid</th>
             </tr>
         </thead>
         <tbody>
             <tr>
                 <td><?php echo e($student?->fullName() ?? '-'); ?></td>
                 <td class="center"><?php echo e($student?->grade?->title() ?? '-'); ?></td>
                 <td class="right"><?php echo e(trans('global.naira')); ?><?php echo e(number_format($payment->payable(), 2)); ?></td>
                 <td class="right"><?php echo e(trans('global.naira')); ?><?php echo e(number_format($payment->amount(), 2)); ?></td>
             </tr>
             <tr>
                 <td colspan="2" class="right">To Balance</td>
                 <td colspan="2" class="right"><?php echo e(trans('global.naira')); ?><?php echo e(number_format($payment->balance(), 2)); ?>

                 </td>
             </tr>
         </tbody>
     </table>

     <?php if($payment->balance() > 0): ?>
     <div class="note">** Please endeavour to pay your balance early. Thank you. **</div>
     <?php endif; ?>

     <div style="margin-top:8px; font-size:11px;">Generated: <?php echo e(\Carbon\Carbon::now()->format('j M Y g:i A')); ?></div>
 </body>

 </html><?php /**PATH C:\laragon\www\primary\resources\views\student\receipt.blade.php ENDPATH**/ ?>