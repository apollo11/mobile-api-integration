@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comments"></i>Employers
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
                                        <th>Email</th>
                                        <th>School</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employees as $user)
                                        <tr>
                                            <td><input type="checkbox"/></td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->nric_no }}</td>
                                            <td>{{ $user->mobile_no }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->school }}</td>
                                            <td><span class="label label-sm label-info"> Pending </span></td>
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
