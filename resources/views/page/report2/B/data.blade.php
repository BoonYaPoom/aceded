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
</script>