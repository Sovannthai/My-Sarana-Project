<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Amenity;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;

class AmenityController extends Controller
{
    // Uncomment this if you want to use permission-based access control.
    // function __construct()
    // {
    //     $this->middleware('permission:show amenity', ['only' => ['show', 'index']]);
    //     $this->middleware('permission:create amenity', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update amenity', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete amenity', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amenities = Amenity::all();
        return view('backends.amenity.index', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backends.amenity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAmenityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmenityRequest $request)
    {
        $amenity = new Amenity();
        $amenity->name = $request->input('name');
        $amenity->description = $request->input('description');
        $amenity->additional_price = $request->input('additional_price');
        $amenity->save();

        Session::flash('success', __('Amenity added successfully.'));
        return redirect()->route('amenities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amenity = Amenity::find($id);
        return view('backends.amenity.show', compact('amenity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $amenity = Amenity::find($id);
        return view('backends.amenity.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAmenityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAmenityRequest $request, $id)
    {
        $amenity = Amenity::find($id);
        $amenity->name = $request->input('name');
        $amenity->description = $request->input('description');
        $amenity->additional_price = $request->input('additional_price');
        $amenity->save();

        Session::flash('success', __('Amenity updated successfully.'));
        return redirect()->route('amenities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $amenity = Amenity::findOrFail($id);
            $amenity->delete();
            Session::flash('success', __('Amenity deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete amenity.'));
        }

        return redirect()->route('amenities.index');
    }
}
