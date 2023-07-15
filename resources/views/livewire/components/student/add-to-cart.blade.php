<div>
     <x-loading />
    <div class="text-center">
        <button type="button" wire:click='addToCart({{ $product->id() }})' class="btn btn-primary waves-effect  mt-2 waves-light">
            <i class="bx bx-shopping-bag me-2"></i>Add to cart
        </button>
    </div>
</div>
