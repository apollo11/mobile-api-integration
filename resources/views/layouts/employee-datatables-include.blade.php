@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function() {
	    $('#employee-table').DataTable({
	        dom: 'Bfrtip',
	        buttons: [
	            { "extend": 'excel', "text":'Export',"className": 'btn sbold red' }
	        ],
	        autoFill: true,
	//                "scrollCollapse": true,
	        "scrollY":"500",
	        "scrollX" : true
	    });
    });
</script>
@stop