@extends('page.manage.sub.navsubject')
@section('subject-data')
    <form action="{{ route('update_supplyform', [$depart, $subs, 'supplymentary_id' => $supplys]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <!-- .form-group -->
            <div class="form-group">

                <label class="control-label" for="supplymentary_type">ชนิดสื่อ</label>

                <select id="supplymentary_type" name="supplymentary_type" class="form-control" data-toggle="select2"
                    data-placeholder="ชนิดสื่อ" data-allow-clear="false">
                    <option value="0">เลือกชนิดสื่อ</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->supplymentary_type }}"
                            {{ $type->supplymentary_type == $supplys->supplymentary_type ? 'selected' : '' }}>
                            {{ $type->content_th }}</option>
                    @endforeach
                </select>
            </div><!-- /.form-group -->
            <script>
                $(document).ready(function() {
                    $('#supplymentary_type').change(function() {
                        var selectedValue = $(this).val();

                        $('#data1, #data2, #data3, #data4, #data5, #data6').hide();

                        switch (selectedValue) {
                            case '2':
                                $('#data1').show();
                                break;

                            case '3':
                                $('#data4').show();
                                break;
                            case '4':
                                $('#data3').show();
                                break;
                            case '5':
                                $('#data2').show();
                                $('#data6').show();
                                break;

                            case '6':
                                $('#data5').show();
                                break;
                        }
                    });

                });
            </script>





            <div id="data2" style="{{ $supplys->supplymentary_type == 5 ? 'display: block;' : 'display: none;' }}">
                <div class="form-group digitallibrary ">
                    <a class="btn btn-lg " style="background-color: {{ $depart->color }};" href="#clientDigitalLibrryModal"
                        data-toggle="modal"><i class="fas fa-book"></i>
                        เลือกจากคลังสื่อ</a>
                </div><!-- /.form-group -->
            </div>

            <div class="form-group">
                <label for="title_th">ชื่อสื่อ (ไทย) <span class="badge badge-warning">Required</span></label>
                <input type="text" class="form-control" id="title_th" name="title_th" placeholder="ชื่อสื่อ (ไทย)"
                    required="" value="{{ $supplys->title_th }}">
            </div><!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
                <label for="title_en">ชื่อสื่อ (อังกฤษ) </label> <input type="text" class="form-control" id="title_en"
                    name="title_en" placeholder="ชื่อสื่อ (อังกฤษ)" value="{{ $supplys->title_en }}">
            </div><!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
                <label for="group_en">สถานะ </label> <label
                    class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                        class="switcher-input" name="supplymentary_status" id="supplymentary_status"
                        value="{{ $supplys->supplymentary_status }}">
                    <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                        class="switcher-label-off text-red">OFF</span></label>
            </div><!-- /.form-group -->


            <div id="data2" style="{{ $supplys->supplymentary_type == 5 ? 'display: block;' : 'display: none;' }}">

                <div class="form-group library digitallibrary">
                    <label for="group_en">ชื่อผู้แต่ง</label>
                    <input type="text" name="author" id="author" class="form-control"
                        value="{{ $supplys->author }}">
                </div><!-- /.form-group -->
                <div class="form-group library digitallibrary link">
                    <label for="cover">เชื่อมโยง</label>
                    <input type="text" name="cover" id="cover" class="form-control"
                        value="{{ $supplys->cover_image }}">
                </div>
            </div>
            <div id="data1" style="{{ $supplys->supplymentary_type == 2 ? 'display: block;' : 'display: none;' }}">

                <div class="form-group selectfile">

                    <label for="path">เลือกไฟล์ </label> <input type="file" name="path" id="path"
                        class="form-control" accept=".pdf">
                </div>
                <span class="badge " style="background-color: {{ $depart->color }};">{{ $supplys->path }}</span>
            </div>
            <div id="data4" style="{{ $supplys->supplymentary_type == 3 ? 'display: block;' : 'display: none;' }}">

                <div class="form-group selectfile">


                    <label for="path">เลือกไฟล์ </label> <input type="file" name="path" id="path"
                        class="form-control" accept="image/x-png,image/gif,image/jpeg,video/mp4">

                </div>
                <span class="badge " style="background-color: {{ $depart->color }};">{{ $supplys->path }}</span>
            </div>
            <div id="data6" style="{{ $supplys->supplymentary_type == 6 ? 'display: block;' : 'display: none;' }}">

                <div class="form-group selectfile">

                    <label for="path">เลือกไฟล์ </label> <input type="file" name="path" id="path"
                        class="form-control" accept=".pdf,.docx,.doc,.pptx,.ppt,.ppsx,.xls,.xlsx">
                </div>
                <span class="badge " style="background-color: {{ $depart->color }};">{{ $supplys->path }}</span>
            </div>
            <input type="hidden" name="book_id" id="book_id" value="">




            <div id="data3" style="{{ $supplys->supplymentary_type == 4 ? 'display: block;' : 'display: none;' }}">


                <div class="form-group library digitallibrary link">
                    <label for="cover">เชื่อมโยง</label>
                    <input type="text" name="cover" id="cover" class="form-control"
                        value="{{ $supplys->cover_image }}">
                </div>

            </div>

            <div class="form-actions ">

                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div>

        </div>

        </div><!-- /.card-body -->


    </form>

    <div class="modal fade" id="clientDigitalLibrryModal" tabindex="-1" user_role="dialog"
        aria-labelledby="clientDigitalLibrryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" user_role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: {{ $depart->color }};">
                    <h6 class="modal-title inline-editable">
                        <span class="sr-only">Digital Library</span> เลือกจากคลังสื่อ
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <!-- เนื้อหาภายในโมดัล -->
                    <div class="table-responsive">
                        <table class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width: 10%">ลำดับ</th>
                                    <th class="align-middle" style="width: 40%">ชื่อสื่อ</th>
                                    <th class="align-middle" style="width: 40%">ชื่อผู้แต่ง</th>
                                    <th class="align-middle" style="width: 10%">เลือก</th>
                                </tr>
                            </thead>
                            <!-- tbody -->
                            <tbody class="showbook">
                                @php
                                    $BB = 1;
                                @endphp
                                @foreach ($bookcats as $bookcat)
                                    @foreach ($bookcat->books as $book)
                                        <tr>
                                            <td class="align-middle" style="width: 10%">{{ $BB++ }}</td>
                                            <td class="align-middle" style="width: 40%">{{ $book->book_name }}</td>
                                            <td class="align-middle" style="width: 40%">{{ $book->book_author }}</td>
                                            <td class="align-middle" style="width: 10%">
                                                <a href="javascript:"
                                                    onclick="selectbook('{{ $book->book_name }}', '{{ $book->book_author }}', '{{ $book->cover }}', '{{ route('book.table', $book->book_id) }}', '{{ $book->book_id }}')">

                                                    <i class="fas fa-book fa-lg text-success" id="book1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="cancelButton">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function selectbook(book_name, book_author, cover, book_id) {
            // Handle the selected book here
            console.log('Selected Book:');
            console.log('book_name:', book_name);
            console.log('book_author:', book_author);
            console.log('cover:', cover);
            console.log('book_id :', book_id);

            // Set the field values
            $('#title_th').val(book_name);
            $('#title_en').val(book_name);
            $('#author').val(book_author);
            $('#cover').val(cover);
            $('#book_id').val(book_id);
            $('#clientDigitalLibrryModal').modal('hide');


        }
    </script>
@endsection
