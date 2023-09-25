
    <td> {!! $item->question !!}
    </td>
    <td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
    </td>
</tr>
<tr>
    <td colspan="3" class="text-left" align="left">
        <table border=1 width="100%" class="table">
</tr>
<td rowspan="2" width="10%" class="text-middle text-center">ข้อที่</td>
<td rowspan="2" width="60%" class="text-middle text-center">ข้อความ</td>
<td colspan="3" width="30%" class="text-center">ระดับความพึงพอใจ</td>
</tr>
<tr>
    <td width="15%" class="text-center">ร้อยละค่าเฉลี่ย</td>
    <td width="15%" class="text-center">ความพึ่งพอใจ</td>
</tr>

@php
    
    $question = json_decode($item->choice1, true);
    $answer = json_decode($item->choice2, true);
    $answer_val = ['น้อยที่สุด' => 1, 'น้อย' => 2, 'ปานกลาง' => 3, 'มาก' => 4, 'มากที่สุด' => 5];
    
    [$c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8] = array_pad($question, 8, null);
    $chart = [];
    
    $sums = [];
    
    $d1 = 0;
    $d2 = 0;
    $d3 = 0;
    $d4 = 0;
    $d5 = 0;
    $d6 = 0;
    $d7 = 0;
    $d8 = 0;
@endphp
@foreach ($respoe as $val => $reitem)
    @php
        $itemrespon = $reitem->response;
        $jsonRespon = json_decode($itemrespon, true);
        if (isset($jsonRespon[$item->question_id]) && is_array($jsonRespon[$item->question_id])) {
            $dataRespon = collect($jsonRespon[$item->question_id]);
        } else {
            $dataRespon = collect([]);
        }
        
        $dataArray = $dataRespon->toArray();
        
        $dataArray = array_pad($dataArray, 8, null); // Pad the array to have 8 elements
        [$d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8] = array_pad($dataArray, 8, null);
        
        $sums[$item->question_id]['d1'] = isset($sums[$item->question_id]['d1']) ? $sums[$item->question_id]['d1'] + $d1 : $d1;
        $sums[$item->question_id]['d2'] = isset($sums[$item->question_id]['d2']) ? $sums[$item->question_id]['d2'] + $d2 : $d2;
        $sums[$item->question_id]['d3'] = isset($sums[$item->question_id]['d3']) ? $sums[$item->question_id]['d3'] + $d3 : $d3;
        $sums[$item->question_id]['d4'] = isset($sums[$item->question_id]['d4']) ? $sums[$item->question_id]['d4'] + $d4 : $d4;
        $sums[$item->question_id]['d5'] = isset($sums[$item->question_id]['d5']) ? $sums[$item->question_id]['d5'] + $d5 : $d5;
        $sums[$item->question_id]['d6'] = isset($sums[$item->question_id]['d6']) ? $sums[$item->question_id]['d6'] + $d6 : $d6;
        $sums[$item->question_id]['d7'] = isset($sums[$item->question_id]['d7']) ? $sums[$item->question_id]['d7'] + $d7 : $d7;
        $sums[$item->question_id]['d8'] = isset($sums[$item->question_id]['d8']) ? $sums[$item->question_id]['d8'] + $d8 : $d8;
        
    @endphp
@endforeach

@for ($c = 1; $c <= 8; $c++)
    @if (isset(${'c' . $c}))
        <td>{{ $c }}</td>
        @php
            
            $averageValue = 0;
            $averageValueFormatted = 0;
            if (count($respoe) > 2) {
                $averageValue = isset($sums[$item->question_id]['d' . $c]) ? $sums[$item->question_id]['d' . $c] / count($respoe) : 0;
                $averageValueFormatted = number_format($averageValue, 2, '.', '');
            }
            
            if ($averageValue <= 1.5) {
                $comparisonResult = 'น้อยที่สุด';
            } elseif ($averageValue <= 2.5) {
                $comparisonResult = 'น้อย';
            } elseif ($averageValue <= 3.5) {
                $comparisonResult = 'ปานกลาง';
            } elseif ($averageValue <= 4.5) {
                $comparisonResult = 'มาก';
            } else {
                $comparisonResult = 'มากที่สุด';
            }
            if (${'d' . $c} <= 1.5) {
                $comparisonResults = 'น้อยที่สุด';
            } elseif (${'d' . $c} <= 2.5) {
                $comparisonResults = 'น้อย';
            } elseif (${'d' . $c} <= 3.5) {
                $comparisonResults = 'ปานกลาง';
            } elseif (${'d' . $c} <= 4.5) {
                $comparisonResults = 'มาก';
            } else {
                $comparisonResults = 'มากที่สุด';
            }
        @endphp
        <td>{{ ${'c' . $c} }}</td>
        <td align="center">

            @if ($averageValueFormatted > 1)
                {{ $averageValueFormatted }}
            @elseif ($averageValueFormatted == 0 && ${'d' . $c} == 0)
                0
            @else
                {{ number_format(${'d' . $c}, 2, '.', '') }}
            @endif
        </td>
        <td align="center">

            @if ($averageValueFormatted > 1)
                {{ $comparisonResult }}
            @elseif (${'d' . $c})
                {{ $comparisonResults }}
            @elseif($averageValueFormatted == 0)
                {{ $comparisonResult }}
            @endif
        </td>
        </tr>
        @php
            $chart[] = [
                'choic' => ${'c' . $c},
                'coun' => $averageValueFormatted > 1 ? $averageValueFormatted : ${'d' . $c},
            ];
        @endphp
    @endif
@endfor

</table>

<table>

    <div id="bar6{{ $item->question_id }}"></div>

</table>

<script>
    var questi = {!! json_encode(strip_tags($item->question)) !!};
    var chart = {!! json_encode($chart) !!};
    console.log(chart)
    Highcharts.chart("bar6{{ $item->question_id }}", {
        chart: {
            type: 'column'
        },
        title: {
            text: questi
        },
        subtitle: {
            text: 'ความพึงพอใจ'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'ความพึงพอใจ'
            }
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            lang: {
                thousandsSep: ','
            },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}',
                    style: {
                        textOutline: false
                    }
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คะแนน<br/>'
        },
        series: [{
            name: 'จำนวน',
            colorByPoint: true,
            data: chart.map(item => ({
                name: item.choic,
                y: parseFloat(item.coun)
            }))
        }]
    });
</script>
