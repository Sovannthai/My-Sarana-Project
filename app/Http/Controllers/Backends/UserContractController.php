<?php

namespace App\Http\Controllers\Backends;

use Exception;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\UserContract;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserContractRequest;
use App\Http\Requests\UpdateUserContractRequest;
use App\Models\RoomPricing;

class UserContractController extends Controller
{
    public function uploadImage($image)
    {
        $extension = $image->getClientOriginalExtension();
        $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
        $image->move(public_path('uploads/all_photo/'), $imageName);
        return $imageName;
    }
    public function uploadPDF($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
        $directory = public_path('uploads/contracts/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $file->move($directory, $fileName);
        return 'uploads/contracts/' . $fileName;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view contract')) {
            abort(403, 'Unauthorized action.'); 
        }

        $userContracts = UserContract::with(['user', 'room'])->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->with('roles')->get();
        $usedUsers = UserContract::pluck('user_id')->toArray();
        $availableUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->whereNotIn('id', $usedUsers)->with('roles')->get();

        $usedRooms = UserContract::pluck('room_id')->toArray();
        $availableRooms = Room::where('status', 'available')->whereNotIn('id', $usedRooms)->get();
        $rooms = Room::where('status', 'available')->get();
        $currencySymbol = '$';

        return view('backends.user_contract.index', compact('userContracts', 'users', 'availableUsers', 'availableRooms', 'currencySymbol', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $filePath = null;
            if ($request->hasFile('contract_pdf') && $request->file('contract_pdf')->isValid()) {
                $file = $request->file('contract_pdf');
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $filePath = $this->uploadPDF($file);
                } else {
                    $filePath = $this->uploadImage($file);
                }
            }
            $room_price = RoomPricing::where('room_id',$request->input('room_id'))->latest()->first();
            UserContract::create([
                'user_id' => $request->input('user_id'),
                'room_id' => $request->input('room_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'monthly_rent' => $room_price->base_price,
                'contract_pdf' => $filePath,
            ]);
            if ($request->input('room_id')) {
                Room::where('id', $request->input('room_id'))->update([
                    'status' => 'occupied',
                ]);
            }
            return redirect()->route('user_contracts.index')->with('success', 'User contract created successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while creating the contract.'])->withInput();
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $contract = UserContract::findOrFail($id);
            $filePath = $contract->contract_pdf;
            if ($request->hasFile('contract_pdf') && $request->file('contract_pdf')->isValid()) {
                $file = $request->file('contract_pdf');
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $filePath = $this->uploadPDF($file);
                } else {
                    $filePath = $this->uploadImage($file);
                }
            }

            $contract->update([
                'user_id' => $request->input('user_id'),
                'room_id' => $request->input('room_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'monthly_rent' => $request->input('monthly_rent'),
                'contract_pdf' => $filePath,
            ]);
            if ($request->input('room_id')) {
                Room::where('id', $request->input('room_id'))->update([
                    'status' => 'occupied',
                ]);
            }
            return redirect()->route('user_contracts.index')->with('success', 'User contract updated successfully.');
        } catch (Exception $e) {
            dd($e);
            return back()->withErrors(['error' => 'An error occurred while updating the contract.'])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserContract $userContract)
    {
        try {
            $pdfPath = public_path('uploads/contracts/' . $userContract->contract_pdf);
            if (!empty($userContract->contract_pdf) && file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            $imagePath = public_path('uploads/all_photo/' . $userContract->contract_image);
            if (!empty($userContract->contract_image) && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $userContract->delete();
            Room::where('id', $userContract->room_id)->update([
                'status' => 'available',
            ]);
            return redirect()->back()->with('success', 'User contract deleted successfully.');

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the contract.'])->withInput();
        }
    }

}
