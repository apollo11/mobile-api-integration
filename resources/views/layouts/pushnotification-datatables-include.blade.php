@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/filtering/row-based/range_dates.js"></script> -->
<script>
	var table;
	$(document).ready(function() {
	    table = $('#employee-table').DataTable({
	        dom: 'Bfrtip',
	        autoFill: true,
	//                "scrollCollapse": true,
	        "scrollY":"500",
	        "scrollX" : true,
	        "sScrollXInner": "100%",
	    });
	    // console.log($('#employee-table').DataTable())
	    // table = $('#employee-table').DataTable();
    });


	// Date range filter
	function filter()
	{
		console.log('Date Filter Called');
    	table.draw();
    }


     $.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
        	var min = $('#min').val();
        	var max = $('#max').val();
        	// new Date('00:00:00 01-01-2018');
			// var max = new Date('00:00:00 11-03-2018');

			if (min == null || max == null || min == '' || max == '') {
        		return true;
        	}
        	min = new Date(min);
        	max = new Date(max);

        	var capturedDate = new Date(data[7]); // use data for the age column
 
        	if (capturedDate > min && capturedDate <= max)
        	{
        		console.log('Filtered Date ==> ', capturedDate);
            	return true;
        	}
        	return false;
    	}
	);


</script>
@stop