<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUploadTrait;

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

    public function updateAvatar(Request $request)
    {
        $imagePath = $this->uploadImage($request, 'avatar');
        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->save();
        return response(['status' => 'success', 'message' => 'avatar updated successfully']);
    }
}
