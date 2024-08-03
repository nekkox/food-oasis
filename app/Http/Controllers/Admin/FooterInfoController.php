<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FooterInfoUpdateRequest;
use App\Models\FooterInfo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FooterInfoController extends Controller
{
    function index() : View {
        $footerInfo = FooterInfo::first();
        return view('admin.footer.footer-info.index',['footerInfo'=>$footerInfo]);
    }


    function update(FooterInfoUpdateRequest $request) {
        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'short_info' => $request->short_info,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'copyright' => $request->copyright
            ]
        );

        //toastr()->success('Updated Successfully!');

        return redirect()->back()->with('updated', true);
    }


}
