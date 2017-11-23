@extends('layouts.app')

@section('content')
<div class="page-content-wrapper employee-details">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('recipient.lists')  }}">Recipient Group</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">Recipient Group Details</span>
                        </div>
                        <div class="actions">
                            <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print"
                                   type="submit"/>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group">
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <td> <strong>Group Name</strong></td>
                                                        <td> {{ $details->group_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <strong>Email Address</strong></td>
                                                        <td> {{ $details->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> <strong>Created</strong></td>
                                                        <td> {{ $details->created_at }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.employee-datatables-include')