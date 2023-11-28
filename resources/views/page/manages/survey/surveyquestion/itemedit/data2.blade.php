
<div id="data2"
style="{{ $surques->question_type == 2 ? 'display: block;' : 'display: none;' }}">
<!-- แสดงข้อมูลที่ 1 -->
@php

    $choice1 = json_decode($surques->choice1, true);
@endphp

<!-- grid row -->
<div class="row qtype2">
    <div class="col-lg-6">
        <!-- .list-group -->
        <div class="list-group list-group mb-3">
            <div class="list-group-item">
                <div class="list-group-item-figure">
                    <span class="tile tile-circle bg-success"><i
                            class="fas fa-question"></i></span>
                </div>
                <div class="list-group-item-header"> คำถาม </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">1</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q1" name="q1" placeholder="คำถาม"
                        value="{{ isset($choice1[0]) ? $choice1[0] : '' }}"></div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">2</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q2" name="q2" placeholder="คำถาม"
                        value="{{ isset($choice1[1]) ? $choice1[1] : '' }}"></div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">3</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q3" name="q3" placeholder="คำถาม"
                        value="{{ isset($choice1[2]) ? $choice1[2] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">4</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q4" name="q4" placeholder="คำถาม"
                        value="{{ isset($choice1[3]) ? $choice1[3] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">5</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q5" name="q5" placeholder="คำถาม"
                        value="{{ isset($choice1[4]) ? $choice1[4] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">6</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q6" name="q6" placeholder="คำถาม"
                        value="{{ isset($choice1[5]) ? $choice1[5] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">7</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q7" name="q7" placeholder="คำถาม"
                        value="{{ isset($choice1[6]) ? $choice1[6] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">8</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q8" name="q8" placeholder="คำถาม"
                        value="{{ isset($choice1[7]) ? $choice1[7] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">9</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q9" name="q9" placeholder="คำถาม"
                        value="{{ isset($choice1[8]) ? $choice1[8] : '' }}">
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6">10</div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="q10" name="q10" placeholder="คำถาม"
                        value="{{ isset($choice1[9]) ? $choice1[9] : '' }}">
                </div>
            </div>
        </div><!-- /.list-group -->
    </div><!-- /grid column -->
    <!-- grid column -->
    <div class="col-lg-6">
        <!-- .list-group -->
        <div class="list-group list-group mb-3">
            <div class="list-group-item">
                <div class="list-group-item-figure">
                    <span class="tile tile-circle bg-success"><i
                            class="fas fa-comment-dots"></i></span>
                </div>
                <div class="list-group-item-header"> ตัวเลือก </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6"></div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="c1" name="c1" placeholder="ตัวเลือก"
                        value="น้อยที่สุด" disabled></div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6"></div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="c2" name="c2" placeholder="ตัวเลือก" value="น้อย" disabled>
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6"></div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="c3" name="c3" placeholder="ตัวเลือก"
                        value="ปานกลาง" disabled></div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6"></div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="c4" name="c4" placeholder="ตัวเลือก" value="มาก" disabled>
                </div>
            </div>
            <div class="list-group-item">
                <div class="list-group-item-figure h6"></div>
                <div class="list-group-item-body"> <input type="text" class="form-control"
                        id="c5" name="c5" placeholder="ตัวเลือก"
                        value="มากที่สุด" disabled></div>
            </div>
            
        </div><!-- /.list-group -->
    </div><!-- /grid column -->

</div><!-- /grid row -->
</div>