<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Chỉnh sửa bài tập</title>
</head>

<body>
    @include('layouts.navbar')
    <section class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 mb-3">
                    <h1>Chỉnh sửa bài tập</h1>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('exercises.post-update') }}" method="POST" enctype="multipart/form-data" class="form-block">
                        @csrf
                        <input name="id" type="hidden" value="{{ $exercise->id }}">
                        <div class="mb-3">
                            <label for="exTitle" class="form-label">Tiêu đề</label>
                            <input name="title" type="text" value="{{ old('title', $exercise->title) }}" class="form-control" id="exTitle">
                            @error('title') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exDesc" class="form-label">Mô tả</label>
                            <textarea name="description" id="exDesc" cols="30" rows="5" class="form-control">{{ old('description', $exercise->description) }}</textarea>
                            @error('description') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exFile" class="form-label">Chọn file khác</label>
                            <input name="file" type="file" class="form-control" id="exFile">
                            @error('file') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            <p class="d-inline">File hiện tại: </p>
                            <div class="card mt-2 d-inline-block">
                                <div class="card-body p-0">
                                    <a class="d-block p-2 text-center" href="{{ URL::route('exercises.download', ['id'=>$exercise->id]) }}">{{ old('file', $exercise->getFileWithoutTimestamp()) }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exerciseStartDate" class="form-label">Ngày bắt đầu</label>
                            <input name="start_time" type="datetime-local" value="{{ old('start_date', $exercise->start_time) }}" id="exerciseStartDate" class="form-control">
                            @error('start_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exerciseEndDate" class="form-label">Ngày hết hạn</label>
                            <input name="end_time" type="datetime-local" value="{{ old('end_time', $exercise->end_time) }}" id="exerciseEndDate" class="form-control">
                            @error('end_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <label for="exercisePublished" class="form-check-label">Giao bài</label>
                            <input name="is_published" type="checkbox" @checked($exercise->is_published) class="form-check-input" id="exercisePublished">
                            @error('is_published') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Cập nhật" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>