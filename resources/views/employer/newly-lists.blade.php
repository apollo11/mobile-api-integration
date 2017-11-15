@extends('layouts.app')

@section('content')
    @foreach($employers as $key )
        <form id="destroy-{{ $key->id }}"
              action="{{ route('employer.multiple',['id' => $key->id,'param' => 'Delete']) }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Delete">
        </form>

    @endforeach


    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            {{--@if($errors->has('multicheck'))--}}
                {{--<div class="alert alert-danger alert-dismissable">--}}
                    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
                    {{--<strong>Error!</strong> Something went wrong. Please check.--}}
                {{--</div>--}}
            {{--@endif--}}
            <form action="{{ route('employer.multiple')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Employers</span>
                                </div>
                                {{ csrf_field() }}
                                <div class="actions">
                                    {{--<input class="btn sbold green" name="multiple" value="Delete" type="submit"/>--}}
                                    <a href="{{ route('employer.create') }}" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                       id="employee-table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th> Business Name</th>
                                        <th>Email</th>
                                        <th>Mobile No.</th>
                                        <th> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employers as $user)

                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" name="multicheck[]" class="checkboxes"
                                                           value="{{ $user->id }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td> {{ $user->business_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile_no}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('employer.multiple',['id' => $user->id, 'param' => 'Delete' ]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$user->id }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employer.edit',['id' => $user->id]) }}">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employer.details',['id' => $user->id ])  }}">
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
@endsection

@include('layouts.employee-datatables-include')