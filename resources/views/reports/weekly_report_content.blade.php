<table class="table table-striped table-bordered table-hover no-footer collapsed table-datatable" >
    <thead>
    <tr>
        <th colspan=1 rowspan=2>#</th>
        <th colspan=1 rowspan=2>Business Manager</th>
        <th colspan=1 rowspan=2>Employer</th>
        @foreach ($daterange_arr as $date)
        <th colspan=2 class="text-center" align="center">{{$date}}</th>
        @endforeach
        <th rowspan=2 class="active text-center" align="center">RQST</th>
        <th rowspan=2 class="active text-center" align="center">Actual</th>
        <th rowspan=2 class="success text-center" align="center">%</th>
    </tr>

    <tr>
        @foreach ($daterange_arr as $date)
        <th colspan="1" class="text-center" align="center">RQST</th>
        <th colspan="1" class="text-center" align="center">Actual</th>
        @endforeach
        
    </tr>
    </thead>
    <tbody>
        <?php $count = 0; $prev_bm = ''; ?>
        @foreach ($weekly_report as $k=>$v)
            <?php 
            $bm = $v['business_manager'];
            $rowspan = '';
            if(isset($total_employer_arr[$bm]) && $total_employer_arr[$bm] > 1){
                $rowspan = "rowspan=".$total_employer_arr[$bm];
            }
            $row_req = 0; $row_actual = 0; ?>
            <tr>
                @if($prev_bm!=$bm)
                <?php $count++; ?>
                <td {{$rowspan}}>{{$count}}</td>
                <td {{$rowspan}}>{{ $v['business_manager'] }}</td>
                @endif

                <td>{{$v['employer_name']}}</td>
                @foreach ($daterange_arr as $date)
                    @if(isset($v[$date]))
                        <?php 
                        $row_req += $v[$date]['request'];
                        $row_actual += $v[$date]['actual'];
                        ?>
                        <td align="center">{{$v[$date]['request']}}</td>
                        <td align="center">{{$v[$date]['actual']}}</td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                @endforeach

                <td align="center" class="active">{{$row_req}}</td>
                <td align="center" class="active">{{$row_actual}}</td>
                <td align="center" class="success"><?php 
                $percent = 0;
                if($row_req > 0) { $percent = round( (($row_actual / $row_req) * 100),2); }
                ?>
                {{$percent}}
                </td>
            </tr>
            <?php $prev_bm = $v['business_manager'];?>
        @endforeach
    </tbody>
</table>