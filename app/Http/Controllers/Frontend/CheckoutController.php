<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
   public function index(): View
   {
       $addresses = Address::where('user_id', auth()->user()->id)->get();
       $deliveryAreas = DeliveryArea::where('status', 1)->get();

       return view('frontend.pages.checkout-view', ['addresses'=>$addresses, 'deliveryAreas'=>$deliveryAreas]);

   }

    public function CalculateDeliveryCharge(string $id) {

        try {
            $address = Address::findOrFail($id);

            $deliveryFee = $address->deliveryArea?->delivery_fee;
            $grandTotal = grandCartTotal() + $deliveryFee;
            return response(['delivery_fee' => $deliveryFee, 'grand_total' => $grandTotal]);
        }catch(\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong!'], 422);
        }
    }

    public function checkoutRedirect(request $request){
       $request->validate([
           'id' =>['required', 'integer']
       ]);

       $address = Address::with('deliveryArea')->findOrFail($request->id);
       $selectedAddress = $address->address.', Area: '. $address->deliveryArea?->area_name;
        session('address', $selectedAddress);

        return response(['redirect_url' => route('payment.index')]);

    }
}