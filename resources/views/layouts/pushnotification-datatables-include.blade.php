@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/filtering/row-based/range_dates.js"></script> -->
<script>
	var startDate;
	var endDate;
	var columnDate;
	var table;
	var columnDateIndex;
	$(document).ready(function() {
		columnDateIndex = 0;
	    table = $('#employee-table').DataTable({
	        dom: 'Bfrtip',
	        buttons: [
	            { "extend": 'excel', "text":'Export',"className": 'btn sbold red' @if(!empty($title)) ,"title" : "{{ $title }}" @endif  }
	        ],
	        autoFill: true,
	        
	        "scrollY":"500",
	        "scrollX" : true,
	        "sScrollXInner": "100%",
	    });
	    // console.log($('#employee-table').DataTable())
	    // table = $('#employee-table').DataTable();
    });


	// Date range filter
	function filter(startDate, endDate)
	{
		console.log('Date Filter Called');

		var viewType = localStorage.getItem('viewtype');
        console.log(viewType);
		if (viewType == "employee-list") {
        	columnDateIndex = 5;
        }
        else if (viewType == "employee-details") {
        	columnDateIndex = 2;
        }
        else if (viewType == "employer-details") {
        	columnDateIndex = 7;
        }
        else if (viewType == "payout-list") {
        	columnDateIndex = 7;
        }
        else if (viewType == "job-list") {
        	columnDateIndex = 7;
        }
        else if (viewType == "job-details") {
        	columnDateIndex = 4;
        }
        else if (viewType == "pushnotification-list") {
        	columnDateIndex = 3;
        }
        else if (viewType == "recipient-list") {
        	columnDateIndex = 3;
        }
        else {
        	columnDateIndex = 0;
        }

        startDate = new Date(startdate.toString());
        endDate = new Date(enddate.toString());

		if (startDate > endDate) {
        	console.log('invalid selection');
        	alert('Start date cannot be earlier than end date');
        	return true;
        }
        else {
        	table.draw();	
        }
    	
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

        	// columnDate = new Date(data[7]); // use data for the age column
        	var columnDate = new Date(data[columnDateIndex]);	
 
        	if (columnDate >= min && columnDate <= max)
        	{
        		console.log('Filtered Date ==> ', columnDate);
            	return true;
        	}
        	return false;
    	}
	);


</script>
@stop