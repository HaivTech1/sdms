You have been invited to join team <?php echo e($team->name); ?>.<br>
Click here to join: <a
    href="<?php echo e(route('teams.accept_invite', $invite->accept_token)); ?>"><?php echo e(route('teams.accept_invite', $invite->accept_token)); ?></a><?php /**PATH C:\laragon\www\primary\resources\views\teamwork\emails\invite.blade.php ENDPATH**/ ?>