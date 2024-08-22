  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();

              //graphlearner
   
              var filteredData = learn.filter((data) => data.year == selectedYear);
              // เรียงลำดับข้อมูลตาม user_count จากมากไปน้อย
              filteredData.sort((a, b) => b.user_count - a.user_count);

              // ดึงค่าที่มากที่สุด 10 ตัว
              var top10UserCount = filteredData.slice(0, 10);
              var data = top10UserCount.map(item => ({
                  name: item.province_name,
                  y: item ? parseInt(
                      item
                      .user_count) : 0,
              }));
              
              //courserating
              var organ = {!! json_encode($organization) !!};
              var filteredOrgan = organ.filter((data) => data.year == selectedYear);
              filteredOrgan.sort((a, b) => b.user_count - a.user_count);
              var top10Organ = filteredOrgan.slice(0, 10);
              var OrganData = top10Organ.map(item => ({
                  name: item.exten_name,
                  y: item ? parseInt(
                      item
                      .user_count) : 0,
              }));

              //courselogin
              var aff = {!! json_encode($aff) !!}
              var fileAff = aff.filter((data) => data.year == selectedYear)
              fileAff.sort((a, b) => b.user_count - a.user_count)
              var top10Aff = fileAff.slice(0, 10)
              var AffData = top10Aff.map(item => ({
                  name: item.aff_name,
                  y: item ? parseInt(
                      item
                      .user_count) : 0,
              }))


              //   var organi4 = {!! json_encode($organi4) !!}
              //   var fileorgani4 = organi4.filter((data) => data.year == selectedYear)
              //   fileorgani4.sort((a, b) => b.user_count - a.user_count)
              //   var top10organi4 = fileorgani4.slice(0, 10)
              //   var organi4Data = top10organi4.map(item => ({
              //       name: item.aff_name,
              //       y: item ? parseInt(
              //           item
              //           .user_count) : 0,
              //   }))


              console.log(data);
              console.log(OrganData);
              console.log(AffData);
              //   console.log(organi4Data);



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

              
                    Highcharts.chart("courserating", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'หลักสูตรการศึกษาระดับอุดมศึกษาผู้เข้าเรียนรายสถาบันระดับอุดมศึกษา 10 อันดับแรก'
                  },
                  subtitle: {
                      text: 'หลักสูตรการศึกษาระดับอุดมศึกษาผู้เข้าเรียนรายสถาบันระดับอุดมศึกษา 10 อันดับแรก'
                  },
                  xAxis: {
                      type: 'category'
                  },
                  yAxis: {
                      title: {
                          text: 'หลักสูตรการศึกษาระดับอุดมศึกษาผู้เข้าเรียนรายสถาบันระดับอุดมศึกษา 10 อันดับแรก'
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
                      data: OrganData,
                  }]

              });
              
              Highcharts.chart("courselogin", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'สถิติผู้เข้าเรียนหลักสูตรเจ้าหน้าที่รัฐระดับกระทรวง 10 อันดับแรก'
                  },
                  subtitle: {
                      text: 'สถิติผู้เข้าเรียนหลักสูตรเจ้าหน้าที่รัฐระดับกระทรวง 10 อันดับแรก'
                  },
                  xAxis: {
                      type: 'category'
                  },
                  yAxis: {
                      title: {
                          text: 'สถิติผู้เข้าเรียนหลักสูตรเจ้าหน้าที่รัฐระดับกระทรวง 10 อันดับแรก'
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
                      name: 'สถิติผู้เข้าเรียนหลักสูตรเจ้าหน้าที่รัฐระดับกระทรวง 10 อันดับแรก',
                      colorByPoint: true,
                      data: AffData,
                  }]

              });


          });
          $('#selectyear').trigger('change');

      });
  </script>
