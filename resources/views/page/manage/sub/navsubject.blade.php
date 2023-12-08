@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <div class="card-header bg-muted">
                    <a href="{{ route('suppage', [$depart]) }}" style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href="{{ route('lessonpage', [$depart, $subs]) }}" style="text-decoration: underline;">จัดการวิชา</a> /
                    <i>{{ $subs->subject_th }}</i>
                </div><!-- /.card-header -->
                <!-- .nav-scroller -->

                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">

                        <a class="nav-link {{ Str::startsWith(request()->url(), route('editdetailsub', [$depart, $subs->subject_id])) ? ' active text-info' : '' }} "
                            href="{{ route('editdetailsub', [$depart, $subs->subject_id]) }}"><i class="fab fa-codepen"></i>
                            รายละเอียดวิชา</a>

                        <a class="nav-link {{ Str::startsWith(request()->url(), route('lessonpage', [$depart, $subs->subject_id])) || request()->is('lsn', 'lsn/*') ? ' active text-info' : '' }} "
                            href="{{ route('lessonpage', [$depart, $subs->subject_id]) }}"><i class="	fas fa-list"></i>
                            เนื้อหา</a>
                        <a class="nav-link {{ Str::startsWith(request()->url(), route('supplypage', [$depart, $subs->subject_id])) || request()->is('spm', 'spm/*') ? ' active text-info' : '' }}"
                            href="{{ route('supplypage', [$depart, $subs->subject_id]) }}"><i class="fas fa-file-video"></i>
                            สื่อเสริม</a>
                        <a class="nav-link {{ Str::startsWith(request()->url(), route('exampage', [$depart, $subs->subject_id])) || request()->is('exam', 'exam/*') ? ' active text-info' : '' }} "
                            href="{{ route('exampage', [$depart, $subs->subject_id]) }}"><i class="fas fa-list-alt"></i>
                            แบบฝึกหัด/แบบทดสอบ</a>
                        <a class="nav-link {{ Str::startsWith(request()->url(), route('activitypage', [$depart, $subs->subject_id])) ||
                        request()->is('activity', 'activity/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('activitypage', [$depart, $subs->subject_id]) }}"><i
                                class="far fa-comment-dots"></i> กิจกรรม</a>

                        <a class="nav-link {{ Str::startsWith(request()->url(), route('teacherspage', [$depart, $subs->subject_id])) ? ' active text-info' : '' }}"
                            href="{{ route('teacherspage', [$depart, $subs->subject_id]) }}"><i class="fas fa-user-tie"></i>
                            ผู้สอน</a>
           

                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->

                @yield('subject-data')

            </div><!-- /.card -->

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
