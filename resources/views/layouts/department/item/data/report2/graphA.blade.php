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

            var dateAllWithId = {!! json_encode($dateAllWithId) !!};
            var monthsconno = {!! json_encode($monthsconno) !!};
            var monthscon = {!! json_encode($monthscon) !!};
            var monthsYear = {!! json_encode($monthsYear) !!};

            var dataMonthWithId = {!! json_encode($dataMonthWithId) !!};
            $(document).ready(function() {
                $('#selectyear').on('change', function() {
                    var selectedYear = $('#selectyear').val();
                    var selectedYearchartDataRe = chartDataRe.find(data => data.year == selectedYear);
                    var selectedYearDataCon = chartDataCon2.find(data => data.year == selectedYear);
                    var selectedYearDataConno = chartDataConno.find(data => data.year == selectedYear);



                      var yearAll
                    yearAll = selectedYear
                    const xAxisCategories = dataMonthWithId
                        .sort((a, b) => a.sort - b.sort)
                        .map(monthObj => {
                            let adjustedYear = yearAll;
                            if (monthObj.sort >= 1 && monthObj.sort <= 3) {
                                adjustedYear -= 1; // ปีลบ 1 เมื่อเป็นเงื่อนไขที่กำหนด
                            }
                            return {
                                id: monthObj.id,
                                month: monthObj.month,
                                year: parseInt(adjustedYear)
                            };
                        });

                    const StudentsRegisterget = (monthId, monthyear) => {
                        var matchingmonthsYear;
                        var totalUsermonthsYear = 0;

                        matchingmonthsYear = monthscon.find(data => data.month == monthId && data
                            .year == monthyear );
                        return matchingmonthsYear ? parseInt(matchingmonthsYear.user_count) : 0;
                    };
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



                    function getNumberOfStudents(monthId) {

                        const matchingmonthscon = monthsconno.find(data => data.month == monthId && data.year ==
                            selectedYear);
                        return matchingmonthscon ? parseInt(matchingmonthscon.user_count) : 0;
                    }


                    function getNumberOfCompletedStudents(monthId) {
                        const matchingMonthData = monthscon.find(data => data.month == monthId && data.year ==
                            selectedYear);
                        return matchingMonthData ? parseInt(matchingMonthData.user_count) : 0;
                    }

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
                            categories: dateAllWithId.map(monthObj => monthObj.month),
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
                            name: 'ผู้กำลังเรียน',
                            data: dateAllWithId.map(monthObj => getNumberOfStudents(monthObj
                                .id)),
                        }, {
                            name: 'ผู้สำเร็จการเรียน',
                            data: dateAllWithId.map(monthObj => getNumberOfCompletedStudents(
                                monthObj.id)),
                        }],
                    });

                    Highcharts.chart("chartyearregister2", {
                        chart: {
                            type: 'line',
                            style: {
                                fontFamily: 'prompt'
                            }
                        },
                           title: {
                            text: 'จำนวนการลงทะเบียนผู้ใช้งาน (ปีงบประมาณ)'
                        },
                        subtitle: {
                            text: 'จำนวนผู้ใช้งาน (ปีงบประมาณ)'
                        },
                        yAxis: {
                            title: {
                                text: 'จำนวน'
                            }
                        },
                        xAxis: {
                            categories: xAxisCategories.map(monthObj => monthObj.month + ' ' + monthObj
                                .year),
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
                            name: 'ปีงบฯ ' + selectedYear,
                            data: xAxisCategories.map(monthObj => StudentsRegisterget(monthObj
                                .id,
                                monthObj.year)),
                        }],
                    });
                });
                $('#selectyear').trigger('change');
            });
        </script>
