<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Document</title>
</head>

<body>
    @include('layouts.navbar')
    <section class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 mb-3">
                    <h1>Chỉnh sửa câu đố</h1>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('quizzes.post-update') }}" method="POST" enctype="multipart/form-data" class="form-block">
                        @csrf
                        <input name="id" type="hidden" value="{{ $quiz->id }}">
                        <div class="mb-3">
                            <label for="quizTitle" class="form-label">Tên câu đố</label>
                            <input name="title" type="text" value="title" class="form-control" id="quizTitle">
                            @error('title') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quizDesc" class="form-label">Mô tả</label>
                            <textarea name="description" id="quizDesc" cols="30" rows="5" class="form-control">description</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quizHint" class="form-label">Gợi ý</label>
                            <textarea name="hint" id="quizHint" cols="30" rows="5" class="form-control">hint</textarea>
                            @error('hint') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quizFile" class="form-label">Chọn file khác</label>
                            <input name="file" type="file" class="form-control mb-2" id="quizFile" accept="text/plain">
                            @error('file') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            <p class="d-inline">File hiện tại (đáp án là tên file): </p>
                            <div class="card mt-2 d-inline-block">
                                <div class="card-body p-0">
                                    <a class="d-block p-2 text-center" href="{{ URL::route('quizzes.download', ['id'=>$quiz->id]) }}">{{ $quiz->getFileName() }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quizStartTime" class="form-label">Ngày bắt đầu</label>
                            <input name="start_time" type="datetime-local" value="{{ old('file', $quiz->start_time) }}" id="quizStartTime" class="form-control">
                            @error('start_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quizEndTime" class="form-label">Ngày hết hạn</label>
                            <input name="end_time" type="datetime-local" value="{{ old('file', $quiz->end_time) }}" id="quizEndTime" class="form-control">
                            @error('end_time') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <label for="exercisePublished" class="form-check-label">Giao bài</label>
                            <input name="is_published" type="checkbox" @checked($quiz->is_published) class="form-check-input" id="exercisePublished">
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