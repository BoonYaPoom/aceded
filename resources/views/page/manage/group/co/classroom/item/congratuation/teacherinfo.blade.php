@extends('layouts.adminhome')
@section('content')
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


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href=""
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href=""
                        style="text-decoration: underline;">รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย</a> / <a
                        href=""
                        style="text-decoration: underline;">รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย</a> / <i>
                        ผู้สอน</i></div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link " href=""><i
                                class="fas fa-users"></i> ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->

                <!-- grid column -->
                <div class="col-lg">

                    <h6 class="card-header"> ข้อมูลส่วนตัว </h6><!-- .card-body -->
                    <div class="card-body">
                        <!-- .media -->
                        <div class="media mb-3">
                            <!-- avatar -->
                            <div class="user-avatar user-avatar-xl fileinput-button">
                                <div class="fileinput-button-label"> Change photo </div><img
                                    src="https://aced.dlex.ai/childhood/admin/templete/looper/assets/images/avatars/avatar.jpg?1688368806"
                                    alt=""> <input id="fileupload-avatar" type="file" name="avatar"
                                    accept="image/*">
                            </div><!-- /avatar -->
                            <!-- .media-body -->
                            <div class="media-body pl-3">
                                <h3 class="card-title"><i class="fas fa-camera"></i> รูปส่วนตัว </h3>
                                <h6 class="card-subtitle text-muted"> Click the current avatar to change your photo. </h6>
                                <p class="card-text ">
                                    <small>JPG, GIF or PNG 400x400, &lt; 2 MB.</small>
                                </p><!-- The avatar upload progress bar -->
                                <div id="progress-avatar" class="progress progress-xs fade">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div><!-- /avatar upload progress bar -->
                            </div><!-- /.media-body -->
                        </div><!-- /.media -->
                        <!-- form -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="input02" class="col-md-2">ชื่อ-สกุล</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control bg-muted" id="input02" placeholder="ชื่อ-สกุล"
                                    value=" " readonly>
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="input03" class="col-md-2">อีเมลล์</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control bg-muted" id="input03" placeholder="อีเมลล์"
                                    value="" readonly>
                            </div><!-- /form column -->
                        </div><!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="position" class="col-md-2">ตำแหน่งปัจจุบัน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="position" name="position" value=""
                                    placeholder="ตำแหน่งปัจจุบัน">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="department" class="col-md-2">หน่วยงาน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="department" name="department" value=""
                                    placeholder="หน่วยงาน">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="workplace" class="col-md-2">สถานที่ทำงาน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="workplace" name="workplace" value=""
                                    placeholder="สถานที่ทำงาน">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="telephone" class="col-md-2">เบอร์โทรที่ทำงาน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="telephone" name="telephone" value=""
                                    placeholder="เบอร์โทรที่ทำงาน">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="mobile" class="col-md-2">มือถือ</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="mobile" name="mobile"
                                    value="" placeholder="มือถือ">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row ">
                            <!-- form column -->
                            <label for="pay" class="col-md-2">ค่าตอบแทน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="pay" name="pay"
                                    value="" placeholder="ค่าตอบแทน">
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row ">
                            <!-- form column -->
                            <label for="education" class="col-md-2">การศึกษา</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="education" name="education" placeholder="การศึกษา"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="experience" class="col-md-2">ประวัติการทำงาน/ประสบการณ์</label>
                            <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="experience" name="experience" placeholder="ประวัติการทำงาน/ประสบการณ์"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="skill" class="col-md-2">ความเชี่ยวชาญ</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="skill" name="skill" placeholder="ความเชี่ยวชาญ"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                        <!-- form row -->
                        <div class="form-row d-none">
                            <!-- form column -->
                            <label for="teach" class="col-md-2">เทคนิคการสอน</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="teach" name="teach" placeholder="เทคนิคการสอน"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->

                        <!-- form row -->
                        <div class="form-row d-none">
                            <!-- form column -->
                            <label for="modern" class="col-md-2">ความทันสมัย</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="modern" name="modern" placeholder="ความทันสมัย"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->

                        <!-- form row -->
                        <div class="form-row ">
                            <!-- form column -->
                            <label for="other" class="col-md-2">อื่นๆ</label> <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea class="form-control" id="other" name="other" placeholder="อื่นๆ"></textarea>
                            </div><!-- /form column -->
                        </div><!-- /form row -->
                    </div><!-- /.card-body -->

                    <!-- .card -->
                    <h6 class="card-header"> Social Networks </h6><!-- form -->
                    <!-- .list-group -->
                    <div class="list-group list-group-flush mt-3 mb-0">
                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-success">
                                    <i class="fab fa-line"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="line" name="socialnetwork[line]"
                                    placeholder="Line" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->

                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-twitter">
                                    <i class="fab fa-twitter"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="twitter" name="socialnetwork[twitter]"
                                    placeholder="Twitter" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->

                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="facebook" name="socialnetwork[facebook]"
                                    placeholder="Facebook" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->

                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-instagram">
                                    <i class="fab fa-instagram"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="instagram"
                                    name="socialnetwork[instagram]" placeholder="Instagram" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->

                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-youtube">
                                    <i class="fab fa-youtube"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="youtube" name="socialnetwork[youtube]"
                                    placeholder="Youtube" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->


                        <!-- .list-group-item -->
                        <div class="list-group-item">
                            <!-- .list-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="tile tile-md bg-github">
                                    <i class="fab fa-github"></i>
                                </div>
                            </div><!-- /.list-group-item-figure -->
                            <!-- .list-group-item-body -->
                            <div class="list-group-item-body">
                                <input type="text" class="form-control" id="github" name="socialnetwork[github]"
                                    placeholder="Github" value="">
                            </div><!-- /.list-group-item-body -->
                        </div><!-- /.list-group-item -->
                    </div><!-- /.list-group -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <hr>
                        <!-- .form-actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary ml-auto btn-lg"><i class="far fa-save"></i>
                                อัพเดท</button>
                        </div><!-- /.form-actions -->
                    </div><!-- /.card-body -->
                    </form><!-- /form -->

                </div><!-- /grid column -->

            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
