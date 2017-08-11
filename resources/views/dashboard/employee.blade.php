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
                                <th>NRIC</th>
                                <th>Contact No.</th>
                                <th>Email</th>
                                <th>School</th>
                            </tr>
                            @foreach($employees as $user)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nric_no }}</td>
                                <td>{{ $user->mobile_no }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->school }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
