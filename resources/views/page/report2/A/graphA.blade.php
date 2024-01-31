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
            var monthsconno = {!! json_encode($monthsconno) !!};
            var monthscon = {!! json_encode($monthscon) !!};
            var dateAll = {!! json_encode($dateAll) !!};
            var dateAllWithId = {!! json_encode($dateAllWithId) !!};
            var modifiedDateAll = dateAllWithId.map(function(element) {
                return element.id;
            });


            $(document).ready(function() {
                $('#selectyear, #provin').on('change', function() {

                    var pro = $('#provin').val();

                    var selectedYear = $('#selectyear').val();

                    var selectedYearchartDataRe = chartDataRe.find(data => data.year == selectedYear && data
                        .province_name == pro);
                    var selectedYearDataCon = chartDataCon2.find(data => data.year == selectedYear && data
                        .province_name == pro);
                    var selectedYearDataConno = chartDataConno.find(data => data.year == selectedYear && data
                        .province_name == pro);

                    console.log(selectedYear);
                    console.log('Selected Province:', pro);

                    function getNumberOfStudents(monthId) {
                        const matchingmonthscon = monthsconno.find(data => data.month == monthId && data.year ==
                            selectedYear && data.province_name == pro);
                        return matchingmonthscon ? parseInt(matchingmonthscon.user_count) : 0;
                    }

                    function getNumberOfCompletedStudents(monthId) {
                        const matchingMonthData = monthscon.find(data => data.month == monthId && data.year ==
                            selectedYear && data.province_name == pro);
                            console.log(matchingMonthData);
                        return matchingMonthData ? parseInt(matchingMonthData.user_count) : 0;
                    }

                    updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                        selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents);
                });

                function updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                    selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents) {
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
                            text: 'ผู้สำเร็จการเรียน  ปี ' + selectedYear + ' ของ จังหวัด ' + pro
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
                            text: 'ผู้สมัครเรียน  ปี ' + selectedYear + ' ของ จังหวัด ' + pro
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
                }
                $('#selectyear').trigger('change');
                $('#provin').trigger('change');

            });
        </script>
