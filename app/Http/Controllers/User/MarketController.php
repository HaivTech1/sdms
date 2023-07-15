<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketController extends Controller
{
   public function __construct()
   {
      $this->middleware(['auth']);
   }


   public function index()
   {
      return view('student.market.index');
   }

   public function show(Product $product)
   {
      return view('student.market.show',[
         'product' => $product
      ]);
   }

   public function cart()
   {
      return view('student.market.cart');
   }

   public function checkout()
   {
      return view('student.market.checkout');
   }

   public function remove(Cart $item)
   {
      $item->delete();
      return response()->json([
         'status' => true,
         'message' => 'You have successfully removed the product from your cart',
      ], 200);
   }

   public function update(Cart $item, $quantity)
   {
      $item->update([
         'quantity' => $quantity,
      ]);
      return response()->json([
         'status' => true,
         'message' => 'Quantity has been updated!',
      ], 200);
   }
}
