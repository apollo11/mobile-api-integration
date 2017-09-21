@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="form-group float-left">
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-icon right">
                                <i class="fa fa-search"></i>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <span class="input-group-btn">
                            <button class="btn blue left">Advance Filter</button>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-5 float-right">
                        <a class="btn blue right">Delete</a>
                        <a class="btn blue right">Export</a>
                        <a href="{{ route('employer.create') }}" class="btn blue right">Add New Employer</a>
                    </div>
                </div>
            </div>
            <br />
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
                                        <th>Company Name</th>
                                        <td>Industry</td>
                                        <th>Average Hourly Rate</th>
                                        <th>Location</th>
                                        <th>Service Required </th>
                                        <th> Number of Job Posting</th>
                                        <th> Number of Candidates</th>
                                        <th> Business Manager</th>
                                        <th> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employers as $user)
                                        <tr>
                                            <td><input type="checkbox"/></td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->company_name }}</td>
                                            <td>{{ $user->industry }}</td>
                                            <td>{{ '$'.$user->rate.'/hr' }}</td>
                                            <td>{{ '10 Bayfron avenue, 018956' }}</td>
                                            <td>{{ 'Customer Service...' }}</td>
                                            <td>{{ '34' }}</td>
                                            <td>{{ '28' }}</td>
                                            <td> {{ $user->business_manager }}</td>
                                            <td>
                                                <a href="#">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
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
