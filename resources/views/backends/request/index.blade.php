@extends('backends.master')
@section('contents')
    <div class="card">
        <div class="card-header text-uppercase">
            <h5>List Request</h5>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_requests as $row)
                        <tr>
                            <td>
                                <span>
                                    <a class="example-image-link"
                                        href="{{ $row->image ? asset('uploads/all_photo/' . $row->image) : $row->avatar }}"
                                        data-lightbox="lightbox-{{ $row->id }}">
                                        <img class="example-image image-thumbnail"
                                            src="{{ $row->image ? asset('uploads/all_photo/' . $row->image) : $row->avatar }}"
                                            alt="profile" width="50px" height="50px" style="cursor:pointer" />
                                    </a>
                                </span>
                            </td>
                            <td>{{ $row->first_name }}</td>
                            <td>
                                <a href="" class="btn btn-outline-primary btn-sm">View <span class="badge badge-danger">4</span></a>
                                <a href="" class="btn btn-outline-info btn-sm">Reply</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
