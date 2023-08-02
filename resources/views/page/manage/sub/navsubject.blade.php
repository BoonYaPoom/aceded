              @extends('layouts.adminhome')
              @section('content')
                  <!-- .page-inner -->
                  <div class="page-inner">
                      <div class="page-section">
                          <!-- .card -->
                          <div class="card card-fluid">
                              <div class="card-header bg-muted">
                                  <a href="{{ route('suppage', [$subs->department_id]) }}" style="text-decoration: underline;">หมวดหมู่</a> / <a
                                      href="{{ route('lessonpage', [$subs->subject_id]) }}"
                                      style="text-decoration: underline;">จัดการวิชา</a> / <i>{{ $subs->subject_th }}</i>
                              </div><!-- /.card-header -->
                              <!-- .nav-scroller -->

                              <div class="nav-scroller border-bottom">
                                  <!-- .nav -->
                                  <div class="nav nav-tabs bg-muted h3">

                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('editdetailsub', [$subs->subject_id])) ? ' active text-info' : '' }} "
                                          href="{{ route('editdetailsub', [$subs->subject_id]) }}"><i
                                              class="fab fa-codepen"></i> รายละเอียดวิชา</a>

                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('lessonpage', [$subs->subject_id])) ? ' active text-info' : '' }} "
                                          href="{{ route('lessonpage', [$subs->subject_id]) }}"><i class="	fas fa-list"></i>
                                          เนื้อหา</a>
                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('supplypage', [$subs->subject_id])) ? ' active text-info' : '' }}"
                                          href="{{ route('supplypage', [$subs->subject_id]) }}"><i
                                              class="fas fa-file-video"></i> สื่อเสริม</a>
                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('exampage', [$subs->subject_id])) ? ' active text-info' : '' }} "
                                          href="{{ route('exampage', [$subs->subject_id]) }}"><i
                                              class="fas fa-list-alt"></i> ข้อสอบ</a>
                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('activitypage', [$subs->subject_id])) ? ' active text-info' : '' }}"
                                          href="{{ route('activitypage', [$subs->subject_id]) }}"><i
                                              class="far fa-comment-dots"></i> กิจกรรม</a>
                                      <a class="nav-link {{ Str::startsWith(request()->url(), route('teacherspage', [$subs->subject_id])) ? ' active text-info' : '' }}"
                                          href="{{ route('teacherspage', [$subs->subject_id]) }}"><i
                                              class="fas fa-user-tie"></i> ผู้สอน</a>
                                      <a class="nav-link " href="/" target=_blank>แสดงตัวอย่าง</a>

                                  </div><!-- /.nav -->
                              </div><!-- /.nav-scroller -->

                              @yield('subject-data')

                          </div><!-- /.card -->

                      </div><!-- /.page-section -->
                  </div><!-- /.page-inner -->
              @endsection
