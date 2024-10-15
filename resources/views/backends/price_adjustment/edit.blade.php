@extends('backends.master')
@section('title', 'Edit Price Adjustment')
@section('contents')
    <form action="{{ route('price_adjustments.update', ['price_adjustment' => $priceAdjustment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $priceAdjustment->room_id == $room->id ? 'selected' : '' }}>
                        {{ $room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $priceAdjustment->amount }}" step="0.01">
        </div>
        <div class="form-group">
            <label for="startdate">Start Date</label>
            <input type="date" name="startdate" id="startdate" class="form-control" value="{{ $priceAdjustment->startdate }}">
        </div>
        <div class="form-group">
            <label for="enddate">End Date</label>
            <input type="date" name="enddate" id="enddate" class="form-control" value="{{ $priceAdjustment->enddate }}">
        </div>
        <button type="submit" class="btn btn-outline-primary">Update</button>
    </form>
@endsection
