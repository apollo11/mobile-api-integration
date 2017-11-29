@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper employee-list">
        <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Push Notification List</span>
                                </div>
                                {{ csrf_field() }}
                                @if(Auth::user()->role_id == 0)
                                    <div class="actions">
                                        <a href="{{ route('pushnotification.quickNotification') }}"
                                           class="btn sbold green"> Add New Notification
                                            <i class="fa fa-plus"></i>
                                        </a>

                                    </div>
                                @endif
                            </div>
                            <div class="portlet-body job-lists-table">

                                <div>
                                    <div style="width: 40%; display: inline-block;">
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="min" placeholder="FROM">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="width: 40%; display: inline-block;">
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="max" placeholder="TO">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: inline-block; vertical-align: top;">
                                        <button type="button" class="btn btn-info" onclick="filter($('#min').val(), $('#max').val())">Apply</button>
                                    </div>
                                </div>
                                
                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                       id="employee-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Notification Subject</th>
                                        <th>Recipient Group</th>
                                        <th>Date Sent</th>
                                        <th>Create Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($list as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->message }}</td>
                                        <td>{{ $key->group_name }}</td>
                                        <td data-order="{{ Carbon\Carbon::parse($key->publish_date)->format('m-d-Y H:i:s') }}">{{ Carbon\Carbon::parse($key->created_date)->format('m-d-Y H:i:s') }}</td>
                                        <td data-order="{{ Carbon\Carbon::parse($key->updated_at)->format('m-d-Y H:i:s') }}">{{ Carbon\Carbon::parse($key->updated_at)->format('m-d-Y H:i:s') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="{{ route('pushnotification.delete',['id' =>  $key->id]) }}">
                                                        <i class="fa fa-trash"></i> Delete</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('pushnotification.edit',['id' =>  $key->id]) }}">
                                                        <i class="fa fa-edit"></i> Edit </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            localStorage.setItem('viewtype', 'pushnotification-list');
        });
    </script>

@endsection

@include('layouts.pushnotification-datatables-include')