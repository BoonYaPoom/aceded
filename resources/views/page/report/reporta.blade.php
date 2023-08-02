
@extends('page.report.index')
@section('reports')
 
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
<!-- .section-block -->
<div class="section-block">
    <!-- metric row -->
    <div class="metric-row">




        <div class="col-lg-12">
            <div class="metric-row metric-flush">
                <!-- metric column -->
                <div class="col">
                    <!-- .metric -->
                    <a href="" class="metric metric-bordered align-items-center">
                        <h2 class="metric-label"> ผู้ดูแลระบบ </h2>
                        <p class="metric-value h3">
                            <sub><i class="fas fa-user-cog fa-lg"></i> </sub> <span class="value ml-1">
                                {{ $count1 }}
                            </span>
                        </p>
                    </a> <!-- /.metric -->
                </div><!-- /metric column -->
                <!-- metric column -->
                <div class="col">
                    <!-- .metric -->
                    <a href="" class="metric metric-bordered align-items-center">
                        <h2 class="metric-label"> ผู้สอน </h2>
                        <p class="metric-value h3">
                            <sub><i class="fas fa-user-tie fa-lg"></i> </sub> <span class="value ml-1">
                                {{ $count3 }}</span>
                        </p>
                    </a> <!-- /.metric -->
                </div><!-- /metric column -->
                <!-- metric column -->
                <div class="col">
                    <!-- .metric -->
                    <a href="" class="metric metric-bordered align-items-center">
                        <h2 class="metric-label"> ผู้เรียน </h2>
                        <p class="metric-value h3">
                            <sub><i class="fas fa-user-graduate fa-lg"></i> </sub> <span class="value ml-1">
                                {{ $count4 }}</span>
                        </p>
                    </a> <!-- /.metric -->
                </div><!-- /metric column -->
            </div>
        </div>


    </div><!-- /metric row -->
    <!-- grid row -->
    <div class="row">
        <!-- grid column -->
        <div class="col-12 col-lg-12 col-xl-6">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-body -->
                <div class="card-body">
                    <div id="chartregister" style="min-width: 310px; height: 330px; margin: 0 auto">
                    </div>
                    <script>
                        //Highcharts.chart("chartcongratulation", { chart: {type: 'column'},title: {text: 'ผู้สมัครเรียน ปี 2023'},subtitle: {text: 'รายงานข้าราชการจำแนกตามระดับการศึกษา'},xAxis: {type: 'category'},yAxis: {title: {text: 'จำนวนข้าราชการ'}},legend: {enabled: false},plotOptions: {lang: {thousandsSep: ','},series: {borderWidth: 0,dataLabels: {enabled: true,data: '{point.y}'}}},tooltip: {headerFormat: '<span style="font-size:12px">{series.name}</span><br>',pointFormat: '<span>{point.name}</span>: <b>{point.y}</b> คน<br/>'},series: [{name: 'ระดับการศึกษา',colorByPoint: true,data: []}]});

                        Highcharts.chart("chartregister", {
                            chart: {
                                style: {
                                    fontFamily: 'prompt'
                                },
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'ผู้สมัครเรียน  ปี 2566'
                            },
                            subtitle: {
                                text: 'รายงานจำนวนผู้สมัครเรียนจำแนกกลุ่มผู้ใช้งาน'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.y}</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>:{point.percentage:.1f}% ',
                                        style: {
                                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: 'จำนวนผู้สมัคร',
                                colorByPoint: true,
                                data: [{
                                        name: 'กลุ่ม A',
                                        y: 10
                                    },
                                    {
                                        name: 'กลุ่ม B',
                                        y: 20
                                    },
                                    {
                                        name: 'กลุ่ม C',
                                        y: 30
                                    },
                                    // เพิ่มกลุ่มข้อมูลอื่นๆ ตามต้องการ
                                ]
                            }]

                        });
                    </script>


                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /grid column -->
        <!-- grid column -->
        <div class="col-12 col-lg-12 col-xl-6">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-body -->
                <div class="card-body">
                    <div id="chartcongratulation" style="min-width: 310px; height: 330px; margin: 0 auto">

                        <script>
                            Highcharts.chart("chartcongratulation", {
                                chart: {
                                    style: {
                                        fontFamily: 'prompt'
                                    },
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: 'ผู้สำเร็จการเรียน  ปี 2566'
                                },
                                subtitle: {
                                    text: 'รายงานจำนวนผู้สำเร็จการเรียนจำแนกกลุ่มผู้ใช้งาน'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.y}</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>:{point.percentage:.1f}% ',
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                            }
                                        }
                                    }
                                },
                                series: [{
                                    name: 'ผู้สำเร็จการเรียน',
                                    colorByPoint: true,
                                    data: [{
                                            name: 'กลุ่ม A',
                                            y: 10
                                        },
                                        {
                                            name: 'กลุ่ม B',
                                            y: 20
                                        },
                                        {
                                            name: 'กลุ่ม C',
                                            y: 30
                                        }
                                    ]
                                }]
                            });
                        </script>

                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /grid column -->
        <!-- grid column -->
        <div class="col-12 col-lg-12 col-xl-12">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-body -->
                <div class="card-body">
                    <div id="chartyearregister" style="min-width: 310px; height: 330px; margin: 0 auto">

                        <script>
                            Highcharts.chart("chartyearregister", {
                                chart: {
                                    type: 'line',
                                    style: {
                                        fontFamily: 'prompt'
                                    }
                                },
                                title: {
                                    text: 'สรุปข้อมูลประจำ  ปี 2566'
                                },
                                subtitle: {
                                    text: 'รายงานจำนวนผู้เรียนทั้งหมดจำแนกรายเดือน'
                                },
                                yAxis: {
                                    title: {
                                        text: 'จำนวน'
                                    }
                                },
                                xAxis: {
                                    categories: ['ต.ค.', 'พ.ย.', 'ธ.ค.', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.',
                                        'ส.ค.', 'ก.ย.'
                                    ]
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle'
                                },
                                plotOptions: {
                                    line: {
                                        allowPointSelect: false,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true
                                        }
                                    }
                                },
                                series: [{
                                    name: 'ผู้สมัครเรียน',
                                    data: [0, 1, 0, 0, 0, 1, 2, 0, 0, 0, 0, 0]
                                }, {
                                    name: 'ผู้สำเร็จการเรียน',
                                    data: [1, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0]
                                }]
                            });
                        </script>
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /grid column -->
    </div><!-- /grid row -->
</div><!-- /.section-block -->
<!-- grid row -->
<!-- .page-title-bar -->

    
@endsection