@extends('layouts.app')

@section('content')
<div class="page-content-wrapper table-datatable-wrapper">
<div class="page-content reports-wrapper">
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
                <form action="{{url('reports/weekly_report_filter')}}" method="POST" id="filter-report">
                 {{ csrf_field() }}
                <div class="form-inline row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{$startdate}}" name="startdate" placehoder="Start Date" id="startdate" data-date-format="yyyy-mm-dd" placeholder="Start Date" /> 
                            <span class="input-group-addon"> - </span>
                            <input type="text" class="form-control" value="{{$stopdate}}" name="stopdate" placehoder="End Date" id="enddate" placeholder="End Date" readonly="readonly" />
                        </div>
                        <div class="input-group">
                            <input name="keyword" class="form-control" value="" placeholder="Enter a keyword to search" size='40'>
                        </div>
                        <input type="hidden" name="type" value="filter" id="report-filter-type">
                        <button type="button" id="submitform-btn" class="btn btn-info">Filter</button>
                        <button type="button" id="exportform-btn" class="btn btn-info pull-right sbold red">Export</button>
                    </div>
                </form>
                </div>

                <div class="table-scrollable" id="report-content">
                    @include('reports.weekly_report_content',['daterange_arr'=>$daterange_arr, 'weekly_report'=>$weekly_report])
                </div>
            </div>
        </div>
        </div>
        </div>
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

/*for export*/
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.11.10/xlsx.core.min.js" type="text/javascript"></script>
<script src="https://fastcdn.org/FileSaver.js/1.1.20151003/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/js/tableexport.min.js" type="text/javascript"></script> -->
/*for export*/
<script>
    function getExportFileName(){
        return 'Weekly Report Export';
    }

    $(document).ready(function() {
        $("#startdate").datepicker({
            todayBtn:  1,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            minDate.setDate(minDate.getDate() + 6);

            $('#enddate').val($.datepicker.formatDate('yy-mm-dd',  minDate ));
        });

       /* $("#filter-report").submit(function(e) {

            $.ajax({
                    url: $('#filter-report').attr("action"),
                    method: 'POST',
                    data : $('#filter-report').serialize(),
                    success: function(data){
                        $('#report-content').html(data);
                    }
            });
            e.preventDefault(); 
        });*/

       /* $('#filter-report table').tableExport({
            bootstrap: false
        });*/

        $( "#submitform-btn" ).click(function() {
            var url = $('#filter-report').attr("action");
            $('#report-filter-type').val('filter');
            $.ajax({
                    url: url,
                    method: 'POST',
                    data : $('#filter-report').serialize(),
                    success: function(data){
                        $('#report-content').html(data);
                    }
            });
        });

        $("#exportform-btn" ).click(function() {
            $('#report-filter-type').val('export');
            $('#filter-report').submit();
        });
    });
</script>
@stop 