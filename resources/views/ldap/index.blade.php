<!-- resources/views/upload-form.blade.php -->

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{route('importall')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv" required>
    <button type="submit">อัพโหลดไฟล์ csv</button>
</form>
