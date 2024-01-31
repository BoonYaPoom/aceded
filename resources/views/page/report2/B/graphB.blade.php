  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();

              var learn = {!! json_encode($learn) !!};
              var selectedYearDataCon = learn.find(data => data.year == selectedYear);
              var filteredData = learn.filter(function(data) {
                  return data.year == selectedYear;
              });

              // เรียงลำดับข้อมูลตาม user_count จากมากไปน้อย
              filteredData.sort(function(a, b) {
                  return b.user_count - a.user_count;
              });

              // ดึงค่าที่มากที่สุด 10 ตัว
              var top10UserCount = filteredData.slice(0, 10);


              var data = top10UserCount.map(item => ({
                      name: item.province_name,
                      y: item ? parseInt(
                          item
                          .user_count) : 0,
                  })

              );
              Highcharts.chart("graphlearner", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'รวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก'
                  },
                  subtitle: {
                      text: 'รายงานรวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก'
                  },
                  xAxis: {
                      type: 'category'
                  },
                  yAxis: {
                      title: {
                          text: 'รวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก'
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
                      name: 'รวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก',
                      colorByPoint: true,
                      data: data,
                  }]
              });


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

                  // series: [{
                  //     name: 'จำนวน Rating',
                  //     colorByPoint: true,
                  //     data: chartDataFav.map(item => ({
                  //         name: item.choice,
                  //         y: item.count
                  //     }))
                  // }]
              });

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
                      categories: '1',
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
                  // series: [{
                  //     name: 'ebook',
                  //     data: chartDataBook0.map(item => item.count)
                  // }, {
                  //     name: 'เอกสาร',
                  //     data: chartDataBook1.map(item => item.count)
                  // }]


              });

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
                  // series: [{
                  //     name: 'จำนวนค้นหา',
                  //     colorByPoint: true,
                  //     data: chartSearch.map(item => ({
                  //         name: item.choice,
                  //         y: item.count
                  //     }))
                  // }]
              });

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
                      categories: '1',
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


              });
          });
          $('#selectyear').trigger('change');

      });
  </script>
