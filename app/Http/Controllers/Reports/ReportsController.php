<?php

namespace App\Http\Controllers\Reports;

// use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Job;
use Excel;

class ReportsController extends Controller
{
    //
    public function weekly_report(){
        $basedate = '';
        $stopdate = new \DateTime($basedate);
        $startdate = clone $stopdate;
        $startdate->modify('-6 days');

        $viewdata = $this->renderWeeklyReport($startdate,$stopdate);
        return view('reports.weekly_report',$viewdata);
    }

    public function weekly_report_filter(Request $request){
        $type = $request->input('type');
        $keyword = $request->input('keyword');
        $start = $request->input('startdate');
        if(!empty($start) && validateDate($start) ){
            $startdate = new \DateTime($start);
            $stopdate = clone $startdate;
            $stopdate->modify('+6 days');
        }else{
            $stop = $request->input('stopdate');
            if(empty($stop) || !validateDate($stop) ){
                $stop = '';
            }
            $stopdate = new \DateTime($stop);
            $startdate = clone $stopdate;
            $startdate->modify('-6 days');
        }
        $viewdata = $this->renderWeeklyReport($startdate,$stopdate,$keyword);

        if($type=='export'){
            $filename = 'Weekly Report -'.$startdate->format('Y-m-d').' to '.$stopdate->format('Y-m-d');
            Excel::create($filename, function($excel) use ($viewdata) {
                $excel->sheet('New sheet', function($sheet) use($viewdata) {
                    $sheet->loadView('reports.weekly_report_excel',$viewdata);

                    /*rowspan for header*/
                    $sheet->mergeCells('A1:A2');
                    $sheet->mergeCells('B1:B2');
                    $sheet->mergeCells('C1:C2');
                    $sheet->mergeCells('R1:R2');
                    $sheet->mergeCells('S1:S2');
                    $sheet->mergeCells('T1:T2');
                    /*rowspan for header*/

                    /*colspan for header*/
                    $sheet->mergeCells('D1:E1');
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('H1:I1');
                    $sheet->mergeCells('J1:K1');
                    $sheet->mergeCells('L1:M1');
                    $sheet->mergeCells('N1:O1');
                    $sheet->mergeCells('P1:Q1');
                    /*colspan for header*/

                    if(isset($viewdata['rowspan_data']) && !empty($viewdata['rowspan_data'])){
                        foreach($viewdata['rowspan_data'] as $k=>$v){
                            asort($v);
                            $first = reset($v);
                            $last = end($v);

                            $sheet->mergeCells('A'.$first.':A'.$last);
                            $sheet->mergeCells('B'.$first.':B'.$last);
                        }
                    }
                    $sheet->setAutoSize(false);
                });
            })->download('xlsx');
        }else{
            return view('reports.weekly_report_content',$viewdata);
        }
    }

    private function renderWeeklyReport($startdate,$stopdate,$keyword=''){
        $weekly_report = array(); 
        $total_employer_arr = array();
        $daterange_arr = array();
        $rowspan_data = array();
        $prev_bm = '';$prev_employer = ''; 
        $count = 0; $countrow = 3;
                
        $jobs = new Job();
        $result = $jobs->getReportData($startdate,$stopdate,$keyword);
        if(!empty($result)){
            $daterange_arr = getDatesByRange($startdate,$stopdate);
             foreach($result as $k=>$v){
                $bm = $v->business_manager;
                $bm_id = $v->business_manager_id;
                if(empty($bm)){
                    $bm = 'Not specified';
                }
                $user_id = $v->user_id;
                $jobdate = $v->jobdate;

                if($bm_id!=$prev_bm){
                    $count = 1;
                }else{
                    if($prev_employer!=$user_id){
                        $count ++;
                        if(!isset($rowspan_data[$bm])){
                            $rowspan_data[$bm] = array(
                                $countrow, ($countrow - 1)
                            );
                        }
                    }
                }

                if(!isset($weekly_report[$bm.'_'.$user_id])){
                    $weekly_report[$bm.'_'.$user_id] = array(
                        'business_manager'=>$bm,
                        'business_manager_id'=>$v->business_manager_id,
                        'employer_name'=>$v->employer_name
                    );
                    $total_employer_arr[$bm] = 1;
                    $countrow++;
                }
                $total_employer_arr[$bm] = $count;
                $weekly_report[$bm.'_'.$user_id][$jobdate] = array('request'=>$v->request,'actual'=>$v->actual);

                $prev_bm = $bm_id;
                $prev_employer = $user_id;
            }
        }
        return [
            'weekly_report'=>$weekly_report,
            'daterange_arr'=>$daterange_arr,
            'rowspan_data'=>$rowspan_data,
            'total_employer_arr'=>$total_employer_arr,
            'startdate'=>$startdate->format('Y-m-d'),
            'stopdate'=>$stopdate->format('Y-m-d')
        ];
    }
}
