<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateProduct implements ShouldQueue
{
    use Dispatchable;
    
    private $author;
    private $title;
    private $price;
    private $quantity;
    private $discount;
    private $brand;
    private $image;
    private $description;
    private $category;
    
    public function __construct(
        User $author,
        string $title,
        string $price,
        int $quantity,
        ?string $discount,
        string $brand,
        ?array $image = [],
        string $description,
        string $category
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->discount = $discount;
        $this->brand = $brand;
        $this->image = $image;
        $this->description = $description;
        $this->category = $category;
    }

    public static function fromRequest(ProductRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->price(),
            $request->quantity(),
            $request->discount(),
            $request->brand(),
            $request->image(),
            $request->description(),
            $request->category(),
        );
    }
    
    public function handle(): Product
    {
        $product = new Product([
            'title'                 => $this->title,
            'price'                 => $this->price,
            'quantity'              => $this->quantity,
            'discount'              => $this->discount,
            'brand'                 => $this->brand,
            'description'           => $this->description,
            'product_category_id'  => $this->category,
        ]);

        $product->authoredBy($this->author);


        if($this->image)
        {
            foreach($this->image as $file)
            {
                $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                $path = storage_path('app/public/products/') ;
                $file->move($path, $name);
                $Imgdata[] = $name;
            }
        }
        else
        {
            $Imgdata = 'noimg';
        }

        $product->image = json_encode($Imgdata);

        $product->save();

        return $product;
    }
}