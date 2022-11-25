<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Add Property Category</h5>

        <form wire:submit.prevent="createCategory">
            <div class="hstack gap-3">
                <input class="form-control me-auto" wire:model.defer="name" placeholder="Add your item here..."
                    aria-label="Add your item here...">
                <x-form.error for="name" />
                <button type="submit" class="btn btn-secondary">Submit</button>
                <div class="vr"></div>
                <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
            </div>
        </form>

    </div>
</div>