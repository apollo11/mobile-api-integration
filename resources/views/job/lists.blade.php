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
                        <a href="{{ route('job.create') }}" class="btn blue right">Add New Post</a>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comments"></i>Jobs
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <ap></ap>
                                        <th>#</th>
                                        <th>Employer</th>
                                        <th>Job Title</th>
                                        <th>Required</th>
                                        <th>Applied</th>
                                        <th>Job Description</th>
                                        <th>Rate</th>
                                        <th> Job Date</th>
                                        <th> Job Time</th>
                                        <th> Status</th>
                                        <th> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($job as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->job_title }}</td>
                                            <td>{{ $value->no_of_person }}</td>
                                            <td>{{ '0' }}</td>
                                            <td>{{ str_limit($value->job_description, 15) }}</td>
                                            <td> {{ '$'.$value->rate.'/hr' }}</td>
                                            <td> {{ Carbon\Carbon::parse($value->start_date)->format('d-m-Y') }}</td>
                                            <td> {{ Carbon\Carbon::parse($value->start_date)->format('H:i:s') }}
                                                - {{ Carbon\Carbon::parse($value->end_date)->format('H:i:s') }}</td>
                                            <td> {{ $value->status }}</td>
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
