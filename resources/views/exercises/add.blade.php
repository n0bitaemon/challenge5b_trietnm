<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Tạo bài tập mới</title>
</head>

<body>
    @include('layouts.navbar')
    <section class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 mb-3">
                    <h1>Tạo bài tập mới</h1>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('exercises.post-add') }}" method="POST" enctype="multipart/form-data" class="form-block">
                        @csrf
                        <div class="mb-3">
                            <label for="exTitle" class="form-label">Tiêu đề</label>
                            <input name="title" type="text" value="{{ old('title') }}" class="form-control" id="exTitle">
                            @error('title') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exDesc" class="form-label">Mô tả</label>
                            <textarea name="description" id="exDesc" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exFile" class="form-label">Chọn file</label>
                            <input name="file" type="file" value="{{ old('file') }}" class="form-control" id="exFile">
                            @error('file') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exerciseStartDate" class="form-label">Ngày bắt đầu</label>
                            <input name="start_time" type="datetime-local" value="{{ old('start_time') }}" id="exerciseStartDate" class="form-control">
                            @error('start_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exerciseEndDate" class="form-label">Ngày hết hạn</label>
                            <input name="end_time" type="datetime-local" value="{{ old('end_time') }}" id="exerciseEndDate" class="form-control">
                            @error('end_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <label for="exercisePublished" class="form-check-label">Giao bài</label>
                            <input name="is_published" type="checkbox" {{ old('is_published' ) ? 'checkked' : '' }} class="form-check-input" id="exercisePublished">
                            @error('is_published') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Tạo mới" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>