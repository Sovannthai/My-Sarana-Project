@extends('backends.master')
@section('title', 'Rooms')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Rooms</label>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary float-right text-uppercase btn-sm">
                <i class="fas fa-plus"> @lang('Add Room')</i>
            </a>
        </div>
        <div class="card-body">
            <table id="rooms-table" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Room Number')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Size')</th>
                        <th>@lang('Floor')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody id="room-data">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchRooms();
        });

        function fetchRooms() {
            fetch("{{ url('api/v1/rooms') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        let rooms = data.data;
                        let tableBody = document.getElementById('room-data');
                        tableBody.innerHTML = '';

                        rooms.forEach((room, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${room.room_number}</td>
                                    <td>${room.description ?? 'N/A'}</td>
                                    <td>${room.size ?? 'N/A'}</td>
                                    <td>${room.floor ?? 'N/A'}</td>
                                    <td>${room.status}</td>
                                    <td>
                                        <a href="{{ url('rooms/edit') }}/${room.id}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('Edit')">
                                            <i class="fa fa-edit ambitious-padding-btn text-uppercase"> @lang('Edit')</i>
                                        </a>&nbsp;&nbsp;
                                        <form action="{{ url('rooms/destroy') }}/${room.id}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete-btn" title="@lang('Delete')">
                                                <i class="fa fa-trash ambitious-padding-btn text-uppercase"> @lang('Delete')</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>`;
                            tableBody.innerHTML += row;
                        });
                    }
                })
                .catch(error => console.error('Error fetching rooms:', error));
        }
    </script>
@endsection
