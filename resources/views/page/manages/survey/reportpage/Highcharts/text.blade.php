<td> {!! $item->question !!}
</td>
<td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}

</td>

</tr>
@php

    $question = json_decode($item->choice1, true);
    $answer = json_decode($item->choice2, true);
    $answer_val = ['น้อยที่สุด' => 1, 'น้อย' => 2, 'ปานกลาง' => 3, 'มาก' => 4, 'มากที่สุด' => 5];

    [$c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10] = array_pad($question, 10, null);

    [$a1, $a2, $a3, $a4, $a5] = array_pad($answer, 5, null);
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
    $countsd1 = [];
    $countsd2 = [];
    $countsd3 = [];
    $countsd4 = [];
    $countsd5 = [];
    $countsd6 = [];
    $countsd7 = [];
    $countsd8 = [];

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

        $dataArray = array_pad($dataArray, 8, null);
        [$d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8] = array_pad($dataArray, 8, null);

        $countsd1[] = (int) $d1;
        $countsd2[] = (int) $d2;
        $countsd3[] = (int) $d3;
        $countsd4[] = (int) $d4;
        $countsd5[] = (int) $d5;
        $countsd6[] = (int) $d6;
        $countsd7[] = (int) $d7;
        $countsd8[] = (int) $d8;
    @endphp
@endforeach


<tr>
    <td colspan="3" class="text-left" align="left">
        <table border=1 width="100%" class="table">
</tr>
<td rowspan="2" width="5%" class="text-middle text-center">ข้อที่</td>
<td rowspan="2" width="60%" class="text-middle text-center">ข้อความ</td>

<td colspan="9" width="50%" class="text-center">ระดับความพึงพอใจ</td>

</tr>
<tr>


    @for ($a = 1; $a <= 5; $a++)
        @if (isset(${'a' . $a}))
            <td>{{ ${'a' . $a} }}</td>
        @endif
    @endfor

    <td width="25%" class="text-center">ร้อยละค่าเฉลี่ย</td>

</tr>
@php
    $result1 = [];
    $result2 = [];
    $result3 = [];
    $result4 = [];
    $result5 = [];

    $numbersInRange = range(1, 5);

    foreach ($numbersInRange as $number) {
        $result1[$number] = 0;
        $result2[$number] = 0;
        $result3[$number] = 0;
        $result4[$number] = 0;
        $result5[$number] = 0;
    }

    // นับจำนวนของแต่ละตัวเลขใน $countsd1
    foreach ($countsd1 as $number) {
        if (isset($result1[$number])) {
            $result1[$number]++;
        }
    }
    foreach ($countsd2 as $number) {
        if (isset($result2[$number])) {
            $result2[$number]++;
        }
    }
    foreach ($countsd3 as $number) {
        if (isset($result3[$number])) {
            $result3[$number]++;
        }
    }
    foreach ($countsd4 as $number) {
        if (isset($result4[$number])) {
            $result4[$number]++;
        }
    }
    foreach ($countsd5 as $number) {
        if (isset($result5[$number])) {
            $result5[$number]++;
        }
    }
@endphp




@if (isset(${'c' . 1}))
    <td>{{ 1 }}</td>
    <td>{{ ${'c' . 1} }}</td>


    @for ($d = 1; $d <= 6; $d++)
        <td align="center">
            {{ isset($result1[$d]) ? $result1[$d] : '' }}
        </td>
    @endfor

    </tr>
@endif
@if (isset(${'c' . 2}))
    <td>{{ 2 }}</td>
    <td>{{ ${'c' . 2} }}</td>


    @for ($d = 1; $d <= 6; $d++)
        <td align="center">
            {{ isset($result2[$d]) ? $result2[$d] : '' }}
        </td>
    @endfor

    </tr>
@endif
@if (isset(${'c' . 3}))
    <td>{{ 3 }}</td>
    <td>{{ ${'c' . 3} }}</td>


    @for ($d = 1; $d <= 6; $d++)
        <td align="center">
            {{ isset($result3[$d]) ? $result3[$d] : '' }}
        </td>
    @endfor

    </tr>
@endif
@if (isset(${'c' . 4}))
    <td>{{ 4 }}</td>
    <td>{{ ${'c' . 4} }}</td>


    @for ($d = 1; $d <= 6; $d++)
        <td align="center">
            {{ isset($result4[$d]) ? $result4[$d] : '' }}
        </td>
    @endfor

    </tr>
@endif
@if (isset(${'c' . 5}))
    <td>{{ 5 }}</td>
    <td>{{ ${'c' . 5} }}</td>


    @for ($d = 1; $d <= 6; $d++)
        <td align="center">
            {{ isset($result5[$d]) ? $result5[$d] : '' }}
        </td>
    @endfor

    </tr>
@endif

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
