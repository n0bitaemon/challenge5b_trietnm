<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Câu đố: {{ $quiz->title }}</title>
</head>

<body>
    @include('layouts.navbar')

    <section class="content">
        <div class="container-lg">
            <div style="max-width: 900px" class="row">
                <div class="col-12">
                    <div class="row">
                        <h1 class="col-12">{{ $quiz->title }}</h1>
                        <div class="col-12">
                            <p class="text-muted">Tác giả: {{ $creator->fullname }} - Bắt đầu vào {{ $quiz->start_time }}</p>
                        </div>
                        @php
                        $is_teacher = Request::user()->is_teacher;
                        $is_answered = false;
                        $quizAnswer = App\Models\QuizAnswer::select('answer')
                            ->where([
                                ['user_id', '=', Request::user()->id],
                                ['quiz_id', '=', $quiz->id]
                            ])->first();
                        if($quizAnswer) $is_answered = true;
                        @endphp
                        <div class="col-6">
                            <p class="fw-bold text-start">
                                @php
                                if($is_teacher){
                                    echo '<p class="fw-bold '.($quiz->is_published ? 'text-success">Đã giao' : 'text-danger">Chưa giao').'</p>';
                                }else{
                                    if(!$is_answered){
                                        echo '<p class="fw-bold text-danger">Chưa trả lời</p>';
                                    }else{
                                        echo '<p class="fw-bold '.($quizAnswer->answer === $quiz->getFileName(true) ? 'text-success">Trả lời đúng' : 'text-danger">Trả lời sai').'</p>';
                                    }
                                }
                                @endphp
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="fw-bold text-end">Đến hạn {{ $quiz->end_time }}</p>
                        </div>
                        <hr>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <p><b>Đề bài: </b>Hãy điền đáp án đúng dựa trên gợi ý được cho sẵn</p>
                                    <p>Gợi ý: {{ $quiz->hint }}</p>
                                </div>
                                @can('answer', $quiz)
                                <div class="col-12">
                                    <form method="POST" action="{{ URL::route('quizzes.answer') }}" class="form-block">
                                        @csrf
                                        <input name="quiz_id" type="hidden" value="{{ $quiz->id }}">
                                        <div class="mb-3">
                                            <label for="quizAnswer" class="form-label">Câu trả lời</label>
                                            <input name="answer" type="text" class="form-control" id="quizAnswer">
                                            @error('answer') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <input name="create" type="submit" href="create_answer.php" class="btn btn-outline-success" value="Trả lời">
                                        </div>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>
                        <hr>
                        <div class="col-12 mb-3">
                            @can('seeAnswer', $quiz)
                            <div><b>Đáp án: </b>{{ $quiz->getFileName(true) }}</p></div>
                            @endcan
                            @cannot('access', \App\Models\Quiz::class)
                            <div>
                                @if($is_answered)
                                <b>Đáp án của bạn: </b><p class="d-inline-block">{{ $quizAnswer->answer }}</p>
                                @else
                                <p>Bạn chưa trả lời câu đố này</p>
                                @endif
                            </div>
                            @endcannot
                            @can('seeGift', $quiz)
                            <p class="my-0"><b>Phần thưởng:</b></p>
                            @php
                            //Read file
                            foreach(file(Storage::disk('local')->path($quiz->getFilePath())) as $line){
                                echo "<p class='mb-0'>$line</p>";
                            }
                            @endphp
                            @endcan
                        </div>
                        @can('access', App\Models\Quiz::class)
                        <hr class="text-muted">
                        <div class="col-12">
                            <a href="{{ URL::route('quizzes.get-update', ['id'=>$quiz->id]) }}" class="btn btn-outline-primary">Chỉnh sửa</a>
                            <a onclick="setDeleteUrl('{{ URL::route('quizzes.delete', ['id'=>$quiz->id]) }}')" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Xóa câu đố</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Bạn có chắc rằng muốn xóa câu đố này?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a id="deleteBtn" class="btn btn-danger">Xóa</a>
            </div>
          </div>
        </div>
      </div>
    <!--End modal-->
    
    <script>
        function setDeleteUrl(url){
            let deleteBtn = document.getElementById("deleteBtn");
            deleteBtn.href = url;
        }
    </script>
</body>

</html>