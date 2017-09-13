@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comments"></i>Employee's
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Checkbox</th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NRIC</th>
                                        <th>Contact No.</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th> Ratings</th>
                                        <th> Agent Name </th>
                                        <th>Jobs applied</th>
                                        <th>Jobs completed</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employees as $user)
                                        <tr>
                                            <td><input type="checkbox"/></td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->company_name }}</td>
                                            <td>{{ $user->nric_no }}</td>
                                            <td>{{ $user->mobile_no }}</td>
                                            <td> {{ $user->choices }}</td>
                                            <td>{{ '09/08/1988' }}</td>
                                            <td>{{ 5 }}</td>
                                            <td>{{ $user->business_manager }}</td>
                                            <td>{{ 30 }}</td>
                                            <td>{{ 20 }}</td>
                                            <td>{{ $user->is_approved == 0 ? 'Registered' : 'Approved' }}</td>
                                            <td>
                                                <form id="approve" action="{{ route('employee.approve',['id' => $user->id]) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="Approve">
                                                </form>
                                                <form id="reject" action="{{ route('employee.reject',['id' => $user->id]) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="Reject">
                                                </form>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
