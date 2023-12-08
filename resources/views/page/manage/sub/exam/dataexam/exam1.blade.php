
<div class="table-responsive">
    <!-- .table -->
    <table id="datatable1" class="table w3-hoverable">
        <!-- thead -->
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width:10%"> ลำดับ </th>
                <th class="align-middle" style="width:70%"> รายการคลัง แบบฝึกหัด/แบบทดสอบ </th>
                <th class="align-middle" style="width:10%"> สถานะ </th>
                <th class="align-middle" style="width:10%"> กระทำ </th>
            </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody>
       
      
            <tr>
                <td><a href="#">1</a></td>
                <td><a>คลังแบบฝึกหัด</a></td>
                <td></td>
                <td>
                    <a href="{{ route('pagequess3', [$depart, $subs->subject_id]) }}"><i
                            class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                            title="เพิ่มแบบฝึกหัด"></i></a>
                    <a href="{{ route('questionadd3', [$depart, $subs->subject_id]) }}"><i
                            class="fas fa-file-alt fa-lg  text-danger" data-toggle="tooltip"
                            title="เพิ่มไฟล์แบบฝึกหัด"></i></a>
                </td>
            </tr>
            <tr>
                <td><a href="#">2</a></td>
                <td><a>คลังแบบทดสอบ</a></td>
                <td></td>
                <td>
                    <a href="{{ route('pagequess', [$depart, $subs->subject_id]) }}"><i
                            class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                            title="เพิ่มแบบทดสอบ"></i></a>
                    <a href="{{ route('questionadd', [$depart, $subs->subject_id]) }}"><i
                            class="fas fa-file-alt fa-lg  text-danger" data-toggle="tooltip"
                            title="เพิ่มไฟล์แบบทดสอบ"></i></a>
                </td>
            </tr>
        </tbody><!-- /tbody -->
    </table><!-- /.table -->
</div><!-- /.table-responsive -->
