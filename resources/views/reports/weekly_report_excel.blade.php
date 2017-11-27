<table class="table table-striped table-bordered table-hover no-footer collapsed table-datatable" >
    <thead>
    <tr>
        <th align="center">#</th>
        <th>Business Manager</th>
        <th>Employer</th>
        @foreach ($daterange_arr as $date)
        <th class="text-center" align="center">{{$date}}</th>
        <th></th>
        @endforeach
        <th align="center">RQST</th>
        <th align="center">Actual</th>
        <th align="center">%</th>
    </tr>

    <tr>
        <th >#</th>
        <th >Business Manager</th>
        <th >Employer</th>
        @foreach ($daterange_arr as $date)
        <th align="center">RQST</th>
        <th align="center">Actual</th>
        @endforeach
        <th></th>
        <th></th>
        <th></th>
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
                <td valign="top" align="right">{{$count}}</td>
                <td valign="top">{{ $v['business_manager'] }}</td>
                @else
                <td></td>
                <td></td>
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

                <td align="center">{{$row_req}}</td>
                <td align="center">{{$row_actual}}</td>
                <td align="center"><?php 
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