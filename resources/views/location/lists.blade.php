@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comments"></i>Location
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Checkbox</th>
                                        <th>#</th>
                                        <th>Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($location as $value)
                                        <tr>
                                            <td><input type="checkbox"/></td>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->location }}</td>
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
