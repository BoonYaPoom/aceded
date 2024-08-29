<div class="table-responsive">
    <table id="datatable" class="table w3-hoverable">
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width: 10%">
                    <input type="checkbox" name="checkall" id="checkall">
                </th>
                <th class="align-middle" style="width:10%"> หมายเลข </th>
                <th class="align-middle" style="width:40%"> ชื่อ </th>
                <th class="align-middle" style="width:10%"> ข้อมูลการย้าย </th>
                <th class="align-middle" style="width:5%"> กระทำ </th>
            </tr>
        </thead>
        <tbody>

            @php
                $displayedIds = [];
                $i = 1;
            @endphp
            @foreach ($claimuser as $c)
                @if ($c->claim_user_id > 0)
                    @php
                        $users2 = \App\Models\Users::where('user_id', $c->claim_user_id)->first();
                    @endphp
                    @if ($users2)
                        <tr>
                            <td class="align-middle" style="width: 10%">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="user_data[]"
                                        id="user_data{{ $c->claim_user_id }}" value="{{ $c->claim_user_id }}">
                                    <label class="custom-control-label" for="user_data{{ $c->claim_user_id }}"></label>
                            </td>
                            <td>{{ $c->claim_user_id }} </td>
                            <td>{{ $users2->firstname }} {{ $users2->lastname }}</td>
                            <td><i class="fa fas fa-eye text-success pointer" style="cursor:pointer" id="icon1"
                                    onclick="showModal('{{ $c->claim_user_id }}')"></i>
                                @include(
                                    'layouts.department.item.data.request.CerAndDepart.item.modeleditDpart',
                                    [
                                        'claimUserId' => $c->claim_user_id,
                                    ]
                                )
                            </td>
                            <td>
                                <a href="{{ route('updateuserdeyes', $c->claim_user_id) }}"
                                    onclick="updateceryes(event)"><i class="fas fa-check fa-lg text-success"
                                        data-toggle="tooltip" title="อนุมัติผ่าน"></i></a>
                                <a href="{{ route('updateuserdeno', $c->claim_user_id) }}"
                                    onclick="updatecerno(event)"><i class="fas fa-times fa-lg text-danger"
                                        data-toggle="tooltip" title="อนุมัติไม่ผ่าน"></i></a>
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach



        </tbody>
    </table>

</div>
<div class="d-flex justify-content-end align-center ">
    <button type="button" id="action-buttons" class="btn btn-primary mr-2">
        <p>ยืนยันที่เลือก</p>
    </button>
</div>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            lengthChange: false,
            responsive: true,
            info: true,
            scrollY: 400,
            paging: false,
            scrollCollapse: true,
            language: {
                info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "ไม่พบรายการ",
                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    previous: "ก่อนหน้า",
                    next: "ถัดไป"
                }
            },
        });
        let counterCheck = 0
        let counterTotal = 0

        function getCheckedValues() {
            let checkedValues = $('.custom-control-input:checked').map(function() {
                return $(this).val();
            }).get();
            $('#loadingSpinner1').show();
            if (checkedValues.length === 0) {
                return Promise.resolve(
                    []);
            }
            return $.ajax({
                type: 'POST',
                url: '/admin/req/get-claim-allup',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    datauser: checkedValues
                },
                success: function(res) {
                       $('#loadingSpinner1').hide();
                    console.log('Response:', res);
                },
                error: function(xhr, status, error) {
                       $('#loadingSpinner1').hide();
                    console.error('Error:', error);
                }
            });
        }


        function updateCheckedValues() {
            let checkedValues = $('.custom-control-input:checked').map(function() {
                counterTotal = $('.custom-control-input:checked').length
                return $(this).val();
            }).get();

            if (checkedValues.length === 0) {
                $('#loadingSpinner').hide();
                return [];
            }
            $('#loadingSpinner').show().find(`#couter`).text('0/' + counterTotal + ' รายการ');
            let promises = checkedValues.map(value => {
                return $.ajax({
                    type: 'GET',
                    url: '/admin/req/get-claim-data/' + value
                }).then(data => {
                    counterCheck++;
                    if (data.claimData.length !== 7) {
                        return {
                            value: value,
                            valid: false
                        };
                    }
                    $('#loadingSpinner #couter').text(counterCheck + '/' + counterTotal);
                    return {
                        value: value,
                        valid: true
                    };
                }).catch(() => {
                    console.log('Failed API');
                    return {
                        value: value,
                        valid: false
                    };
                });
            });

            return Promise.all(promises).finally(() => {
                $('#loadingSpinner').hide();
            }).then(results => {
                let validValues = [];
                let invalidValues = [];

                results.forEach(result => {
                    if (result.valid) {
                        validValues.push(result.value);
                    } else {
                        invalidValues.push(result.value);
                    }
                });
                if (invalidValues.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ข้อมูลไม่ครบถ้วน',
                        html: `ข้อมูลในระบบไม่ครบ 7 รายการ โปรดตรวจสอบ<br>${invalidValues.map(value => `หมายเลข: ${value}`).join('<br>')}`,
                        confirmButtonText: 'ตกลง'
                    });
                    $('.custom-control-input').each(function() {
                        if (invalidValues.includes($(this).val())) {
                            $(this).prop('checked', false);
                        }
                    });
                }

                return validValues;
            });
        }
        $("#action-buttons").click(function() {
            getCheckedValues().then(response => {

                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'ข้อมูลถูกส่งเรียบร้อยแล้ว',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    $('#loadingSpinner1').hide();
                    window.location.reload();
                });
                console.log('Response: ', response);
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง',
                    confirmButtonText: 'ตกลง'
                });
                console.error('Error: ', error);
                $('#loadingSpinner1').hide();
            });
        });

        $("#checkall").click(function() {
            $('.custom-control-input').prop('checked', $(this).prop('checked'));
            updateCheckedValues();
        });

        $('.custom-control-input').click(function() {
            updateCheckedValues();
        });
    });
</script>
