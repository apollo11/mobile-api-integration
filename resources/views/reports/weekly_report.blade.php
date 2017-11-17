@extends('layouts.app')

@section('content')
<div class="page-content-wrapper table-datatable-wrapper">
<div class="page-content reports-wrapper">
    <form action="{{ route('reports.weekly_report')  }}" method="POST">
        <div class="row">
        <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-line-chart font-dark"></i>
                    <span class="caption-subject bold uppercase">Reports - Weekly Report</span>
                </div>
                {{ csrf_field() }}
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover  no-footer collapsed table-datatable" >
                    <thead>
                    <tr>
                        <th rowspan=2>#</th>
                        <th rowspan=2>Business Manager</th>
                        <th rowspan=2>Hotel</th>
                        <th colspan=2 class="text-center">Day 1</th>
                        <th colspan=2 class="text-center">Day 2</th>
                        <th colspan=2 class="text-center">Day 3</th>
                        <th colspan=2 class="text-center">Day 4</th>
                        <th colspan=2 class="text-center">Day 5</th>
                        <th colspan=2 class="text-center">Day 6</th>
                        <th colspan=2 class="text-center">Day 7</th>
                        <th rowspan=2>RQST</th>
                        <th rowspan=2>Actual</th>
                        <th rowspan=2>%</th>
                    </tr>

                    <tr>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                        <th>RQST</th>
                        <th>Actual</th>
                
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
    function getExportFileName(){
        return 'Weekly Report Export';
    }

    $(document).ready(function() {

        $('.table-datatable').DataTable({
             dom: '<"toolbar col-md-8">Brtip',
             buttons: [
                        { "extend": 'excel', "text":'Export',"className": 'btn sbold red', filename: function () { return getExportFileName();} }
                    ],
            autoFill: true,
            ordering: false,
            scrollX : true

        });

        $("div.toolbar").html('<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">                                                            <input type="text" class="form-control" name="from">                      <span class="input-group-addon"> to </span><input type="text" class="form-control" name="to"> </div>');
        /*
        $('.table-datatable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        { "extend": 'excel', "text":'Export',"className": 'btn sbold red' }
                    ],
                    autoFill: true,
    //                "scrollCollapse": true,
                    "scrollY":"500"
                });*/
    });
</script>
@stop 