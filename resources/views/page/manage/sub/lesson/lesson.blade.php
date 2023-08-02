@extends('page.manage.sub.navsubject')
@section('subject-data')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',
            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif
    <div class="card-body">
        <!-- .table-responsive -->
        <div class="table-responsive ">
            <!-- .table -->
            <table id="datatable" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:10%"> ลำดับ </th>
                        <th class="align-middle" style="width:25%"> ชื่อ (ไทย) </th>
                        <th class="align-middle w3-hide-small" style="width:25%"> ชื่อ (อังกฤษ) </th>
                        <th class="align-middle" style="width:10%"> ชนิดสื่อ </th>
                        <th class="align-middle" style="width:10%"> สถานะ </th>
                        <th class="align-middle" style="width:10%"> กระทำ</th>
                    </tr>
                </thead>
                <!-- tbody -->
                <tbody>
                    @php
                        $level = 0;
                        
                    @endphp

                    @foreach ($lessons as $index => $item)
                        @php
                            $lesson_id = $item->lesson_id;
                            
                            if (empty($level)) {
                                $sublesson = '';
                            } else {
                                $sublesson = 'small';
                            }
                            $level++;
                        @endphp
                        @php
                            $contentType = \App\Models\ContentType::where('content_type', $item->content_type)->first();
                        @endphp
                        <!--  Lessons -->

                        @php
                            $left = 0;
                        @endphp

                        <!--  Model -->
                        @if ($item->lesson_id_ref == 0)
                            @include('page.manage.sub.lesson.item.itemLesson')
                            <!--  Model -->
                            @include('page.manage.sub.lesson.item.modelLesson')
                        @endif

                        <!--  Lessons Small -->
                        @php
                            $left += $level + 5;
                        @endphp
                        @foreach ($lessons as $subitem)
                            @if ($subitem->lesson_status == 2 && $subitem->lesson_id_ref === $item->lesson_id)
                                @include('page.manage.sub.lesson.item.subitem')

                                <!--  Model -->
                                @include('page.manage.sub.lesson.item.modelLessonSmall')
                            @endif
                        @endforeach
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->

    <script>
        function togglerows(id) {
            $(".rows_" + id).toggle();
            var obj1 = document.getElementById("icon1_" + id);
            var obj2 = document.getElementById("icon2_" + id);
            //obj.classList.add('MyClass');
            //document.getElementById("MyElement").classList.remove('MyClass');
            //if ( document.getElementById("MyElement").classList.contains('MyClass') )
            if (obj1.classList.contains('fa-plus-circle')) {
                obj1.classList.remove('fa-plus-circle');
                obj1.classList.add('fa-minus-circle');
                obj2.classList.remove('fa-plus-circle');
                obj2.classList.add('fa-minus-circle');
            } else {
                obj1.classList.remove('fa-minus-circle');
                obj1.classList.add('fa-plus-circle');
                obj2.classList.remove('fa-minus-circle');
                obj2.classList.add('fa-plus-circle');
            }
            if (id > 0) {
                var tdElement = obj2.parent(); // Get the parent td element
                var currentPadding = parseInt(tdElement.css("padding-left"), 10); // Get the current padding-left value
                var newPadding = Math.max(currentPadding - 25, 0); // Calculate the new padding value (minimum 0)
                tdElement.css("padding-left", newPadding + "px"); // Set the new padding value
            }
        }
    </script>

    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <!-- floating action -->
        <input type="hidden" name="__id" />
        <button type="button" onclick="window.location='{{ route('add_lessonform', ['subject_id' => $subs]) }}'"
            class="btn btn-success btn-floated btn-add" data-toggle="tooltip" title="เพิ่ม"><span
                class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
@endsection
