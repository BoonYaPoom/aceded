@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid" >
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                  style="text-decoration: underline;">จัดการเว็บ</a> / <a
                  href="{{ route('linkpage') }}"
                        style="text-decoration: underline;">ลิงค์ที่น่าสนใจ</a> / {{ $links->links_title }}</div><!-- /.card-header -->
                <form action="{{ route('updatelink', ['links_id' => $links->links_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cover"><img src="{{ Storage::disk('external')->url('links/' . $links->cover) }}"
                                    alt="{{ $links->cover }}">
                        </div>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" name="cover" placeholder="ภาพปก" accept="image/*"
                                value="{{ $links->cover }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links_title">ลิงค์ที่น่าสนใจ </label>
                            <input type="text" class="form-control" name="links_title" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="{{ $links->links_title }}">
                        </div><!-- /.form-group -->
                        @error('links_title')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links">URL </label>
                            <input type="text" class="form-control" name="links" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="{{ $links->links }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        @error('links')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                    
                    </div><!-- /.card-body -->
   
            </div><!-- /.card -->
                <!-- .form-actions -->
                <div class="form-actions">
                    <input type="hidden" name="hidden_id" value="">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
        </form>

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
