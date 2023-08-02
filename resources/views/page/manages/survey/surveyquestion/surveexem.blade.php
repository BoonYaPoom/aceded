<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Title -->
    <title>สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ</title>

    <!-- Required Meta Tags Always Come First -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://aced.dlex.ai/childhood/admin/upload-files/logo/logo.png">
    <link rel="apple-touch-icon" href="https://aced.dlex.ai/childhood/admin/upload-files/logo/logo.png">


    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/custombox/dist/custombox.min.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/animate.css/animate.min.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/hs-megamenu/src/hs.megamenu.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/fancybox/jquery.fancybox.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/slick-carousel/slick/slick.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/dzsparallaxer/dzsparallaxer.css">
    <link rel="stylesheet"
        href="https://aced.dlex.ai/childhood/templete/front/assets/vendor/summernote/dist/summernote-lite.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="https://aced.dlex.ai/childhood/templete/front/assets/css/theme.css">
    <script src="https://connect.facebook.net/en_US/sdk.js?hash=6575844a877cf1c014d82c5b0f1a6d4c" async=""
        crossorigin="anonymous"></script>
    <script src="https://aced.dlex.ai/childhood/asset/jquery.mousewheel.min.js"></script>


    </div>
    <div class="container mt-3 mb-6">
        <!-- card block 1-->
        <div class="col-lg-12  shadow-soft p-1 pt-1 pl-0 pr-0  ">
            <!-- title block -->
            <div class="col-lg-12 tab-pane active" id="tab-f-index" role="tabpanel" aria-labelledby="tab-1">
                <div class="d-flex">
                    <h4 class="h5 text-primary mt-1">แบบประเมินความพึงพอใจที่มีต่อบทเรียนออนไลน์ รายวิชาเพิ่มเติม
                        การป้องกันการทุจริต ระดับปฐมวัย</h4>
                </div>
                <small class="form-text text-muted"></small>
            </div>
            <!-- end title block  -->
            <hr class="my-1">

            <!-- detail block  -->
            <div class="col-lg-12">
                @foreach ($surques as $index => $item)
                    @php
                        $rowNumber = $index + 1;
                        
                    @endphp

                    <form action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="survey_id" value="25">
                        <!-- My Network -->
                        <!-- Title 1-->
                        @if ($item->question_type == 1)
                        <div id="question_id" class="row justify-content-between align-items-end ">
                            <div class="col-12">
                                <h2 class="h5 mt-3 mb-3">{{ $rowNumber }}) {!! $item->question !!}</h2>
                            </div>
                        </div>
                            <!-- End Title -->
                            @for ($i = 1; $i <= 8; $i++)
                            @if (isset($item->{'choice' . $i}))
                                <div class="custom-control custom-radio ml-2 mb-3">
                                    <input type="radio" name="response" value="{{ $item->{'choice' . $i} }}" class="custom-control-input" id="response{{ $item->id }}_{{ $i }}"
                                        data-error-class="u-has-error" data-success-class="u-has-success">
                                    <label class="custom-control-label" for="response{{ $item->id }}_{{ $i }}">
                                        <span class="d-block text-secondary">{{ $item->{'choice' . $i} }}</span>
                                    </label>
                                </div>
                            @endif
                        @endfor
                                      
                                      <!-- End Checkbox Switch --><!-- Checkbox Switch -->
                                      <div class="custom-control custom-radio ml-2 mb-3">
                                    
                                
                            </div>

                            @endif
                            <!-- Title 1-->

                            @if ($item->question_type == 2)
                                <!-- Title 1-->
                                <div id="question_id" class="row justify-content-between align-items-end ">
                                    <div class="col-12">
                                        <h2 class="h5 mt-3 mb-3">{{ $rowNumber }}) {!! $item->question !!}
                                        </h2>

                                    </div>
                                </div>
                                <!-- End Title -->
                                <div class="table-responsive-md">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <td style="vertical-align: middle;" class="text-center" rowspan="2">
                                                    รายการ
                                                </td>
                                                <td class="center" colspan="5">ระดับความพึงพอใจ</td>
                                            </tr>
                                            <tr class="info">
                                                <td class="text-center" style="width: 75px;">น้อยที่สุด</td>
                                                <td class="text-center" style="width: 75px;">น้อย</td>
                                                <td class="text-center" style="width: 75px;">ปานกลาง</td>
                                                <td class="text-center" style="width: 75px;">มาก</td>
                                                <td class="text-center" style="width: 75px;">มากที่สุด</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $choices = explode(',', $item->choice1);
                                            @endphp

                                            @foreach ($choices as $key => $choice)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $choice }}</td>
                                                    <td style="vertical-align: middle;" class="text-center ">
                                                        <div class="custom-control custom-radio "><input type="radio"
                                                                name="response[6][0]" value="0"
                                                                class="custom-control-input" id="answer_6_0_0"
                                                                required=""><label class="custom-control-label"
                                                                for="answer_6_0_0"></label></div>
                                                    </td>
                                                    <td style="vertical-align: middle;" class="text-center ">
                                                        <div class="custom-control custom-radio "><input
                                                                type="radio" name="response[6][0]" value="1"
                                                                class="custom-control-input" id="answer_6_0_1"
                                                                required=""><label class="custom-control-label"
                                                                for="answer_6_0_1"></label></div>
                                                    </td>
                                                    <td style="vertical-align: middle;" class="text-center ">
                                                        <div class="custom-control custom-radio "><input
                                                                type="radio" name="response[6][0]" value="2"
                                                                class="custom-control-input" id="answer_6_0_2"
                                                                required=""><label class="custom-control-label"
                                                                for="answer_6_0_2"></label></div>
                                                    </td>
                                                    <td style="vertical-align: middle;" class="text-center ">
                                                        <div class="custom-control custom-radio "><input
                                                                type="radio" name="response[6][0]" value="3"
                                                                class="custom-control-input" id="answer_6_0_3"
                                                                required=""><label class="custom-control-label"
                                                                for="answer_6_0_3"></label></div>
                                                    </td>
                                                    <td style="vertical-align: middle;" class="text-center ">
                                                        <div class="custom-control custom-radio "><input
                                                                type="radio" name="response[6][0]" value="4"
                                                                class="custom-control-input" id="answer_6_0_4"
                                                                required=""><label class="custom-control-label"
                                                                for="answer_6_0_4"></label></div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- Title 1-->
                            @endif
                            @if ($item->question_type == 3)
                                <div id="question_id" class="row justify-content-between align-items-end ">
                                    <div class="col-12">
                                        <h2 class="h5 mt-3 mb-3">{{ $rowNumber }}) {!! $item->question !!}</h2>
                                    </div>
                                </div>
                                <!-- End Title -->
                                <!-- Checkbox Switch -->
                                <div class="input-group">
                                    <textarea class="form-control" rows="4" name="response[9]" id="response9" placeholder="ความคิดเห็น"
                                        aria-label="ความคิดเห็น" required="" data-msg="ความคิดเห็น" data-error-class="u-has-error"
                                        data-success-class="u-has-success" onblur="comments(9,this.value,3)"></textarea>
                                </div>
                                <!-- End Checkbox Switch -->
                            @endif
                        @endforeach


                        <div class="text-center space-lg-1"><button type="submit"
                                class="btn  btn-primary btn-wide transition-3d-hover">ส่งแบบสอบถาม</button></div>
                    </form>
            </div>
        </div>

        <!-- end detail block  -->
    </div>
    <!-- end card block 1 -->
    </div>
    <!--End Learn Detail -->


    <!-- End Content Section -->



    <!-- ========== END FOOTER ========== -->
    <!-- Go to Top -->

    <a class="js-go-to u-go-to animated js-animation-was-fired slideInUp" href="javascript:#"
        data-position="{&quot;bottom&quot;: 15, &quot;right&quot;: 15 }" data-type="fixed" data-offset-top="400"
        data-compensation="#header" data-show-effect="slideInUp" data-hide-effect="slideOutDown"
        style="z-index: 9999; display: inline-block; position: fixed; bottom: 15px; right: 15px; border: 2px solid rgb(255, 255, 255);">
        <span class="fas fa-arrow-up u-go-to__inner"></span>
    </a>
    <!-- End Go to Top -->

    <!-- JS Global Compulsory -->
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js">
    </script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/vendor/jquery-ui.js"></script>
    <script src="https://aced.dlex.ai/childhood/vendor/emojionearea.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/admin/vendor/ckeditor4/ckeditor.js?v=4"></script>
    <!-- JS Implementing Plugins -->
    <!-- modal -->

    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/custombox/dist/custombox.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/custombox/dist/custombox.legacy.min.js">
    </script>
    <!-- modal -->

    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/svg-injector/dist/svg-injector.min.js">
    </script>
    <script
        src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js">
    </script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/jquery-validation/dist/jquery.validate.min.js">
    </script>

    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/typed.js/lib/typed.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/slick-carousel/slick/slick.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/dzsparallaxer/dzsparallaxer.js"></script>
    <script
        src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js">
    </script>

    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/summernote/dist/summernote-lite.js"></script>
    <script
        src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js">
    </script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/datatables/media/js/jquery.dataTables.min.js">
    </script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/appear.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/circles/circles.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/player.js/dist/player.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/vendor/jquery.countdown.min.js"></script>

    <script src="https://aced.dlex.ai/childhood/vendor/tooltip.min.js"></script>

    <!-- JS Front -->
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/hs.core.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.header.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.unfold.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.focus-state.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.malihu-scrollbar.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.validation.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.fancybox.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.slick-carousel.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.show-animation.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.selectpicker.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.sticky-block.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.scroll-nav.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.svg-injector.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.go-to.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.range-datepicker.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.toggle-state.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.datatables.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.chart-pie.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.progress-bar.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.video-player.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.modal-window.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/front/assets/js/components/hs.countdown.js"></script>
    <script src="https://aced.dlex.ai/childhood/vendor/moment.js"></script>
    <script src="https://aced.dlex.ai/childhood/vendor/sweetalert2/11.0.18/sweetalert2.min.js"></script>
    <script src="https://aced.dlex.ai/childhood/templete/custom.js?1687145225"></script>
    <!-- <script src="https://aced.dlex.ai/childhood/assets/countdown/script.js?1687145225"></script> -->


    <div id="fb-root" class=" fb_reset">
        <div style="position: absolute; top: -10000px; width: 0px; height: 0px;">
            <div></div>
        </div>
        <div class="fb-customerchat" page_id="403072073425295" fb-xfbml-state="rendered"
            fb-iframe-plugin-query="app_id=800372507780549&amp;current_url=https%3A%2F%2Faced.dlex.ai%2Fchildhood%2F%2Fsurvey%2Fassessment%2F25.html&amp;is_loaded_by_facade=true&amp;locale=en_US&amp;log_id=b5b89310-ecc4-42be-aa6b-181bb773b422&amp;page_id=403072073425295&amp;request_time=1687145231324&amp;sdk=joey&amp;should_use_new_domain=false">
            <div id="f202e2e49d8c134"></div>
        </div>
        <div class=" fb_iframe_widget fb_invisible_flow"
            fb-iframe-plugin-query="app_id=800372507780549&amp;container_width=1465&amp;current_url=https%3A%2F%2Faced.dlex.ai%2Fchildhood%2F%2Fsurvey%2Fassessment%2F25.html&amp;is_loaded_by_facade=true&amp;locale=en_US&amp;log_id=b5b89310-ecc4-42be-aa6b-181bb773b422&amp;page_id=403072073425295&amp;request_time=1687145237776&amp;sdk=joey">
            <span style="vertical-align: top; width: 0px; height: 0px; overflow: hidden;"><iframe
                    name="f37774f1c885f78" width="1000px" height="1000px"
                    data-testid="fb:customerchat Facebook Social Plugin" title="" frameborder="0"
                    allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media"
                    src="https://web.facebook.com/v15.0/plugins/customerchat.php?app_id=800372507780549&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df191d52769ffa88%26domain%3Daced.dlex.ai%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Faced.dlex.ai%252Ff6bedce89fe5dc%26relation%3Dparent.parent&amp;container_width=1465&amp;current_url=https%3A%2F%2Faced.dlex.ai%2Fchildhood%2F%2Fsurvey%2Fassessment%2F25.html&amp;is_loaded_by_facade=true&amp;locale=en_US&amp;log_id=b5b89310-ecc4-42be-aa6b-181bb773b422&amp;page_id=403072073425295&amp;request_time=1687145237776&amp;sdk=joey"
                    style="border: none; visibility: visible; width: 0px; height: 0px;"></iframe></span>
        </div>
    </div>
    </body>

</html>
