@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')


    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/highcharts.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/export-data.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/accessibility.js') }}"></script>

    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('surveyact', [$depart,$sur->subject_id]) }}"
                        style="text-decoration: underline;"> จัดการวิชา </a> / <a
                        href="{{ route('reportpageSubject', [$depart,$sur->survey_id]) }}"
                        style="text-decoration: underline;">แบบสำรวจ</a>
                    / <i>{{ $sur->survey_th }} </i></div><!-- /.card-header -->
                <!-- /.card-header -->

                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <div class="form-actions mb-2">
                            <a class="btn btn-lg btn-success ml-auto mr-4 text-white" href=""><i
                                    class="fa fa-file"></i>
                                Exoprt CSV</a>
                        </div>
                        <table class="table " border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle"> คำถาม </th>
                                    <th class="align-middle" style="width:40%"> ประเภท </th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @foreach ($surques->sortBy('question_id') as $q => $item)
                                    <!-- tr -->
                                    <tr>
                                        <td><a href="#">{{ $rowNumber++ }}</a></td>
                                        @if ($item->question_type == 1)
                                            <td>
                                                {!! $item->question !!}
                                            </td>
                                            <td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
                                            </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left" align="left">
                                            <div id="pie_4{{ $item->question_id }}"></div>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                    @php
                                                        $chartData = [];
                                                    @endphp
                                                    @for ($i = 1; $i <= 8; $i++)
                                                        @if (isset($item->{'choice' . $i}))
                                                            <tr>
                                                                <td></td>
                                                                @php
                                                                    $totalPeople = 0; // เก็บจำนวนคนทั้งหมดที่แสดง
                                                                    
                                                                @endphp
                                                                @foreach ($respoe as $reitem)
                                                                    @php
                                                                        $itemrespon = $reitem->response;
                                                                        $jsonRespon = json_decode($itemrespon, true);
                                                                        $dataRespon = collect($jsonRespon);
                                                                        $datajson = isset($dataRespon[$item->question_id]) ? json_decode($dataRespon[$item->question_id], true) : null;
                                                                        
                                                                    @endphp
                                                                    @if (isset($datajson) && $datajson == $i)
                                                                        @php
                                                                            $totalPeople += 1; // เพิ่มจำนวนคนที่แสดงลงใน $totalPeople
                                                                            
                                                                        @endphp
                                                                    @endif
                                                                @endforeach

                                                                <td>{{ $item->{'choice' . $i} }}</td>

                                                                <td>
                                                                    จำนวน

                                                                    @if ($totalPeople > 0)
                                                                        {{ $totalPeople }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                    คน
                                                                </td>
                                                                @php
                                                                    $totalPeoplePercent = 0;
                                                                    if (count($respoe) > 0) {
                                                                        $totalPeoplePercent = ($totalPeople / count($respoe)) * 100;
                                                                    }
                                                                    $chartData[] = [
                                                                        'choice' => $item->{'choice' . $i},
                                                                        'count' => $totalPeople,
                                                                    ];
                                                                @endphp

                                                                <td>ร้อยละ @if ($totalPeoplePercent > 0)
                                                                        {{ number_format($totalPeoplePercent) }}
                                                                    @else
                                                                        0
                                                                    @endif %</td>
                                                            </tr>
                                                            <script>
                                                                var question = {!! json_encode(strip_tags($item->question)) !!};
                                                                var chartData = {!! json_encode($chartData) !!};

                                                                Highcharts.chart("pie_4{{ $item->question_id }}", {
                                                                    chart: {
                                                                        plotBackgroundColor: null,
                                                                        plotBorderWidth: null,
                                                                        plotShadow: false,
                                                                        type: 'pie'
                                                                    },
                                                                    title: {
                                                                        text: question
                                                                    },
                                                                    tooltip: {
                                                                        pointFormat: '{point.name}'
                                                                    },
                                                                    plotOptions: {
                                                                        pie: {
                                                                            allowPointSelect: true,
                                                                            cursor: 'pointer',
                                                                            showInLegend: true,
                                                                            dataLabels: {
                                                                                enabled: false,
                                                                                format: '{point.name}',
                                                                                style: {
                                                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    series: [{
                                                                        name: 'จำนวน',
                                                                        colorByPoint: true,
                                                                        data: chartData.map(item => ({
                                                                            name: item.choice,
                                                                            y: item.count
                                                                        }))
                                                                    }]
                                                                });
                                                            </script>
                                                        @endif
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endif

                                @if ($item->question_type == 2)
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
                                                    'choic' => ${'c' . $c}, // Assuming ${'c' . $c} holds the choice name
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
                        @endif


                        @if ($item->question_type == 3)
                            <td>{!! $item->question !!}</td>
                            <td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left" align="left">
                                    <div class="container">
                                        <h4 class="card-title">ความคิดเห็น </h4>
                                        <ul class="list-icons mb-3 ">
                                            <li><span class="list-icon"><span
                                                        class="fas fa-comment-alt text-success"></span></span> -
                                            </li>
                                        </ul>
                                    </div>
                                </td><!-- /grid row -->
                                <td>
                                    <table>

                                    </table>
                                </td>
                            </tr>
                        @endif
                        @endforeach

                        <!-- /tr -->
                        <!-- tr -->

                        <!-- /tr -->


                        <!-- /tr -->
                        </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" name="__id" />
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('questionpagecreate', [$depart,'survey_id' => $sur]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
