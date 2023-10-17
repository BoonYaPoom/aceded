@extends('page.report.index')
@section('reports')
    <div class="page-inner">

        <form method="post" id="formreport">
            <div class="form-row">
                <!-- form column -->
                <!--    <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                                                                                                                                                                                            <div class="col-md-3">
                                                                                                                                                                                             <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                                                                                                                                                                                                        data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                                                                                                                                                                                                        <option value="2022"> 2565 </option>
                                                                                                                                                                                                        <option value="2023" selected> 2566 </option>
                                                                                                                                                                                                    </select></div>
                                                                                                                                                                                            </div>-->
                <div class="col-md-3 ">
                    <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control "
                            data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false"
                            onchange="$('#formreport').submit();">
                            <option value="0">เดือน</option>
                            <option value="10"> ตุลาคม </option>
                            <option value="11"> พฤศจิกายน </option>
                            <option value="12"> ธันวาคม </option>
                            <option value="1"> มกราคม </option>
                            <option value="2"> กุมภาพันธ์ </option>
                            <option value="3"> มีนาคม </option>
                            <option value="4"> เมษายน </option>
                            <option value="5"> พฤษภาคม </option>
                            <option value="6"> มิถุนายน </option>
                            <option value="7"> กรกฎาคม </option>
                            <option value="8"> สิงหาคม </option>
                            <option value="9"> กันยายน </option>
                        </select></div>
                </div>
                <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                        data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
                <!-- /form column -->
            </div><!-- /form row -->
        </form>
        <!-- .table-responsive -->
        <div class="row mt-3">
            <!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="graphlearner" style="min-width: 310px; height: 450px; margin: 0 auto">



                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursedoc" style="min-width: 310px; height: 450px; margin: 0 auto">


                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->

            <div class="col-12 col-lg-12 col-xl-6 ">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursemulti" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->

            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="courserating" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->

            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursesearch" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->

                    <div class="card-body">
                        <div id="courselogin" style="min-width: 310px; height: 450px; margin: 0 auto">


                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- .page-title-bar -->

        @php

            $chartDataRe = [];

            $nameclass = '';
            foreach ($cour as $c => $cocl) {
                if ($cocl->course_status == 1) {
                    $nameclass = $cocl->course_th;
                    $uniqueUserIds = [];
                    $totalCountRE = 0;
                    foreach ($learners as $l => $lrean) {
                        if (!in_array($lrean->user_id, $uniqueUserIds)) {
                            array_push($uniqueUserIds, $lrean->user_id);
                            if ($cocl->course_id == $lrean->course_id) {
                                if ($lrean->registerdate) {
                                    $countregis = \App\Models\Users::where('user_id', $lrean->user_id)->count();
                                    $totalCountRE += $countregis;
                                }
                            }
                        }
                    }
                    if ($totalCountRE !== 0) {
                        $chartDataRe[] = [
                            'choice' => $nameclass,
                            'count' => $totalCountRE,
                        ];
                    }
                }
            }

        @endphp
        <script>
            var chartDataRe = {!! json_encode($chartDataRe) !!};
            console.log(chartDataRe);
            Highcharts.chart("graphlearner", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'จำนวนผู้เรียนทั้งหมด'
                },
                subtitle: {
                    text: 'รายงานจำนวนผู้เรียนทั้งหมด'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'จำนวนผู้เรียนทั้งหมด'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    lang: {
                        thousandsSep: ','
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
                },
                series: [{
                    name: 'จำนวนผู้เรียนทั้งหมด',
                    colorByPoint: true,
                    data: chartDataRe.map(item => ({
                        name: item.choice,
                        y: item.count
                    }))
                }]
            });
        </script>



        <script>
            Highcharts.chart("coursemulti", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'จำนวนสื่อ Multimedia ทั้งหมด'
                },
                subtitle: {
                    text: 'จำนวนสื่อ Multimedia ทั้งหมด'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'จำนวนสื่อ Multimedia ทั้งหมด'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    lang: {
                        thousandsSep: ','
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> รายการ<br/>'
                },

                series: [{

                }]
            });
        </script>

        @php
            $chartDataFav = [];
            foreach ($favorit as $f => $fav) {
                if ($fav->status == 1) {
                    $numberLen = 0; // รีเซ็ตค่า $numberLen ใหม่ในแต่ละรอบของลูป
                    $countr = $cour->where('course_id', $fav->course_id)->all();
                    foreach ($countr as $ca => $courda) {
                        $coTh = $courda->course_th;
                        $leaCo = $learners->where('course_id', $courda->course_id)->all();
                        foreach ($leaCo as $leaC => $leaCos) {
                            if ($leaCos->learner_status == 1) {
                                $numberLen++;
                            }
                        }
                    }
                    if ($numberLen !== 0) {
                        $chartDataFav[] = [
                            'choice' => $coTh,
                            'count' => $numberLen,
                        ];
                    }
                }
            }

        @endphp


        <script>
            var chartDataFav = {!! json_encode($chartDataFav) !!};
            console.log(chartDataFav);
            Highcharts.chart("courserating", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
                },
                subtitle: {
                    text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    lang: {
                        thousandsSep: ','
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
                },

                series: [{
                    name: 'จำนวน Rating',
                    colorByPoint: true,
                    data: chartDataFav.map(item => ({
                        name: item.choice,
                        y: item.count
                    }))
                }]
            });
        </script>

        @php
            $chartDataBook0 = [];
            $chartDataBook1 = [];
            $bookTh = [];
            foreach ($bookcat as $bc => $bookcats) {
                if ($bookcats->category_status == 1) {
                    $bookType0Count = 0;
                    $bookType1Count = 0;

                    $book = $bookcats
                        ->books()
                        ->where('category_id', $bookcats->category_id)
                        ->where('book_status', 1) // เพิ่มเงื่อนไขนี้
                        ->get();
                    foreach ($book as $sb => $books) {
                        if ($books->book_type == 0) {
                            $bookType0Count++;
                        } elseif ($books->book_type == 1) {
                            $bookType1Count++;
                        }
                    }
                    if ($bookType0Count !== 0) {
                        $chartDataBook0[] = [
                            'choice' => 'ebook',
                            'count' => $bookType0Count,
                        ];
                    }

                    if ($bookType1Count !== 0) {
                        $chartDataBook1[] = [
                            'choice' => 'เอกสาร',
                            'count' => $bookType1Count,
                        ];
                    }
                }
            }

        @endphp

        <script>
            var chartDataBook0 = {!! json_encode($chartDataBook0) !!};
            var chartDataBook1 = {!! json_encode($chartDataBook1) !!};
            var bookTh = {!! json_encode($bookTh) !!};
            console.log(chartDataBook0);
            console.log(chartDataBook1);

            Highcharts.chart("coursedoc", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'จำนวนเอกสาร, ebook /หลักสูตร'
                },
                subtitle: {
                    text: 'จำนวนเอกสาร, ebook /หลักสูตร'
                },
                xAxis: {
                    categories: [
                        @foreach ($bookcat as $bc => $bookcats)
                            @if ($bookcats->category_status == 1)
                                '{{ $bookcats->category_th }}',
                            @endif
                        @endforeach
                    ],
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'จำนวนเอกสาร, ebook /หลักสูตร'
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
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> รายการ<br/>'
                },
                series: [{
                    name: 'ebook',
                    data: chartDataBook0.map(item => item.count)
                }, {
                    name: 'เอกสาร',
                    data: chartDataBook1.map(item => item.count)
                }]


            });
        </script>


        @php
            $search = \App\Models\Search::all();
            $processedKeywords = [];
            $chartSearch = [];

            foreach ($search as $sea) {
                $keywordCounts = collect($sea->keyword)->countBy();

                foreach ($keywordCounts as $keyword => $count) {
                    if (!in_array($keyword, $processedKeywords)) {
                        $processedKeywords[] = $keyword;
                        $chartSearch[] = [
                            'choice' => $keyword,
                            'count' => $count,
                        ];
                    } else {
                        foreach ($chartSearch as &$item) {
                            if ($item['choice'] === $keyword) {
                                $item['count'] += $count;
                            }
                        }
                    }
                }
            }
            usort($chartSearch, function ($a, $b) {
                return $b['count'] - $a['count'];
            });
        @endphp
        <script>
            var chartSearch = {!! json_encode($chartSearch) !!};
            console.log(chartSearch);
            Highcharts.chart("coursesearch", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
                },
                subtitle: {
                    text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    lang: {
                        thousandsSep: ','
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
                },
                series: [{
                    name: 'จำนวนค้นหา',
                    colorByPoint: true,
                    data: chartSearch.map(item => ({
                        name: item.choice,
                        y: item.count
                    }))
                }]
            });
        </script>




        @php
            $Logs = \App\Models\Log::all();
            $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            $chartLog = [];
            $result = [];
            $monthsa = [];
            $processedplatforms = [];
            $dateAllIndexed = array_values($dateAll);
            foreach ($Logs as $l => $Log) {
                $platform = $Log->logplatform;
                $dataLog = $Log->logdate;
                $yearsa = \ltrim(\Carbon\Carbon::parse($dataLog)->format('y'));

                // เพิ่มเงื่อนไขเช็คปีเป็น 2023
                if ($yearsa == 23) {
                    $monthsa = \ltrim(\Carbon\Carbon::parse($dataLog)->format('m'), '0');
                    $result[$monthsa]['logplatform'] = isset($result[$monthsa]['logplatform']) ? $result[$monthsa]['logplatform'] + 1 : 0;

                    if (!in_array($Log->logplatform, $processedplatforms)) {
                        $processedplatforms[] = $Log->logplatform;
                        $register = [];
                        foreach ($dateAll as $m => $month) {
                            $register[] = empty($result[$m]['logplatform']) ? null : $result[$m]['logplatform'];
                            $chartLog[] = [
                                'name' => $processedplatforms,
                                'data' => $register,
                            ];
                        }
                    }
                }
            }

        @endphp

        <script>
            var dateAll = {!! json_encode($dateAllIndexed) !!};
            var chartLog = @json($chartLog);

            console.log(dateAll);
            console.log(chartLog);
            Highcharts.chart("courselogin", {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
                },
                subtitle: {
                    text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
                },
                xAxis: {
                    categories: dateAll,
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
                    }
                },
                legend: {
                    enabled: false,

                },
                plotOptions: {
                    lang: {
                        thousandsSep: ',',

                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            data: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                    pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> ครั้ง<br/>'
                },
                series: chartLog

            });
        </script>




    </div><!-- /.page-inner -->
@endsection
