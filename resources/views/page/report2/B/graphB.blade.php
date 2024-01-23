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
                    data: chartSearch.map(item => ({
                        name: item.choice,
                        y: item.count
                    }))
                }]
            });
        </script>




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

