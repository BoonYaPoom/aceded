@extends('layouts.adminhome')
@section('content')
    <div id="applyForJob" class="container space-1">
        <div class="card shadow-sm py-5 px-5">
            <!-- Title -->
            <div class="text-center mb-7">
                <h2 class="h3 font-weight-normal"> </h2>
            </div>
            <!-- End Title -->
            <div class="row">
                <div class="col-md-12 mb-5">
                    <!-- Input -->
                    <div class="js-form-message">
                        <label class="form-label" for="title"> <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control custom-select" required name="category_id" id="category_id"
                                data-msg="" data-error-class="u-has-error" data-success-class="u-has-success">
                                <option value=""></option>

                            </select>
                        </div>
                    </div>
                    <!-- End Input -->
                </div>

                <div class="col-md-12 mb-5">
                    <!-- Input -->
                    <div class="js-form-message">
                        <label class="form-label" for="title"><span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder=""
                                aria-label="" required value="" data-msg="" data-error-class="u-has-error"
                                data-success-class="u-has-success">
                        </div>
                    </div>
                    <!-- End Input -->
                </div>

                <div class="col-md-12 mb-5">
                    <!-- Input -->
                    <div class="js-form-message">
                        <label class="form-label"><span class="text-danger">*</span></label>

                        <textarea name="detail" class="ckeditor" id="detail" title="detail"></textarea>
                        <div class="input-group"></div>

                    </div>
                    <!-- End Input -->
                </div>
                <div class="col-md-12 mb-5">
                    <!-- Input -->
                    <div class="js-form-message">
                        <label class="form-label" for="title"> </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="location" id="location" value=""
                                placeholder="" aria-label="" data-msg="" data-error-class="u-has-error"
                                data-success-class="u-has-success">
                        </div>
                    </div>
                    <!-- End Input -->
                </div>
                <div class="col-md-12 mb-5">
                    <!-- Input -->
                    <div class="js-form-message">
                        <label class="form-label" for="title"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="url" id="url" value=""
                                placeholder="" aria-label="" data-msg="" data-error-class="u-has-error"
                                data-success-class="u-has-success">
                        </div>
                    </div>
                    <!-- End Input -->
                </div>
                <div class="col-md-12 mb-5">
                    <label class="form-label"><span class="text-danger">*</span></label>
                    <!-- Datepicker -->
                    <div id="datepickerWrapper" class="js-focus-state u-datepicker w-auto input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-calendar"></span>
                            </span>
                        </div>
                        <input type="text" name="date" class="js-range-datepicker form-control bg-white rounded-right"
                            readonly data-rp-wrapper="#datepickerWrapper" data-rp-type="range" data-rp-date-format="d M Y"
                            data-rp-default-date='' data-rp-is-disable-future-dates="false">
                    </div>
                    <!-- End Datepicker -->
                </div>
                <div class="col-md-6 mb-5">
                    <label class="form-label"></label>
                    <!-- Datepicker -->
                    <div id="datepickerWrapper" class="js-focus-state u-datepicker w-auto input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-clock"></span>
                            </span>
                        </div>
                        <input type="time" name="starttime" class="form-control bg-white rounded-right"
                            value="">
                    </div>
                    <!-- End Datepicker -->
                </div>

                <div class="col-md-6 mb-5">
                    <label class="form-label"></label>
                    <!-- Datepicker -->
                    <div id="datepickerWrapper" class="js-focus-state u-datepicker w-auto input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-clock"></span>
                            </span>
                        </div>
                        <input type="time" name="endtime" class="form-control bg-white rounded-right" value="">
                    </div>
                    <!-- End Datepicker -->
                </div>
            </div>


            <form>
                <!-- My Network -->
                <div class="mb-7">
                    <!-- Title -->
                    <div class="row justify-content-between align-items-end">
                        <div class="col-6">
                            <h2 class="h5 mb-0"></h2>
                        </div>
                        <div class="col-6 text-right">
                            <a id="toggleAll1" class="js-toggle-state link-muted" href="javascript:;"
                                data-target="#allowcomment, #activity_status">
                                <span class="link-muted__toggle-default"></span>
                                <span class="link-muted__toggle-toggled"></span>
                            </a>
                        </div>
                    </div>
                    <!-- End Title -->

                    <hr class="mt-2 mb-4">
                    <!-- Checkbox Switch -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="allowcomment" name="allowcomment"
                            value="1">
                        <label class="custom-control-label" for="allowcomment">
                            <span class="d-block"></span>
                            <small class="d-block text-muted"></small>
                        </label>
                    </div>
                    <!-- End Checkbox Switch -->

                    <hr class="my-3">

                    <!-- Checkbox Switch -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activity_status" name="activity_status"
                            value="1">
                        <label class="custom-control-label" for="activity_status">
                            <span class="d-block"></span></span>
                            <small class="d-block text-muted"></small>
                        </label>
                    </div>
                    <!-- End Checkbox Switch -->


                </div>
                <!-- End My Network -->

                <div class="text-right">
                    <button type="submit" class="btn btn-primary transition-3d-hover"><i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
            <!-- End Apply Form -->
        </div>
    </div>
    <!-- End Apply For Job Section -->
@endsection
