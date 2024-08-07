

    <table border="1" style="width:100%" id="section-to-print">
        <!-- thead -->
        <thead>
            <tr>
                <th class="text-center" colspan="6">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร
                </th>
            </tr>
            <tr class="text-center">
                <th align="center" width="5%">ลำดับ</th>
                <th align="center" width="20%">ชื่อผู้ใช้งาน</th>
                <th align="center" width="30%">ชื่อ - สกุล</th>

                <th align="center">หลักสูตร</th>
                <th align="center" width="10%">วันที่ลงทะเบียนเรียน</th>
                <th align="center" width="10%">วันที่จบหลักสูตร</th>
            </tr>



            <!-- tr --> @php
                $n = 1;
                $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                $uniqueUserIds = [];
                $users = null;
            @endphp
            @foreach ($learners as $l => $learns)
                @php
                    $dataLearn = $learns->registerdate;
                    $congrateLearn = $learns->congratulationdate;
                    $congrate = $learns->congratulation;
                    $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                    $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                    $users = \App\Models\Users::find($learns->user_id);

                    $courses = \App\Models\Course::find($learns->course_id);

                    if ($courses) {
                        // Access properties of the $courses object here
                        $course_th = $courses->course_th;
                        // ...
                    } else {
                    }
                    $carbonDate = \Carbon\Carbon::parse($congrateLearn);
                    $thaiDate = $carbonDate->locale('th')->isoFormat('D MMMM');
                    $buddhistYear = $carbonDate->addYears(543)->year;
                    $thaiYear = $buddhistYear > 0 ? $buddhistYear : '';
                    $thaiDateWithYear = $thaiDate . ' ' . $thaiYear;

                    $carbonDa = \Carbon\Carbon::parse($dataLearn);
                    $thaiDa = $carbonDa->locale('th')->isoFormat('D MMMM');
                    $buddhistYe = $carbonDa->addYears(543)->year;
                    $thai = $buddhistYe > 0 ? $buddhistYe : '';
                    $thaiDat = $thaiDa . ' ' . $thai;

                @endphp

                @if (isset($users) && $users)
                    <tr>
                        <td align="center">{{ $n++ }}</td>

                        <td>
                            @if (optional($users)->username)
                                {{ $users->username }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if (optional($users)->firstname)
                                {{ $users->firstname }}
                            @else
                            @endif
                            @if (optional($users)->lastname)
                                {{ $users->lastname }}
                            @else
                            @endif
                        </td>

                        <td>
                            @if (optional($courses)->course_th)
                                {{ $courses->course_th }}
                            @else
                            @endif
                        </td>
                        <td align="center">
                            @if ($thaiDat)
                                {{ $thaiDat }}
                            @else
                            @endif
                        </td>
                        <td align="center">
                            @if ($congrate == 1)
                                {{ $thaiDateWithYear }}
                            @elseif($congrate == 0)
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody><!-- /tbody -->
    </table><!-- /.table -->

