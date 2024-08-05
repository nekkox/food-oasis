<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Http\Requests\Frontend\AddressUpdateRequest;
use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\ProductRating;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        $orders = Order::where('user_id', auth()->user()->id)->get();
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();

        $reviews = ProductRating::where('user_id', auth()->user()->id)->paginate(10);

        if ($request->ajax()) {
            return view('frontend.pages.ajax.user-review', ['reviews'=>$reviews])->render();

        }

        return view('frontend.dashboard.index',
            [
                'deliveryAreas' => $deliveryAreas,
                'userAddresses' => $userAddresses,
                'orders' => $orders,
                'reservations' => $reservations,
                'reviews'=>$reviews
            ]);
    }

    public function createAddress(AddressCreateRequest $request)
    {
        //dd($request->all());
        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        toastr()->success('Created Successfully');
        return to_route('dashboard');
    }

    public function updateAddress(string $id, AddressUpdateRequest $request)
    {

        $address = Address::findOrFail($id);
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        toastr()->success('Updated Successfully');

        return to_route('dashboard');

    }

    public function destroyAddress(string $id)
    {
        $address = Address::findOrFail($id);
        if ($address && $address->user_id === auth()->user()->id) {
            $address->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);

        }
        return response(['status' => 'error', 'message' => 'something went wrong!']);
    }
}
