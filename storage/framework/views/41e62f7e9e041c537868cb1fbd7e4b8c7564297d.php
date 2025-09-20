<div>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-horizontal font-size-18"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <?php if($model->isVerified == false): ?>
            <a class="dropdown-item" wire:click.prevent="accept"><i
                    class="mdi mdi-pencil font-size-16 text-success me-1"></i> Accept</a>
            <?php else: ?>
            <a class="dropdown-item" wire:click.prevent="decline"><i
                    class="mdi mdi-pencil font-size-16 text-danger me-1"></i> Decline</a>

            <?php if($model->isAvailbale == false): ?>
            <a class="dropdown-item" wire:click.prevent="available"><i
                    class="mdi mdi-pencil font-size-16 text-success me-1"></i> Make available</a>
            <?php else: ?>
            <a class="dropdown-item" wire:click.prevent="unavailable"><i
                    class="mdi mdi-pencil font-size-16 text-danger me-1"></i> Make unavailable</a>
            <?php endif; ?>

            <?php endif; ?>
            <a class="dropdown-item" wire:click.prevent="delete"><i
                    class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\general-action.blade.php ENDPATH**/ ?>