  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();


              Highcharts.chart("graphCer", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: '10 อันดับผู้สมัครสมาชิกสูงสุด (รวมทุกหลักสูตร)'
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
                  legend: {
                      enabled: false,
                      labelFormatter: function() {
                          return 'ข้อมูลจากกรมการศึกษา'; // ข้อความที่ต้องการแสดงแทนสัญลักษณ์
                      }
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
                      data: [{
                          name: 'ระดับปฐมวัย',
                          y: 20,
                          color: '#4B70F5'
                      }, {
                          name: 'ระดับปฐมศึกษา',
                          y: 30,
                          color: '#4B70F5'
                      }, {
                          name: 'ระดับมัธยมศึกษา',
                          y: 25,
                          color: '#4B70F5'
                      }, {
                          name: 'ระดับอาชีวศึกษา',
                          y: 25,
                          color: '#4B70F5'
                      }, {
                          name: 'ระดับอุดมศึกษา',
                          y: 5,
                          color: '#4B70F5'
                      }, {
                          name: 'ภาครัฐวิสาหกิจ',
                          y: 35,
                          color: '#4B70F5'
                      }, {
                          name: 'ประชาชนทั่วไป',
                          y: 15,
                          color: '#4B70F5'
                      }]
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
                          name: 'ผู้สมัครสมาชิค',
                          color: '#4B70F5',
                          data: [{
                              name: '2566',
                              y: 20,
                              color: '#4B70F5'
                          }, {
                              name: '2567',
                              y: 10,
                              color: '#4B70F5'
                          }, {
                              name: '2568',
                              y: 50,
                              color: '#4B70F5'
                          }],
                      },
                      {
                          name: 'ผู้เรียนจบ',
                          color: '#FF7F3E',
                          data: [{
                              name: '2566',
                              y: 10,
                              color: '#FF7F3E'
                          }, {
                              name: '2567',
                              y: 20,
                              color: '#FF7F3E'
                          }, {
                              name: '2568',
                              y: 4,
                              color: '#FF7F3E'
                          }],
                      },
                      {
                          name: 'ผู้ลงทะเบียนเรียน',
                          color: '#758694',
                          data: [{
                              name: '2566',
                              y: 2,
                              color: '#758694'
                          }, {
                              name: '2567',
                              y: 20,
                              color: '#758694'
                          }, {
                              name: '2568',
                              y: 30,
                              color: '#758694'
                          }],
                      }
                  ]
              });

          });
          $('#selectyear').trigger('change');

      });
  </script>
