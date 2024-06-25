<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {


        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile Updated Successfully');
        return redirect()->back();
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr('Password Updated Successfully', 'success', ["positionClass" => "toast-bottom-center"]);
        return redirect()->back();
    }
}
