        @php
            $chartDataRe[] = [
                'choice' => 'ผู้สมัครเรียน',
                'count' => $learn,
            ];

        @endphp



        <script>
            // var chartDataRe = {!! json_encode($chartDataRe) !!};

            var chartDataCon2 = {!! json_encode($con) !!};
            var chartDataConno = {!! json_encode($conno) !!};
            var chartDataRe = {!! json_encode($learn) !!};
            var chartDataCon = {!! json_encode($chartDataCon) !!};

      var dateAll = {!! json_encode($dateAll) !!};
            var dateAllWithId = {!! json_encode($dateAllWithId) !!};
            var modifiedDateAll = dateAllWithId.map(function(element) {
                return element.id;
            });



            var chartDataCon3 = {!! json_encode($chartDataCon2) !!};

            $(document).ready(function() {
                $('#selectyear').on('change', function() {
                    var selectedYear = $('#selectyear').val();
                    var selectedYearchartDataRe = chartDataRe.find(data => data.year == selectedYear);
                    var selectedYearDataCon = chartDataCon2.find(data => data.year == selectedYear);
                    var selectedYearDataConno = chartDataConno.find(data => data.year == selectedYear);
                    var seriesData = modifiedDateAll.map(function(monthId) {
                        var chartData = chartDataCon[monthId];
                        if (chartData && chartData.year == selectedYear) {
                            return {
                                name: 'ผู้สำเร็จการเรียน', // Adjust the name as needed
                                y: parseInt(chartData.user_count),
                            };
                        } else {
                            return {
                                name: '',
                                y: 0,
                            };
                        }
                    });

                    var seriesData2 = modifiedDateAll.map(function(monthId2) {
                        var chartData2 = chartDataCon3[monthId2];
                        if (chartData2 && chartData2.year == selectedYear) {
                            return {
                                name: 'ผู้กำลังเรียน', // Adjust the name as needed
                                y: parseInt(chartData2.user_count),
                            };
                        } else {
                            return {
                                name: '',
                                y: 0,
                            };
                        }
                    });

                    if (selectedYear) {

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
                                text: 'ผู้สำเร็จการเรียน  ปี ' + selectedYear
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
                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                        style: {
                                            color: (Highcharts.theme && Highcharts.theme
                                                    .contrastTextColor) ||
                                                'black'
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: 'จำนวน',
                                data: [{
                                        name: 'เรียนอยู่',
                                        y: selectedYearDataConno ? parseInt(
                                            selectedYearDataConno
                                            .user_count) : 0,
                                    },
                                    {
                                        name: 'เรียบจบแล้ว',
                                        y: selectedYearDataCon ? parseInt(
                                            selectedYearDataCon
                                            .user_count) : 0,
                                    },
                                ],
                            }],
                        });
                    }
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
                            text: 'ผู้สมัครเรียน  ปี ' + selectedYear
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
                                    format: '<b>{point.name}</b>:{point.y} คน',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme
                                                .contrastTextColor) ||
                                            'black'
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'จำนวน',
                            data: [{
                                    name: 'จำนวนผู้เรียนทั้งหมด',
                                    y: selectedYearchartDataRe ? parseInt(
                                        selectedYearchartDataRe.user_count) : 0,
                                },

                            ],
                        }],

                    });




                    Highcharts.chart("chartyearregister", {
                        chart: {
                            type: 'line',
                            style: {
                                fontFamily: 'prompt'
                            }
                        },
                        title: {
                            text: 'สรุปข้อมูลประจำ  ปี ' + selectedYear
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
                        series: [ {
                            name: 'ผู้กำลังเรียน',
                            data: seriesData2
                        },{
                            name: 'ผู้สำเร็จการเรียน',
                            data: seriesData
                        }],
                    });
                });
                $('#selectyear').trigger('change');
            });
        </script>
