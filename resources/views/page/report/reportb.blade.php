@extends('page.report.index')
@section('reports')
    <div class="page-inner">

        <form method="post" id="formreport">
            <div class="form-row">
                <!-- form column -->
                <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                <div class="col-md-3">
                    <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                            data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                            <option value="2022"> 2565 </option>
                            <option value="2023" selected> 2566 </option>
                        </select></div>
                </div>
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

                            <script>
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
                                        name: 'จำนวนผู้เรียน',
                                        colorByPoint: true,
                                        data: [{
                                            name: 'รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย',
                                            y: 3,
                                            color: ''
                                        }]
                                    }]
                                });
                            </script>

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

                            <script>
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
                                        categories: ['หน่วยการเรียนรู้ที่ 1 การคิดแยกแยะระหว่างผลประโยชน์ส่วนตนและผลประโยชน์ส่วนรวม'],
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
                                        name: 'เอกสาร',
                                        data: [1]
                                    }]
                                });
                            </script>

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
                                        name: 'จำนวนสื่อ Multimedia',
                                        colorByPoint: true,
                                        data: [1]
                                    }]
                                });
                            </script>

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
                            <script>
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
                                        data: [{
                                            name: 'รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย',
                                            y: 3,
                                            color: ''
                                        }]
                                    }]
                                });
                            </script>

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
                            <script>
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
                                        data: [3]
                                    }]
                                });
                            </script>

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->

                    @php
                    $countLogsByUid = \App\Models\Log::where('logid', 1)->get();
                   
                @endphp
                
                    
                    @foreach ($countLogsByUid as $lo => $logs)
                    @foreach ($month as $m => $land)
                    @php
                    $osLog = $logs->logplatform;
                    count($countLogsByUid);
                    $chartData[] = [
                                    'choice' => $land,
                                    'count' => 0,
                                ];
                    @endphp


                    @endforeach
                    @endforeach
                    <!--          var chartData = {!! json_encode($chartData) !!};
                    series: [{
                        name: 'จำนวน',
                        colorByPoint: true,
                        data: chartData.map(item => ({
                            name: item.choice,
                            y: item.count
                        }))
                    }]-->
                    <div class="card-body">
                        <div id="courselogin" style="min-width: 310px; height: 450px; margin: 0 auto">
                            <script>
                          
                            
                               
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
                                        categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                                            'Dec'
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
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
                                        pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> ครั้ง<br/>'
                                    },
                                    series: [{
                                        name: 'Windows',
                                        data: [5, 15, 26, 39, 27]
                                    }, {
                                        name: 'Android',
                                        data: [47, 10, 8, 20, 42]
                                    }]
                                });
                            </script>

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
