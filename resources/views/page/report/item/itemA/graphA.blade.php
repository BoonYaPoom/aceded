@php
    $chartData = [];
    $chartDataRe = [];
    $chartDataAll = [];
    $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    
    foreach ($perType as $per) {
        $uniqueUserIds = [];
        $personType = $per->person_type;
        $totalCount = 0;
        $totalCountRE = 0;
        $totalCountAll = 0;
    
        foreach ($learners as $l => $lrean) {
            $dataLearn = $lrean->registerdate;
            $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
    
            $year = \Carbon\Carbon::parse($dataLearn)->year + 543;
            $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lrean->registerdate)->format('d/m/Y H:i:s');
    
            if (!in_array($lrean->user_id, $uniqueUserIds)) {
                array_push($uniqueUserIds, $lrean->user_id);
                if ($lrean->congratulation == 1) {
                    $count = \App\Models\Users::where('user_id', $lrean->user_id)
                        ->where('user_type', $personType)
                        ->count();
    
                    $totalCount += $count;
                }
                if ($lrean->registerdate) {
                    $countregis = \App\Models\Users::where('user_id', $lrean->user_id)
                        ->where('user_type', $personType)
                        ->count();
    
                    $totalCountRE += $countregis;
                }
            }
        }
        $chartData[] = [
            'choice' => $per->person,
            'count' => $totalCount,
        ];
        $chartDataRe[] = [
            'choice' => $per->person,
            'count' => $totalCountRE,
        ];
        $chartDataCon[] = [
            'choice' => $per->person,
            'count' => $totalCountRE,
        ];
    }
    foreach ($learners as $lea) {

    }
@endphp
<script>
    var chartData = {!! json_encode($chartData) !!};
    var chartDataRe = {!! json_encode($chartDataRe) !!};
    var dateAll = {!! json_encode($dateAll) !!};


    console.log(chartData);
    console.log(chartDataRe);


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
            name: 'จำนวน',
            colorByPoint: true,
            data: chartData.map(item => ({
                name: item.choice,
                y: item.count
            }))
        }]
    });

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
            data: chartDataRe.map(item => ({
                name: item.choice,
                y: item.count
            }))
        }]

    });


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
            categories: dateAll
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
            data: [0, 0, 0, 3, 5, 34, 0, 4, 13, 141, 13, 0]
        }, {
            name: 'ผู้สำเร็จการเรียน',
            data: [0, 0, 0, 0, 2, 0, 4, 3, 0, 2, 15, 2]
        }]
    });
</script>
