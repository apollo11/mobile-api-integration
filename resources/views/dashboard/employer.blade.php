@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Checkbox</th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Contact No.</th>
                                <th>Email</th>
                            </tr>
                            @foreach($employers as $user)
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->business_name }}</td>
                                    <td>{{ $user->mobile_no }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
