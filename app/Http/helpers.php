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

?>