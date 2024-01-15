  <script>
      var learn = {!! json_encode($learn) !!};

      $(document).ready(function() {
          $('#selectyear').on('change', function() {
              var selectedYear = $('#selectyear').val();
              console.log(selectedYear);

              //กราฟ 1
              var filteredData = learn.filter(function(item) {
                  return item.year === selectedYear;
              });
              filteredData.sort(function(a, b) {
                  return b.user_count - a.user_count;
              });
              var topUsers = filteredData.slice(0, 10);
              console.log(topUsers);



              updateChart(selectedYear, topUsers);
          });


          $('#selectyear').trigger('change');

          function updateChart(selectedYear, topUsers) {
              topUsers.forEach(item => {
                  item.user_count = parseInt(item.user_count);
              });
              Highcharts.chart("graphlearner", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'รวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก'
                  },
                  subtitle: {
                      text: 'รายงานจำนวนผู้เรียนทั้งหมดรวมทุกหลักสูตรรายจังหวัด 10 อันดับแรก'
                  },
                  xAxis: {
                      categories: topUsers.map(item => item.province_name),
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
                      data: topUsers.map(item => item.user_count)
                  }]
              });


              Highcharts.chart("coursemulti", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'หลักสูตรการศึกษาขั้นพื้นฐานผู้เข้าเรียนรายสังกัด( 20 สังกัด ) รวมอาชีวศึกษา '
                  },
                  subtitle: {
                      text: 'หลักสูตรการศึกษาขั้นพื้นฐานผู้เข้าเรียนรายสังกัด( 20 สังกัด ) รวมอาชีวศึกษา '
                  },
                  xAxis: {
                      type: 'category'
                  },
                  yAxis: {
                      title: {
                          text: 'หลักสูตรการศึกษาขั้นพื้นฐานผู้เข้าเรียนรายสังกัด( 20 สังกัด ) รวมอาชีวศึกษา '
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

              // Highcharts.chart("courserating", {
              //     chart: {
              //         type: 'column'
              //     },
              //     title: {
              //         text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
              //     },
              //     subtitle: {
              //         text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
              //     },
              //     xAxis: {
              //         type: 'category'
              //     },
              //     yAxis: {
              //         title: {
              //             text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
              //         }
              //     },
              //     legend: {
              //         enabled: false
              //     },
              //     plotOptions: {
              //         lang: {
              //             thousandsSep: ','
              //         },
              //         series: {
              //             borderWidth: 0,
              //             dataLabels: {
              //                 enabled: true,
              //                 data: '{point.y}'
              //             }
              //         }
              //     },
              //     tooltip: {
              //         headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
              //         pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
              //     },

              //     series: [{
              //         name: 'จำนวน Rating',
              //         colorByPoint: true,
              //         data: chartDataFav.map(item => ({
              //             name: item.choice,
              //             y: item.count
              //         }))
              //     }]
              // });

              // Highcharts.chart("coursedoc", {
              //     chart: {
              //         type: 'column'
              //     },
              //     title: {
              //         text: 'จำนวนเอกสาร, ebook /หลักสูตร'
              //     },
              //     subtitle: {
              //         text: 'จำนวนเอกสาร, ebook /หลักสูตร'
              //     },
              //     xAxis: {
              //         categories: [
              //           
              //         ],
              //         crosshair: true
              //     },
              //     yAxis: {
              //         title: {
              //             text: 'จำนวนเอกสาร, ebook /หลักสูตร'
              //         }
              //     },
              //     legend: {
              //         enabled: true
              //     },
              //     plotOptions: {
              //         lang: {
              //             thousandsSep: ','
              //         },
              //         series: {
              //             borderWidth: 0,
              //             dataLabels: {
              //                 enabled: true,
              //                 data: '{point.y}'
              //             }
              //         }
              //     },
              //     tooltip: {
              //         headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
              //         pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> รายการ<br/>'
              //     },
              //     series: [{
              //         name: 'ebook',
              //         data: chartDataBook0.map(item => item.count)
              //     }, {
              //         name: 'เอกสาร',
              //         data: chartDataBook1.map(item => item.count)
              //     }]


              // });

              // Highcharts.chart("coursesearch", {
              //     chart: {
              //         type: 'column'
              //     },
              //     title: {
              //         text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
              //     },
              //     subtitle: {
              //         text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
              //     },
              //     xAxis: {
              //         type: 'category'
              //     },
              //     yAxis: {
              //         title: {
              //             text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
              //         }
              //     },
              //     legend: {
              //         enabled: false
              //     },
              //     plotOptions: {
              //         lang: {
              //             thousandsSep: ','
              //         },
              //         series: {
              //             borderWidth: 0,
              //             dataLabels: {
              //                 enabled: true,
              //                 data: '{point.y}'
              //             }
              //         }
              //     },
              //     tooltip: {
              //         headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
              //         pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
              //     },
              //     series: [{
              //         name: 'จำนวนค้นหา',
              //         colorByPoint: true,
              //         data: chartSearch.map(item => ({
              //             name: item.choice,
              //             y: item.count
              //         }))
              //     }]
              // });


              // Highcharts.chart("courselogin", {
              //     chart: {
              //         type: 'column'
              //     },
              //     title: {
              //         text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
              //     },
              //     subtitle: {
              //         text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
              //     },
              //     xAxis: {
              //         categories: dateAll,
              //         crosshair: true
              //     },
              //     yAxis: {
              //         title: {
              //             text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
              //         }
              //     },
              //     legend: {
              //         enabled: false,

              //     },
              //     plotOptions: {
              //         lang: {
              //             thousandsSep: ',',

              //         },
              //         series: {
              //             borderWidth: 0,
              //             dataLabels: {
              //                 enabled: true,
              //                 data: '{point.y}'
              //             }
              //         }
              //     },
              //     tooltip: {
              //         headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
              //         pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> ครั้ง<br/>'
              //     },
              //     series: chartLog

              // }); 
          }
      });
  </script>
