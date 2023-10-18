
      
<div id="clientUploadModal-{{ $subitem->lesson_id }}" class="modal fade" tabindex="-1"
    user_role="dialog" aria-labelledby="clientUploadModalLabel">
    <div class="modal-dialog modal-xl" user_role="document">
        <div class="modal-content">
            <form id="uploadfile" method="POST"
                action="{{ route('uploadfile', [$depart,'lesson_id' => $subitem->lesson_id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success">
                    <h6 id="clientUploadModalLabel" class="modal-title inline-editable">
                        <span class="titlelesson">{{ $subitem->lesson_th }}</span>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-fluid">
                        <div class="showcontents card-body text-center">
                            @if ($contentType)
                                @if ($contentType->content_type === 1)
                                    <h1>video</h1> <a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-video">
                                        <video width="80%" id="videoplayer" controls="">
                                            <source
                                                src="{{ asset($subitem->content_path) }}"
                                                alt="{{ $subitem->content_path }}" type="video/mp4"
                                                size="720" id="sourcevideo"
                                                class="sourcecontent">
                                        </video>
                                        <p>{{ $subitem->content_path }}</p>

                                    </div>
                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept="video/*">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                @elseif ($contentType->content_type === 8)
                                    <h1>Image</h1> <a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-image "><img id="sourceimage"
                                            src="{{ asset($subitem->content_path) }}"
                                            alt="{{ $subitem->content_path }}" width="80%"
                                            height="510px">
                                        <p>{{ $subitem->content_path }}</p>

                                    </div>
                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept="image/*">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                @elseif ($contentType->content_type === 4)
                                    <h1>document</h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-document "><object
                                            data="{{ asset($subitem->content_path) }}"
                                            width="100%" height="200px">
                                            <p>{{ $subitem->content_path }}</p>

                                        </object>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                @elseif ($contentType->content_type === 7)
                                    <h1>sound</h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-sound "><audio id="soundplayer"
                                            controls="">
                                            <source
                                                src="{{ asset($subitem->content_path) }}"
                                                alt="{{ $subitem->content_path }}" type="audio/mp3"
                                                id="sourcesounce" class="sourcecontent">

                                        </audio>
                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept="audio/*">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                @elseif ($contentType->content_type === 9)
                                    <h1>{{ $contentType->content_th }}  zip </h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-zip "><object
                                        src="{{ asset($subitem->content_path . '/index.html') }}"
                                        alt="{{ $subitem->content_path . '/index.html'}}" id="sourcezip"
                                        width="100%" height="200px" data="">
                                    </object>

                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".zip">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                    @elseif ($contentType->content_type === 10)
                                    <h1>{{ $contentType->content_th }}  zip </h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-zip "><object
                                        src="{{ asset($subitem->content_path . '/index.html') }}"
                                        alt="{{ $subitem->content_path . '/index.html'}}" id="sourcezip"
                                        width="100%" height="200px" data="">
                                    </object>

                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".zip">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                    @elseif ($contentType->content_type === 11)
                                    <h1>{{ $contentType->content_th }}  zip </h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-zip "><object
                                        src="{{ asset($subitem->content_path . '/index.html') }}"
                                        alt="{{ $subitem->content_path . '/index.html'}}" id="sourcezip"
                                        width="100%" height="200px" data="">
                                    </object>

                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".zip">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                    @elseif ($contentType->content_type === 12)
                                    <h1>{{ $contentType->content_th }}  zip </h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-zip "><object
                                        src="{{ asset($subitem->content_path . '/index.html') }}"
                                        alt="{{ $subitem->content_path . '/index.html'}}" id="sourcezip"
                                        width="100%" height="200px" data="">
                                    </object>

                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".zip">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                    @elseif ($contentType->content_type === 13)
                                    <h1>{{ $contentType->content_th }}  zip </h1><a
                                        href="{{ asset($subitem->content_path) }}"
                                        class="btn btn-primary" download>ดาวน์โหลดไฟล์</a>
                                    <div class="showcontent show-zip "><object
                                        src="{{ asset($subitem->content_path . '/index.html') }}"
                                        alt="{{ $subitem->content_path . '/index.html'}}" id="sourcezip"
                                        width="100%" height="200px" data="">
                                    </object>

                                        <p>{{ $subitem->content_path }}</p>

                                    </div>

                                    <div class="card-body">
                                        <label class="mr-2">เลือกไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" name="content_path"
                                                id="content_path" class="custom-file-input"
                                                accept=".zip">
                                            <label class="custom-file-label"
                                                for="content_path">Choose
                                                files</label>
                                        </div>
                                        <div id="progress"
                                            class="progress progress-xs rounded-0 fade">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                user_role="progressbar" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div id="uploadList"
                                            class="list-group list-group-flush list-group-divider">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-upload fa-lg"></i>
                                                อัพโหลด</button>
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">ยกเลิก</button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>


                    </div>


            </form>

        </div>
    </div>
</div>
