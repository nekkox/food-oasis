<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index(): View
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.privacy-policy.index', ['privacyPolicy' => $privacyPolicy]);
    }

   public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['required']
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->input('content'),
            ]
        );
        //toastr()->success('Updated Successfully');

        return redirect()->back()->with('updated', true);
    }
}
