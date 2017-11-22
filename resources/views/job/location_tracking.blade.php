@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper employee-details">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('job.lists')  }}">Jobs</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Location Tracking</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Job - Location Tracking</span>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover table-bordered">
                                                        <tbody>
                                                        <tr>
                                                            <td><strong>Job Title</strong></td>
                                                            <td>{{ $details->job_title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Job Date &amp; Time</strong></td>
                                                            <td>{{ date('d M Y g:iA',strtotime("$details->start_date"))  }} - {{ date('d M Y g:iA',strtotime("$details->end_date"))  }}</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td><strong>Job Location</strong></td>
                                                            <td>{{ $details->geolocation_address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Job Description</strong></td>
                                                            <td>{{ $details->job_description }}</td>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td><strong>Contact Person</strong></td>
                                                            <td>{{ $details->contact_person }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Contact No.: </strong></td>
                                                            <td>{{ $details->contact_no }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Company Name </strong></td>
                                                            <td>{{ $details->company_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Business Manager </strong></td>
                                                            <td>{{ $details->business_manager }}</td>
                                                        </tr>
                                                   
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered related-jobs">
                        
                        <div class="portlet-body">
                           <div id="map" style="height:400px"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a class="btn sbold green" href="{{ route('job.lists')  }}">Back</a>
            </div>
        </div>
    </div>
   
@endsection


@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyC3DlCPvcL4Tju4CL8yC4gwiAySeqXzS-M"></script>
<script src="{{ asset('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    var map;
    $(document).ready(function(){
      map = new GMaps({
        div: '#map',
        zoom:12,
        lat: 1.352083,
        lng: 103.819836
      });
    });
  </script>

  @if(!empty($markers))
  <script>
    $(document).ready(function(){
        @foreach ($markers as $k=>$v)
         map.addMarker({
            lat: {{ $v->employee_current_lat }},
            lng: {{ $v->employee_current_long }},
            title: '{{$v->name}}',
            infoWindow: {
              content: '<p>{{ $v->name }}</p>'
            }
          });
         @endforeach
     });
  </script>
  @endif

@stop