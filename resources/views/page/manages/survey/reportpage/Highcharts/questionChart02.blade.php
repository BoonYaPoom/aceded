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
    $d9 = 0;

    $d10 = 0;
    $countsd1 = [];
    $countsd2 = [];
    $countsd3 = [];
    $countsd4 = [];
    $countsd5 = [];
    $countsd6 = [];
    $countsd7 = [];
    $countsd8 = [];
    $countsd9 = [];
    $countsd10 = [];
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

        $dataArray = array_pad($dataArray, 10, null);
        [$d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8, $d9, $d10] = array_pad($dataArray, 10, null);

        $countsd1[] = (int) $d1;
        $countsd2[] = (int) $d2;
        $countsd3[] = (int) $d3;
        $countsd4[] = (int) $d4;
        $countsd5[] = (int) $d5;
        $countsd6[] = (int) $d6;
        $countsd7[] = (int) $d7;
        $countsd8[] = (int) $d8;
        $countsd9[] = (int) $d9;
        $countsd10[] = (int) $d10;
    @endphp
@endforeach

@php

    $results = [];
    $maxSum = 0;
    $maxValue = 0;
    $totalSums = [];
    for ($c = 1; $c <= 10; $c++) {
        // สร้างตัวแปร result_c
        ${'result' . $c} = [];
        // วนลูปเพื่อคำนวณค่าแต่ละตัวแปร
        for ($i = 1; $i <= 5; $i++) {
            // กรองข้อมูล
            $filteredData = array_filter(${'countsd' . $c}, function ($value) use ($i) {
                return $value == $i;
            });
            // นับจำนวนและเก็บในตัวแปร result_c
            ${'result' . $c}[$i] = count($filteredData);
        }
        $totalCount = count(${'countsd' . $c});

        // ตรวจสอบว่ามีข้อมูลใน ${'countsd' . $c} หรือไม่
        if ($totalCount > 0) {
            // วนลูป ${'result' . $c} เพื่อคำนวณร้อยละ
            foreach (${'result' . $c} as $key => $value) {
                // คำนวณร้อยละแล้วเก็บใน ${'result' . $c} อีกครั้ง
                ${'result' . $c}[$key] = ($value / $totalCount) * 100;
            }

            // เก็บผลลัพธ์ใน $results
            $results['result' . $c] = ${'result' . $c};
            $currentSum = array_sum($results['result' . $c]);
            $maxSum = max($maxSum, $currentSum);
            $totalSums['result' . $c] = array_sum(${'result' . $c});
        }
    }

    $maxTotalSum = !empty($totalSums) ? max($totalSums) : 0;

@endphp


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

    <td width="25%" class="text-center">ระดับความพึงพอใจ</td>

</tr>

@for ($c = 1; $c <= 10; $c++)
    @if (isset(${'c' . $c}))
        <td>{{ $c }}</td>
        <td>{{ ${'c' . $c} }}</td>

        @if (!empty($respoe))

            @for ($d = 1; $d <= 5; $d++)
                <td align="center">
                    @if (isset(${'result' . $c}[$d]))
                        {{ number_format(${'result' . $c}[$d], 0) }}%
                    @else
                        -
                    @endif
                </td>
            @endfor


            <td align="center">
                @if (isset(${'result' . $c}))
                    @php
                        $maxValue = max(${'result' . $c});
                        $maxKeys = array_keys(${'result' . $c}, $maxValue);

                    @endphp
                    @for ($a = 1; $a <= 5; $a++)
                        @if (isset(${'a' . $a}))
                            @if (in_array($a, $maxKeys))
                                {{ ${'a' . $a} }}
                            @endif
                        @endif
                    @endfor
                @endif
            </td>

            @php
                $chart[] = [
                    'choic' => ${'c' . $c},
                    'coun' => number_format($maxValue, 0),
                    'pos' => implode(
                        ', ',
                        array_map(function ($key) use ($a1, $a2, $a3, $a4, $a5) {
                            return ${'a' . $key};
                        }, $maxKeys),
                    ),
                ];
            @endphp
        @else
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        @endif


        </tr>
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
                    format: '{point.y} <br/> <b>{point.pos}</b>',
                    style: {
                        textOutline: false
                    }
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คะแนน<br/> <b>{point.pos}</b>'
        },
        series: [{
            name: 'จำนวน',
            colorByPoint: true,
            data: chart.map(item => ({
                name: item.choic,
                y: parseFloat(item.coun),
                pos: item.pos
            }))

        }]
    });
</script>
