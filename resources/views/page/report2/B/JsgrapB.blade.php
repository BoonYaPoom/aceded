  <script>
      $(document).ready(function() {
          $('#selectyear').on('change', function() {

              var selectedYear = $('#selectyear').val();
              var TopTenRegis = {!! json_encode($TopTenRegis) !!};
              var TopTenCer = {!! json_encode($TopTenCer) !!};
              var Regiszone = {!! json_encode($regisResults) !!};
              var Cerzone = {!! json_encode($cerReuslts) !!};
              var regisDepResults = {!! json_encode($regisDepResults) !!};
              var cerDepReuslts = {!! json_encode($cerDepReuslts) !!};
              var cerProvincReuslts = {!! json_encode($cerProvincReuslts) !!};
              var regisProvincResults = {!! json_encode($regisProvincResults) !!};

              //graphTopTenRegis
              const StudentsRegisterTopTenget = (selectedYear) => {
                  var filterTopTenRegis = TopTenRegis.filter(data => data.year == selectedYear);
                  filterTopTenRegis.sort((a, b) => b.user_count - a.user_count);
                  var Top10Regis = filterTopTenRegis.slice(0, 10);
                  return Top10Regis;
              };
              var topRegisDataHigh = StudentsRegisterTopTenget(selectedYear);

              //graphRegis
              const LowRegisterTopTenget3 = (selectedYear) => {
                  var filterTopTenRegis3 = TopTenCer.filter(data => data.year == selectedYear);
                  filterTopTenRegis3.sort((a, b) => b.user_count - a.user_count);
                  var Top10Regis3 = filterTopTenRegis3.slice(0, 10);
                  return Top10Regis3;
              };
              var topTenDataHigh = LowRegisterTopTenget3(selectedYear);

              //graphTopTenRegisHigh
              const HighRegisterTopTenget = (selectedYear) => {
                  var filterTopTenRegis2 = TopTenRegis.filter(data => data.year == selectedYear);
                  filterTopTenRegis2.sort((a, b) => a.user_count - b.user_count);
                  const Top10Regis2 = filterTopTenRegis2.slice(0, 10);
                  return Top10Regis2;
              };
              var topRegisDataLow = HighRegisterTopTenget(selectedYear);

              //graphRegisHigh
              const LowRegisterTopTengetHigh = (selectedYear) => {
                  var filterTopTenRegisHigh = TopTenCer.filter(data => data.year == selectedYear);
                  filterTopTenRegisHigh.sort((a, b) => a.user_count - b.user_count);
                  var Top10RegisHigh = filterTopTenRegisHigh.slice(0, 10);
                  return Top10RegisHigh;
              };
              var topTenDataLow = LowRegisterTopTengetHigh(selectedYear);

              const RegisHigh = (selectedYear, typeData) => {
                  let filteredData = [];
                  if (typeData === 1) {
                      Object.keys(Regiszone).forEach(userId => {
                          const user = Regiszone[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname
                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  } else if (typeData === 2) {
                      Object.keys(Cerzone).forEach(userId => {
                          const user = Cerzone[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname
                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  }

                  return filteredData;
              };
              const RegisH = RegisHigh(selectedYear, 1);
              const RegisL = RegisHigh(selectedYear, 2);

              const RegisDepartHigh = (selectedYear, typeData, depart) => {
                  let filteredData = [];

                  if (typeData === 1) {
                      Object.keys(regisDepResults).forEach(userId => {
                          const user = regisDepResults[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear && parseInt(item.department_id) === depart);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname,
                                  department_id: item.department_id,
                                  name_th: item.name_th,
                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  } else if (typeData === 2) {
                      Object.keys(cerDepReuslts).forEach(userId => {
                          const user = cerDepReuslts[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear && parseInt(item.department_id) === depart);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname,
                                  department_id: item.department_id,
                                  name_th: item.name_th,

                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  }
                  return filteredData;
              };

              const RegisZoneDepart = [];
              const CerZoneeDepart = [];
              for (let i = 1; i <= 7; i++) {
                  RegisZoneDepart[i - 1] = RegisDepartHigh(selectedYear, 1, i);
                  CerZoneeDepart[i - 1] = RegisDepartHigh(selectedYear, 2, i);
              }

              const RegisZoneHigh = (selectedYear, typeData, zoneString) => {
                  let filteredData = [];
                  if (typeData === 1) {
                      Object.keys(regisProvincResults).forEach(userId => {
                          const user = regisProvincResults[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear && user.lastname === zoneString);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname,
                                  pro_name: item.pro_name,
                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  } else if (typeData === 2) {
                      Object.keys(cerProvincReuslts).forEach(userId => {
                          const user = cerProvincReuslts[userId];
                          const filteredByYear = user.data.filter(item => item.year ===
                              selectedYear && user.lastname === zoneString);
                          filteredByYear.forEach(item => {
                              filteredData.push({
                                  year: item.year,
                                  user_count: parseInt(item
                                      .total_user_count, 10),
                                  lastname: user.lastname,
                                  pro_name: item.pro_name,

                              });
                          });
                      });
                      filteredData = filteredData.sort((a, b) => b.total_user_count - a
                          .total_user_count);
                  }
                  return filteredData;
              };
              const RegisZoneData = [];
              const CerZoneData = [];

              for (let i = 1; i <= 9; i++) {
                  RegisZoneData[i - 1] = RegisZoneHigh(selectedYear, 1, `ภาค ${i}`);
                  CerZoneData[i - 1] = RegisZoneHigh(selectedYear, 2, `ภาค ${i}`);
              }

              const colors = [
                  '#ffdb57',
                  '#3C0753', 
                  '#236146', 
                  '#7e1b28', 
                  '#8367c7', 
                  '#b38b6d', 
                  '#63126e'
              ];

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
                      data: topRegisDataHigh.map(item => ({
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
                      data: topTenDataHigh.map(item => ({
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
                      data: topRegisDataLow.map(item => ({
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
                      data: topTenDataLow.map(item => ({
                          name: item.pro_name,
                          y: Number(item.user_count),
                          color: '#399918'
                      }))
                  }]
              });
              Highcharts.chart("graphRegisCerHigh", {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      text: 'สถิติเปรียบเทียบผู้สมัครสมาชิกและผู้เรียนจบและได้รับใบประกาศนียบัตร (รวมทุกหลักสูตร)'
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
                          name: 'ผู้สมัครสมาชิก',
                          color: '#4B70F5',
                          data: RegisH.map(item => ({
                              name: item.lastname,
                              y: item.user_count,
                              color: '#4B70F5'
                          })),
                      },
                      {
                          name: 'ผู้เรียนจบได้รับใบประกาศนียบัตร',
                          color: '#758694',
                          data: RegisL.map(item => ({
                              name: item.lastname,
                              y: item.user_count,
                              color: '#758694'
                          })),
                      },
                  ]
              });

              for (let i = 1; i <= 7; i++) {
                  const zoneName = RegisZoneDepart[i - 1].length > 0 ? RegisZoneDepart[i - 1][0].name_th :
                      'Unknown Zone';
                  Highcharts.chart(`graphRegisCerDepart${i}`, {
                      chart: {
                          type: 'column'
                      },
                      title: {
                          text: `สถิติเปรียบเทียบผู้สมัครสมาชิกและผู้เรียนจบและได้รับใบประกาศนียบัตร (${zoneName})`
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
                              name: 'ผู้สมัครสมาชิก',
                            color: colors[i - 1] || '#cccccc', 
                              data: RegisZoneDepart[i - 1].map(item => ({
                                  name: item.lastname,
                                  y: item.user_count,
                               color: colors[i - 1] || '#cccccc', 
                              })),
                          },
                          {
                              name: 'ผู้เรียนจบได้รับใบประกาศนียบัตร',
                              color: '#5EF543',
                              data: CerZoneeDepart[i - 1].map(item => ({
                                  name: item.lastname,
                                  y: item.user_count,
                                  color: '#5EF543'
                              })),
                          },
                      ]
                  });
              }

              for (let i = 1; i <= 9; i++) {
                  Highcharts.chart(`graphRegisCerZone${i}`, {
                      chart: {
                          type: 'column'
                      },
                      title: {
                          text: `สถิติเปรียบเทียบผู้สมัครสมาชิกและผู้เรียนจบ และได้รับใบประกาศนียบัตร ภาค ${i} (รวมทุกหลักสูตร)`
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
                              name: 'ผู้สมัครสมาชิก',
                              color: '#62BAED',
                              data: RegisZoneData[i - 1].map(item => ({
                                  name: item.pro_name,
                                  y: item.user_count,
                                  color: '#62BAED'
                              })),
                          },
                          {
                              name: 'ผู้เรียนจบได้รับใบประกาศนียบัตร',
                              color: '#85E172',
                              data: CerZoneData[i - 1].map(item => ({
                                  name: item.pro_name,
                                  y: item.user_count,
                                  color: '#85E172'
                              })),
                          },
                      ]
                  });
              }
          });
          $('#selectyear').trigger('change');

      });
  </script>
