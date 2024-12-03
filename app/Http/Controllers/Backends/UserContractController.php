<?php

namespace App\Http\Controllers\Backends;

use App\Http\Requests\StoreUserContractRequest;
use App\Http\Requests\UpdateUserContractRequest;
use App\Models\UserContract;
use App\Models\User;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userContracts = UserContract::with(['user', 'room'])->get();
        $users = User::all();
        $rooms = Room::all();
        $currencySymbol = '$';

        return view('backends.user_contract.index', compact('userContracts', 'users', 'rooms', 'currencySymbol'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserContractRequest $request)
{
    $validated = $request->validated();

    if ($request->hasFile('contract_pdf') && $request->file('contract_pdf')->isValid()) {
        $file = $request->file('contract_pdf');
        // Ensure that the file is stored
        $filePath = $file->storeAs('uploads/contracts', $file->getClientOriginalName(), 'public');

        // Save the contract information
        $contract = new UserContract([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'monthly_rent' => $validated['monthly_rent'],
            'contract_pdf' => $filePath,
        ]);

        $contract->save();

        return redirect()->route('user_contracts.index')->with('success', 'User contract created successfully.');
    } else {
        // Handle error if file upload fails
        return back()->withErrors(['contract_pdf' => 'The uploaded file is invalid or missing.']);
    }
}



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserContractRequest $request, UserContract $userContract)
    {
        // Update contract PDF if provided
        if ($request->hasFile('contract_pdf')) {
            // Delete old PDF file
            if ($userContract->contract_pdf && Storage::disk('public')->exists($userContract->contract_pdf)) {
                Storage::disk('public')->delete($userContract->contract_pdf);
            }

            // Store new file
            $filePath = $request->file('contract_pdf')->store('contracts', 'public');
            $userContract->contract_pdf = $filePath;
        }

        // Update other fields
        $userContract->update([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'monthly_rent' => $request->monthly_rent,
        ]);

        return redirect()->back()->with('success', 'User contract updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserContract $userContract)
    {
        // Delete the associated contract PDF file
        if ($userContract->contract_pdf && Storage::disk('public')->exists($userContract->contract_pdf)) {
            Storage::disk('public')->delete($userContract->contract_pdf);
        }

        // Delete the user contract record
        $userContract->delete();

        return redirect()->back()->with('success', 'User contract deleted successfully.');
    }
}
