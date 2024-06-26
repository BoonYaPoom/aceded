@extends('layouts.adminhome')
@section('content')
    <form action="{{ route('updateschool', ['school_id' => $school->school_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">

                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a>/ <a
                            href="{{ route('schoolManage') }}">แก้ไขสถานศึกษา</a> </div><!-- /.card-header -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="school_name" class="col-md-1">สถานศึกษา </label>
                            <label for="school_name"> <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="school_name" name="school_name"
                                placeholder="สถานศึกษา" required="" value="{{ $school->school_name }}">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="code" class="col-md-1">จังหวัด </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select id="code" name="code" class="form-control form-control-sm"
                                data-toggle="select2" data-allow-clear="false">
                                <option value="0">โปรดเลือกจังหวัด</option>
                                @php
                                    $Provinces = \App\Models\Provinces::all();
                                @endphp
                                @foreach ($Provinces->sortBy('id') as $provin)
                                    <option value="{{ $provin->code }}"
                                        {{ $school->provinces_id == $provin->id ? 'selected' : '0' }}>
                                        {{ $provin->name_in_thai }} </option>
                                @endforeach
                            </select>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="department_id" class="col-md-1">หน่วยงาน </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select id="department_id" name="department_id" class="form-control form-control-sm"
                                data-toggle="select2" data-allow-clear="false">
                                <option value="0">โปรดเลือกหน่วยงาน</option>
                       
                                @foreach ($depart->sortBy('department_id') as $depa)
                                    <option value="{{ $depa->department_id }}"   {{ $school->department_id == $depa->department_id ? 'selected' : '0' }}>
                                        {{ $depa->name_th }} </option>
                                @endforeach
                            </select>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

    </form>
@endsection
