<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.setting.index');
    }

    public function UpdateGeneralSetting(Request $request) : RedirectResponse
    {
      $validatedData =  $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_icon_position' => ['required', 'max:255'],
        ]);


      foreach ($validatedData as $key => $value){
          Setting::updateOrCreate(
              ['key'=>$key],
              ['value' => $value]

          );
      }
        return redirect()->back()->with('updated', true);
    }
}
