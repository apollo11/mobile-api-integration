@extends('layouts.app')

@section('content')
    @foreach($list as $value)
        <form id="destroy-{{ $value->id }}" action="{{ route('recipient.delete',['id' => $value->id]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Delete">
        </form>
    @endforeach
    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            @if($errors->has('multicheck'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> Something went wrong. Please select data before making changes.
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>

                <script type="text/javascript">
                    setTimeout(function () {
                        $('.alert-success').hide().remove();
                    }, 3000);
                </script>
            @endif

            <form action="{{ route('recipient.multiple')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Recipient Group List</span>
                                </div>
                                {{ csrf_field() }}
                                @if(Auth::user()->role_id == 0)
                                    <div class="actions">
                                        <a href="{{ route('recipient.create') }}"
                                           class="btn sbold green"> Add New
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
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
                                        <button type="button" class="btn btn-info" onclick="filter($('#min').val(), $('#max').val())"">Apply</button>
                                    </div>
                                </div>
                                
                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                       id="employee-table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input id ="group-checkable" type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>#</th>
                                        <th>Recipient Group Name</th>
                                        <th>Date Created</th>
                                        <th>Email</th>
                                        <th> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key)
                                    <tr>
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input id ="group-checkable" type="checkbox" class="checkboxes"
                                                       data-set="#employee-table .checkboxes" name="multicheck[]" value="{{ $key->id }}"/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td> {{ $loop->iteration  }}</td>
                                        <td>{{ $key->group_name }}</td>
                                        <td data-order="{{ Carbon\Carbon::parse($key->created_at)->format('m-d-Y H:i:s') }}">{{ Carbon\Carbon::parse($key->created_at)->format('m-d-Y H:i:s') }}</td>
                                        <td>{{ $key->email }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>

                                                <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('recipient.delete',['id' =>  $key->id ]) }}"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('{{'destroy-'.$key->id }}').submit();">
                                                        <i class="fa fa-trash"></i> Delete</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('recipient.details',['id' =>  $key->id ])  }}">
                                                        <i class="fa fa-eye"></i> View </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            localStorage.setItem('viewtype', 'recipient-list');
        });
    </script>

@endsection

@include('layouts.employee-datatables-include',['exportbtn'=>false])