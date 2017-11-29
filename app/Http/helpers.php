<?php 

function validateDate($date, $format = 'Y-m-d'){
    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function getDatesByRange($startdate,$stopdate){
    $interval = new \DateInterval('P1D');
    $daterange = new \DatePeriod($startdate, $interval ,$stopdate,false);
    $daterange_arr = array();
    foreach($daterange as $date){
        $daterange_arr[] = $date->format("Y-m-d");
    }
    $daterange_arr[] = $stopdate->format('Y-m-d');
    return $daterange_arr;
}

function jobschedule_status_display($status){
    switch($status){
        case 'reject_request':
            return 'Rejected request';
        break;
        case 'auto_completed':
            return 'Auto completed';
        break;
        case 'auto_cancelled':
            return 'Auto cancelled';
        break;
        default:
            return ucfirst($status);
        break;
    }
}

?>