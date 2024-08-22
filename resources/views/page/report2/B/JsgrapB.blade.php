  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();
              var TopTenRegis = {!! json_encode($TopTenRegis) !!};
              var TopTenCer = {!! json_encode($TopTenCer) !!};

              //graphTopTenRegis
              const StudentsRegisterTopTenget = (selectedYear) => {
                  var filterTopTenRegis = TopTenRegis.filter(data => data.year == selectedYear);
                  filterTopTenRegis.sort((a, b) => b.user_count - a.user_count);
                  var Top10Regis = filterTopTenRegis.slice(0, 10);
                  return Top10Regis;
              };
              var topTenData = StudentsRegisterTopTenget(selectedYear);
              
              //graphRegis
              const LowRegisterTopTenget3 = (selectedYear) => {
                  var filterTopTenRegis3 = TopTenCer.filter(data => data.year == selectedYear);
                  filterTopTenRegis3.sort((b, a) => a.user_count - b.user_count);
                  var Top10Regis3 = filterTopTenRegis3.slice(0, 10);
                  return Top10Regis3;
              };
              var topTenDataLow = LowRegisterTopTenget3(selectedYear);

              //graphTopTenRegisHigh
              const HighRegisterTopTenget = (selectedYear) => {
                  var filterTopTenRegis2 = TopTenRegis.filter(data => data.year == selectedYear);
                  filterTopTenRegis2.sort((a, b) => a.user_count - b.user_count);

                  const Top10Regis2 = filterTopTenRegis2.slice(0, 10);

                  return Top10Regis2;
              };
              var topTenDataHigh = HighRegisterTopTenget(selectedYear);

              //graphRegisHigh
              const LowRegisterTopTengetHigh = (selectedYear) => {
                  var filterTopTenRegisHigh = TopTenCer.filter(data => data.year == selectedYear);
                  filterTopTenRegisHigh.sort((a, b) => a.user_count - b.user_count);
                  var Top10RegisHigh = filterTopTenRegisHigh.slice(0, 10);
                  return Top10RegisHigh;
              };
              var topTenDataHigh = LowRegisterTopTengetHigh(selectedYear);

              Highcharts.chart("graphTopTenRegis", {
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
                      enabled: true,
                      labelFormatter: function() {
                          return 'จังหวัด';
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
                      name: 'จังหวัด',
                      color: '#4B70F5',
                      data: topTenData.map(item => ({
                          name: item.pro_name,
                          y: Number(item.user_count),
                          color: '#4B70F5'
                      }))
                  }]
              });

              Highcharts.chart("graphRegis", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: '10 อันดับผู้เรียนจบและได้รับใบประกาศนียบัตรสูงสุด (รวมทุกหลักสูตร)'
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
                      enabled: true,
                      labelFormatter: function() {
                          return 'จังหวัด';
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
                      name: 'จังหวัด',
                      color: '#399918',
                      data: topTenDataLow.map(item => ({
                          name: item.pro_name,
                          y: Number(item.user_count),
                          color: '#399918'
                      }))
                  }]
              });
              Highcharts.chart("graphTopTenRegisHigh", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: '10 อันดับผู้สมัครสมาชิกต่ำสุด (รวมทุกหลักสูตร)'
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
                      enabled: true,
                      labelFormatter: function() {
                          return 'จังหวัด';
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
                      name: 'จังหวัด',
                      color: '#4B70F5',
                      data: topTenDataHigh.map(item => ({
                          name: item.pro_name,
                          y: Number(item.user_count),
                          color: '#4B70F5'
                      }))
                  }]
              });
              Highcharts.chart("graphRegisHigh", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: '10 อันดับผู้เรียนจบและได้รับใบประกาศนียบัตรต่ำสุด (รวมทุกหลักสูตร)'
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
                      enabled: true,
                      labelFormatter: function() {
                          return 'จังหวัด';
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
                      name: 'จังหวัด',
                      color: '#399918',
                      data: topTenDataHigh.map(item => ({
                          name: item.pro_name,
                          y: Number(item.user_count),
                          color: '#399918'
                      }))
                  }]
              });

          });
          $('#selectyear').trigger('change');

      });
  </script>
