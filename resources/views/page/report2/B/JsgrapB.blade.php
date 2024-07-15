  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();
              var TopTenRegis = {!! json_encode($TopTenRegis) !!};
              const StudentsRegisterTopTenget = (selectedYear) => {
                  var filterTopTenRegis = TopTenRegis.filter(data => data.year == selectedYear);
                  filterTopTenRegis.sort((a, b) => b.user_count - a.user_count);
                  var Top10Regis = filterTopTenRegis.slice(0, 10);
                  return Top10Regis;
              };
              var topTenData = StudentsRegisterTopTenget(selectedYear);

              console.log(topTenData);
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
                      data: topTenData.map(item => ({
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
