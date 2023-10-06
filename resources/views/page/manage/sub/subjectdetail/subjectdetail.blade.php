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


    <form action="{{ route('updatedetailsub', ['subject_id' => $subs->subject_id]) }}" method="post"
      enctype="multipart/form-data">
      @csrf
      @method('PUT')
    <div class="card-body">
        <!-- .form-group -->
        <div class="form-group">
            <label for="description_th">คำอธิบายวิชา (ไทย)</label>
            <textarea class="editor" data-placeholder="คำอธิบายวิชา" data-height="200" name="description_th">
                  {{$subs->description_th}}

            </textarea>
        </div><!-- /.form-group -->
        <div class="form-group">
            <label for="description_en">คำอธิบายวิชา (อังกฤษ)</label>
            <textarea class="editor" data-placeholder="คำอธิบายวิชา" data-height="200" name="description_en">
              {{$subs->description_en}}

            </textarea>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
            <label for="objectives_th">วัตถุประสงค์การเรียนรู้ (ไทย)</label>
            <textarea class="editor" data-placeholder="วัตถุประสงค์การเรียนรู้" data-height="200" name="objectives_th">

              {{$subs->objectives_th}}
            </textarea>
        </div><!-- /.form-group -->
        <div class="form-group">
            <label for="objectives_en">วัตถุประสงค์การเรียนรู้ (อังกฤษ)</label>
            <textarea class="editor" data-placeholder="วัตถุประสงค์การเรียนรู้" data-height="200" name="objectives_en">
              {{$subs->objectives_en}}

            </textarea>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
            <label for="evaluation_th">การประเมินผล (ไทย)</label>
            <textarea class="editor" data-placeholder="การประเมินผล" data-height="200" name="evaluation_th">
              {{$subs->evaluation_th}}

            </textarea>
        </div><!-- /.form-group -->
        <div class="form-group">
            <label for="evaluation_en">การประเมินผล (อังกฤษ)</label>
            <textarea class="editor" data-placeholder="การประเมินผล" data-height="200" name="evaluation_en">

              {{$subs->evaluation_en}}
            </textarea>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
            <label for="schedule_th">ตารางเรียน (ไทย)</label>
            <textarea class="editor" data-placeholder="ตารางเรียน" data-height="200" name="schedule_th">
              {{$subs->schedule_th}}

            </textarea>
        </div><!-- /.form-group -->
        <div class="form-group">
            <label for="schedule_en">ตารางเรียน (อังกฤษ)</label>
            <textarea class="editor" data-placeholder="ตารางเรียน" data-height="200" name="schedule_en">
              {{$subs->schedule_en}}

            </textarea>
        </div><!-- /.form-group -->
    </div><!-- /.card-body -->
    </div><!-- /.card-body -->

    <!-- .form-actions -->
    <div class="form-actions ">
      <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i> บันทึก</button>
  </div><!-- /.form-actions -->

    </form>
@endsection
