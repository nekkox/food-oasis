<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.profile.index');
    }

    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        dd($request->all());
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        toastr('Updated Successfully', 'success',[ "positionClass"=> "toast-bottom-center"]);
        return redirect()->back();
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr('Password Updated Successfully', 'success',[ "positionClass"=> "toast-bottom-center"]);
        return redirect()->back();
    }

}
