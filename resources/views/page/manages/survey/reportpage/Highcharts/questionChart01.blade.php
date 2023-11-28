<td>
    {!! $item->question !!}
</td>
<td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
</td>
</tr>
<tr>
</tr>
<tr>
    <td colspan="2" class="text-left" align="left">
        <div id="pie_4{{ $item->question_id }}"></div>
    </td>
    <td>
        <table>
            <tbody>
                @php
                    $chartData = [];
                    $newqures = $item->question;
                @endphp
                @for ($i = 1; $i <= 8; $i++)
                    @if (isset($item->{'choice' . $i}))
                        <tr>
                            <td></td>
                            @php
                                $totalPeople = 0; // เก็บจำนวนคนทั้งหมดที่แสดง

                            @endphp
                            @foreach ($respoe as $reitem)
                                @php
                                    $itemrespon = $reitem->response;
                                    $jsonRespon = json_decode($itemrespon, true);
                                    $dataRespon = collect($jsonRespon);
                                    $datajson = isset($dataRespon[$item->question_id]) ? json_decode($dataRespon[$item->question_id], true) : null;

                                @endphp
                                @if (isset($datajson) && $datajson == $i)
                                    @php
                                        $totalPeople += 1; // เพิ่มจำนวนคนที่แสดงลงใน $totalPeople

                                    @endphp
                                @endif
                            @endforeach

                            <td>{{ $item->{'choice' . $i} }}</td>

                            <td>
                                จำนวน

                                @if ($totalPeople > 0)
                                    {{ $totalPeople }}
                                @else
                                    0
                                @endif
                                คน
                            </td>
                            @php
                                $totalPeoplePercent = 0;
                                if (count($respoe) > 0) {
                                    $totalPeoplePercent = ($totalPeople / count($respoe)) * 100;
                                }
                                $chartData[] = [
                                    'choice' => $item->{'choice' . $i},
                                    'count' => $totalPeople,
                                ];
                            @endphp

                            <td>ร้อยละ @if ($totalPeoplePercent > 0)
                                    {{ number_format($totalPeoplePercent) }}
                                @else
                                    0
                                @endif %</td>
                        </tr>
                        <script>
                            var question = {!! json_encode(html_entity_decode(strip_tags($item->question))) !!};
                            var chartData = {!! json_encode($chartData) !!};

                            Highcharts.chart("pie_4{{ $item->question_id }}", {
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: question
                                },
                                tooltip: {
                                    pointFormat: '{point.name}'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        showInLegend: true,
                                        dataLabels: {
                                            enabled: false,
                                            format: '{point.name}',
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                            }
                                        }
                                    }
                                },
                                series: [{
                                    name: 'จำนวน',
                                    colorByPoint: true,
                                    data: chartData.map(item => ({
                                        name: item.choice,
                                        y: item.count
                                    }))
                                }]

                            });
                        </script>
                    @endif
                @endfor
            </tbody>
        </table>
    </td>
</tr>
