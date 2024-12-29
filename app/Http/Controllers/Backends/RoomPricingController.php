<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\Room;
use App\Models\RoomPricing;
use Illuminate\Http\Request;
use App\Services\CurrencyService;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
class RoomPricingController extends Controller
{
    public function index(Request $request, CurrencyService $currencyService)
    {
        if (!auth()->user()->can('view roomprices')){
            abort(403, 'Unauthorized action.');
        }

        $search = $request->input('search');
        $baseCurrency = $currencyService->getBaseCurrency();
        $currencySymbol = $baseCurrency === 'USD' ? '$' : '៛';
        $baseExchangeRate = $currencyService->getExchangeRate();

        $roomPricingQuery = RoomPricing::with('room')->when($request->room_id,function ($q)use($request){
            $q->where('room_id', $request->room_id);
        })
        ->when($request->filled('search'), function ($query) use ($search) {
            $query->whereHas('room', function ($room) use ($search) {
                $room->where('room_number', 'LIKE', '%' . $search . '%');
            });
        });
        $room_pricings = $roomPricingQuery->get()->map(function ($roomPricing) use ($baseExchangeRate) {
            $convertedPrice = $baseExchangeRate* $roomPricing->base_price;
            $roomPricing->converted_price = $convertedPrice;
            return $roomPricing;
        });

        $perPage = 5;
        $page = $request->input('page', 1);
        $paginatedRoomPricings = new LengthAwarePaginator(
            $room_pricings->forPage($page, $perPage),
            $room_pricings->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $rooms = Room::all();
        $usedRoomIds = RoomPricing::pluck('room_id')->toArray();
        $availableRooms = Room::whereNotIn('id', $usedRoomIds)->get();

        if ($request->ajax()) {
            $view = view('backends.room_pricing._table_room_pricing', compact('rooms','room_pricings','availableRooms','rooms','currencySymbol','paginatedRoomPricings'))->render();
            return response()->json([
                'view' => $view
            ]);
        }

        return view('backends.room_pricing.index',compact('rooms','room_pricings','availableRooms','rooms','currencySymbol','paginatedRoomPricings'));
    }

    public function store(Request $request, CurrencyService $currencyService)
    {
        try{
            $room_pricing = new RoomPricing();
            $room_pricing->room_id = $request->room_id;
            $room_pricing->base_price = $currencyService->convertCurrency($request->base_price);
            $room_pricing->effective_date = $request->effective_date;
            $room_pricing->save();
            $data =[
                'success'=>'Room pricing Added successfully'
            ];
        }catch(Exception $e){
            $data =[
                'error'=>'Something went wrong'
            ];
        }
        return redirect()->route('room-prices.index')->with($data);
    }
    public function update(Request $request, CurrencyService $currencyService, $id)
    {
        try{
            $room_pricing = RoomPricing::findOrFail($id);
            $room_pricing->room_id = $request->room_id;
            $room_pricing->base_price = $currencyService->convertCurrency($request->base_price);
            $room_pricing->effective_date = $request->effective_date;
            $room_pricing->save();
            $data =[
                'success'=>'Room pricing Update successfully'
            ];
        }catch(Exception $e){
            $data =[
                'error'=>'Something went wrong'
            ];
        }
        return redirect()->route('room-prices.index')->with($data);
    }
    public function destroy($id){
        try{
            RoomPricing::destroy($id);
            $data =[
               'success'=>'Room pricing deleted successfully'
            ];
        }catch(Exception $e){
            $data =[
                'error'=>'Something went wrong'
            ];
        }
        return redirect()->route('room-prices.index')->with($data);
    }
}
