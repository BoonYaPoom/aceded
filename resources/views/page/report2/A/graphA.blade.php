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
            var registerdate = {!! json_encode($registerdate) !!};
            var modifiedDateAll = dateAllWithId.map(function(element) {
                return element.id;
            });
            var monthsYear = {!! json_encode($monthsYear) !!};

            var regisandconData = {!! json_encode($regisandcon) !!};
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
                        var totalUserCount4 = 0;
                        var filteredData4 = registerdate.filter(data => data.year == selectedYear);
                        filteredData4.forEach(data => {
                            totalUserCount4 += parseInt(data.user_count);
                        });
                        selectedYearchartDataRe = totalUserCount4;

                        var totalUserCount2 = 0;
                        var filteredData2 = chartDataCon2.filter(data => data.year == selectedYear);
                        filteredData2.forEach(data => {
                            totalUserCount2 += parseInt(data.user_count);
                        });
                        selectedYearDataCon = totalUserCount2;
                        //เรียนจบแล้ว
                        var totalUserCount = 0;
                        var filteredData = chartDataConno.filter(data => data.year == selectedYear);
                        filteredData.forEach(data => {
                            totalUserCount += parseInt(data.user_count);
                        });
                        selectedYearDataConno = totalUserCount;

                        //กราฟตามเดือน
                    } else {

                        //กราฟวงกลม
                        //รวมทั้งหมด
                        selectedYearchartDataRe = registerdate.find(data => data.year == selectedYear && data
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
                                .year == selectedYear);
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
                                .year == selectedYear);
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
                                .year == monthyear);
                            filteredmonthsYear.forEach(data => {
                                totalUsermonthsYear += parseInt(data.user_count);
                            });
                            matchingmonthsYear = totalUsermonthsYear
                            return matchingmonthsYear = totalUsermonthsYear;
                        } else {
                            matchingmonthsYear = monthsYear.find(data => data.month == monthId && data
                                .year == monthyear && data.province_name == pro);
                            return matchingmonthsYear ? parseInt(matchingmonthsYear.user_count) : 0;
                        }

                    };

                    const RegisAndConm = (selectedYear, statuscon) => {
                        var RegisAndConmonthsYear;
                        var matchingMonthData6
                        var totalUserCount5 = 0;
                        let siteCounts = {};
                        if (pro == 0) {
                            var filteredData5 = regisandconData.filter(data => data.year == selectedYear &&
                                pro == 0 && data.congrat == statuscon);
                            filteredData5.sort((a, b) => b.user_count - a.user_count);
                        } else {
                            var filteredData5 = regisandconData.filter(data => data.year == selectedYear &&
                                data.congrat == statuscon && pro == data.pro_name);
                            filteredData5.sort((a, b) => b.user_count - a.user_count);
                        }
                        filteredData5.forEach(data => {
                            const siteName = data.name_site;
                            const userCount = parseInt(data.user_count);

                            if (!siteCounts[siteName]) {
                                siteCounts[siteName] = userCount;
                            } else {
                                siteCounts[siteName] += userCount;
                            }
                        });
                        const constatus = Object.keys(siteCounts).map(siteName => ({
                            site: siteName,
                            count: siteCounts[siteName]
                        }));
                        return constatus;
                    }
                    const regisDataca = RegisAndConm(selectedYear, 0);
                    const ConDataca = RegisAndConm(selectedYear, 1);


                    var regisLearn = {!! json_encode($regisLearn) !!};


                    const RegisLearns = (statuscon) => {
                        var regisLearnYear;
                        let siteCounts = {};
                        if (pro == 0) {
                            var filteredData5 = regisLearn.filter(data =>
                                pro == 0 && data.congrat == statuscon);
                        } else {
                            var filteredData5 = regisLearn.filter(data =>
                                data.congrat == statuscon && pro == data.pro_name);
                        }

                        filteredData5.forEach(data => {
                            const siteName = data.year;
                            const userCount = parseInt(data.user_count);

                            if (!siteCounts[siteName]) {
                                siteCounts[siteName] = userCount;
                            } else {
                                siteCounts[siteName] += userCount;
                            }
                        });
                        const Restatus = Object.keys(siteCounts).map(siteName => ({
                            site: parseInt(siteName),
                            count: siteCounts[siteName]
                        }));
                        Restatus.sort((a, b) => a.site - b.site);
                        return Restatus;
                    }
                    const RegisLearnsData = RegisLearns(0);
                    const ConLearnsData = RegisLearns(1);

                    var regisAll = {!! json_encode($regisAll) !!};
                    const regisAlls = () => {
                        var regisLearnYear;
                        let siteCounts = {};
                        if (pro == 0) {
                            var filteredData5 = regisAll;
                        } else {
                            var filteredData5 = regisAll.filter(data => pro == data.pro_name);
                        }

                        filteredData5.forEach(data => {
                            const siteName = data.year;
                            const userCount = parseInt(data.user_count);

                            if (!siteCounts[siteName]) {
                                siteCounts[siteName] = userCount;
                            } else {
                                siteCounts[siteName] += userCount;
                            }
                        });
                        const Restatus = Object.keys(siteCounts).map(siteName => ({
                            site: parseInt(siteName),
                            count: siteCounts[siteName]
                        }));
                        Restatus.sort((a, b) => a.site - b.site);
                        return Restatus;
                    }
                    const regisAllsData = regisAlls();

                    updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                        selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents,
                        StudentsRegisterget, xAxisCategories, regisDataca, ConDataca, RegisLearnsData,
                        ConLearnsData,regisAllsData);
                });


                function updateChart(selectedYear, pro, selectedYearDataCon, selectedYearDataConno,
                    selectedYearchartDataRe, getNumberOfStudents, getNumberOfCompletedStudents, StudentsRegisterget,
                    xAxisCategories, regisDataca, ConDataca, RegisLearnsData, ConLearnsData,regisAllsData) {


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
                                ' ' : ' ของ จังหวัด ' + pro)

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
                            text: 'ผู้ลงทะเบียนสมาชิก  ปี ' + selectedYear + (pro == 0 ? ' ' :
                                ' ของ จังหวัด ' + pro)

                        },
                        subtitle: {
                            text: 'รายงานจำนวนผู้ลงทะเบียนสมาชิกจำแนกกลุ่มผู้ใช้งาน'
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
                                    name: 'จำนวนสมาชิกทั้งหมด',
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

                    Highcharts.chart("graphCer", {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'ภาพรวมผู้ลงทะเบียนเรียนกับผู้เรียนจบและได้รับใบประกาศนียบัตร (ตามกลุ่มเป้าหมาย)'
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                            }
                        },
                        yAxis: {
                            title: {
                                text: ''
                            }
                        },
                        credits: {
                            enabled: true,
                            text: 'กลุ่มเป้าหมาย',
                            style: {
                                fontSize: '16px',
                                color: '#000000',
                                cursor: 'default'
                            }
                        },
                        legend: {
                            enabled: true,
                            symbolHeight: 10,
                            symbolWidth: 10,
                            symbolRadius: 0,

                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
                            pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
                        },
                        series: [{
                            name: 'ผู้ลงทะเบียนเรียน',
                            color: '#4B70F5',
                            data: regisDataca.map(item => ({
                                name: item.site,
                                y: item.count,
                                color: '#4B70F5'
                            }))
                        }, {
                            name: 'ผู้เรียนจบและได้รับใบประกาศนียบัตร',
                            color: '#FF7F3E',
                            data: ConDataca.map(item => ({
                                name: item.site,
                                y: item.count,
                                color: '#FF7F3E'
                            }))
                        }]
                    });

                    Highcharts.chart("graphRegis", {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'ภาพรวมย้อนหลังสถิติผู้สมัครเข้าใช้งานระบบแพลตฟอร์มฯ'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'จำนวน (คน)'
                            }
                        },
                        legend: {
                            enabled: true,
                            symbolHeight: 10, // กำหนดความสูงของสัญลักษณ์
                            symbolWidth: 10, // กำหนดความกว้างของสัญลักษณ์
                            symbolRadius: 0, // กำหนดรัศมีของมุมสัญลักษณ์ให้เป็น 0 เพื่อให้เป็นสี่เหลี่ยม
                            align: 'right', // จัดชิดด้านขวา
                            verticalAlign: 'middle', // จัดกึ่งกลางในแนวตั้ง
                            layout: 'vertical' // จัดเรียงในแนวตั้ง
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
                                name: 'ผู้สมัครสมาชิก',
                                color: '#4B70F5',
                                data: regisAllsData.map(item => ({
                                    name: item.site,
                                    y: item.count,
                                    color: '#4B70F5'
                                })),
                            },
                            {
                                name: 'ผู้เรียนจบ',
                                color: '#FF7F3E',
                                data: ConLearnsData.map(item => ({
                                    name: item.site,
                                    y: item.count,
                                    color: '#FF7F3E'
                                })),
                            },
                            {
                                name: 'ผู้ลงทะเบียนเรียน',
                                color: '#758694',
                                data: RegisLearnsData.map(item => ({
                                    name: item.site,
                                    y: item.count,
                                    color: '#758694'
                                })),
                            }
                        ]
                    });

                }
                $('#selectyear').trigger('change');
                $('#provin').trigger('change');

            });
        </script>
