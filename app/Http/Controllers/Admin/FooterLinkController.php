<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FooterLinksDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FooterLinkStoreRequest;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterLinksDataTable $dataTable)
    {
        return $dataTable->render('admin.footer.footer-links.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterLinkStoreRequest $request)
    {
        $link = new FooterLink();
        $link->category = $request->category;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->status = $request->status;
        $link->save();

        // toastr()->success('Created Successfully');

        return redirect()->route('admin.footer-links.index')->with('created', true);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = FooterLink::findOrFail($id);
        return view('admin.footer.footer-links.edit', ['link'=>$link]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterLinkStoreRequest $request, string $id)
    {
        //
        $link = FooterLink::findOrFail($id);
        $link->category = $request->category;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->status = $request->status;
        $link->save();

        // toastr()->success('Update Successfully');

        return redirect()->route('admin.footer-links.index')->with('edited', true);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $link = FooterLink::findOrFail($id);
            $link->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
