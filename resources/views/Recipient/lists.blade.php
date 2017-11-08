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
                                    <span class="caption-subject bold uppercase">Recipient Group List</span>
                                </div>
                                {{ csrf_field() }}
                                @if(Auth::user()->role_id == 0)
                                    <div class="actions">
                                        <a href="{{ route('recipient.create') }}"
                                           class="btn sbold green"> Add New
                                            <i class="fa fa-plus"></i>
                                        </a>

                                    </div>
                                @endif
                            </div>
                            <div class="portlet-body">
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
                                        <th>Recipient Group Name</th>
                                        <th>Date Created</th>
                                        <th>No. of Members</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key)
                                    <tr>
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input id ="group-checkable" type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>{{ $key->group_name }}</td>
                                        <td>{{ $key->created_at }}</td>
                                        <td>0</td>
                                        <td>{{ $key->email }}</td>
                                    </tr>
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
@endsection
