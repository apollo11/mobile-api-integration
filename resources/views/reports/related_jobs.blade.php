@extends('layouts.app')

@section('content')
<div class="page-content-wrapper table-datatable-wrapper">
<div class="page-content">
    <form action="{{ route('reports.related_jobs')  }}" method="POST">
        <div class="row">
        <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-line-chart font-dark"></i>
                    <span class="caption-subject bold uppercase">Reports - Related Jobs</span>
                </div>
                {{ csrf_field() }}
            </div>

            <div class="portlet-body">
                <table class="table table-scrollable table-bordered table-hover table-datatable" >
                    <thead>
                    <tr>
                        <th> Name</th>
                        <th> NRIC</th>
                        <th>Contact No.</th>
                        <th> Gender</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        </div>
    </form>
</div>
</div>
@endsection

@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.table-datatable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        { "extend": 'excel', "text":'Export',"className": 'btn sbold red' }
                    ],
                    autoFill: true,
    //                "scrollCollapse": true,
                    "scrollY":"500"
                });
    });
</script>
@stop


