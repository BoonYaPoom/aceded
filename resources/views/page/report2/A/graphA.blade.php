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
            var monthsYear = {!! json_encode($monthsYear) !!};

            var dataMonthWithId = {!! json_encode($dataMonthWithId) !!};



            $(document).ready(function() {
                $('#selectyear, #provin').on('change', function() {

                    var pro = $('#provin').val();

                    var selectedYear = $('#selectyear').val();

                    var selectedYearchartDataRe;
                    var selectedYearDataCon;
                    var selectedYearDataConno;

                    if (pro == 0) {
                        //กราฟวงกลม
                        //รวมทั้งหมด
                        var totalUserCount3 = 0;
                        var filteredData3 = chartDataRe.filter(data => data.year == selectedYear && pro == 0);
                        filteredData3.forEach(data => {
                            totalUserCount3 += parseInt(data.user_count);
                        });
                        selectedYearchartDataRe = totalUserCount3;
                        //กำลังเรียน
                        var totalUserCount2 = 0;
                        var filteredData2 = chartDataCon2.filter(data => data.year == selectedYear && pro == 0);
                        filteredData2.forEach(data => {
                            totalUserCount2 += parseInt(data.user_count);
                        });
                        selectedYearDataCon = totalUserCount2;
                        //เรียนจบแล้ว
                        var totalUserCount = 0;
                        var filteredData = chartDataConno.filter(data => data.year == selectedYear && pro == 0);
                        filteredData.forEach(data => {
                            totalUserCount += parseInt(data.user_count);
                        });
                        selectedYearDataConno = totalUserCount;

                        //กราฟตามเดือน
                    } else {
                        //กราฟวงกลม
                        //รวมทั้งหมด
                        selectedYearchartDataRe = chartDataRe.find(data => data.year == selectedYear && data
                            .province_name == pro);
                        selectedYearchartDataRe = selectedYearchartDataRe ? parseInt(selectedYearchartDataRe
                            .user_count) : 0;
                        //กำลังเรียน
                        selectedYearDataCon = chartDataCon2.find(data => data.year == selectedYear && data
                            .province_name == pro);
                        selectedYearDataCon = selectedYearDataCon ? parseInt(selectedYearDataCon
                            .user_count) : 0;
                        //เรียนจบแล้ว
                        selectedYearDataConno = chartDataConno.find(data => data.year == selectedYear && data
                            .province_name == pro);
                        selectedYearDataConno = selectedYearDataConno ? parseInt(selectedYearDataConno
                            .user_count) : 0;

                        //กราฟตามเดือน
                    }

                    const getNumberOfStudents = (monthId) => {
                        var matchingmonthscon;
                        if (pro == 0) {
                            var totalUserCountConno = 0;
                            var filteredDataConno = monthsconno.filter(data => data.month == monthId && data
                                .year == selectedYear && pro == 0);
                            filteredDataConno.forEach(data => {
                                totalUserCountConno += parseInt(data.user_count);
                            });
                            return matchingmonthscon = totalUserCountConno;
                        } else {
                            matchingmonthscon = monthsconno.find(data => data.month == monthId && data
                                .year ==
                                selectedYear && data.province_name == pro);
                            return matchingmonthscon ? parseInt(matchingmonthscon.user_count) : 0;
                        }
                    }

                    const getNumberOfCompletedStudents = (monthId) => {
                        var matchingMonthData;
                        if (pro == 0) {
                            var totalUserCountCon = 0;
                            var filteredDataCon = monthscon.filter(data => data.month == monthId && data
                                .year == selectedYear && pro == 0);
                            filteredDataCon.forEach(data => {
                                totalUserCountCon += parseInt(data.user_count);
                            });
                            return matchingMonthData = totalUserCountCon;
                        } else {
                            matchingMonthData = monthscon.find(data => data.month == monthId && data.year ==
                                selectedYear && data.province_name == pro);
                            return matchingMonthData ? parseInt(matchingMonthData.user_count) : 0;
                        }

                    }

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
                        if (pro == 0) {
                            var filteredmonthsYear = monthsYear.filter(data => data.month == monthId && data
                                .year == monthyear && pro == 0);
                            filteredmonthsYear.forEach(data => {
                                totalUsermonthsYear += parseInt(data.user_count);
                            });
                            matchingmonthsYear = totalUsermonthsYear
                            return matchingmonthsYear = totalUsermonthsYear;
                        } else {
                            matchingmonthsYear = monthscon.find(data => data.month == monthId && data
                                .year == monthyear && data.province_name == pro);
                            return matchingmonthsYear ? parseInt(matchingmonthsYear.user_count) : 0;
                        }

                    };

                    updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                        selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents,
                        StudentsRegisterget,
                        xAxisCategories, yearAll);
                });


                function updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                    selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents, StudentsRegisterget,
                    xAxisCategories) {
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
                            text: 'ผู้สำเร็จการเรียน  ปี ' + selectedYear + (pro == 0 ?
                                ' รวมทุกจังหวัดทั้งหมด' : ' ของ จังหวัด ' + pro)

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
                                    y: selectedYearDataConno,
                                },
                                {
                                    name: 'เรียบจบแล้ว',
                                    y: selectedYearDataCon,
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
                            text: 'ผู้สมัครเรียน  ปี ' + selectedYear + (pro == 0 ? ' รวมทุกจังหวัดทั้งหมด' :
                                ' ของ จังหวัด ' + pro)

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
                                    y: selectedYearchartDataRe,
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
                            text: 'สรุปข้อมูลประจำ  ปี ' + selectedYear + (pro == 0 ? ' รวมทุกจังหวัดทั้งหมด' :
                                ' ของ จังหวัด ' + pro)
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
                            text: 'จำนวนผู้ใช้งาน (ปีงบประมาณ)'
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
                            categories: xAxisCategories.map(monthObj => monthObj.month + ' ' + monthObj.year),
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
                            data: xAxisCategories.map(monthObj => StudentsRegisterget(monthObj.id,
                                monthObj.year)),
                        }],
                    });
                }
                $('#selectyear').trigger('change');
                $('#provin').trigger('change');

            });
        </script>
