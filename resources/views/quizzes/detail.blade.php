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
                        <div class="col-6">
                            <p class="fw-bold text-start">
                                Trả lời đúng/sai/Chưa trả lời
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
                                    <p>hint</p>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="detail.php" class="form-block">
                                        <input name="quiz_id" type="hidden" value="1">
                                        <input name="user_id" type="hidden" value="1">
                                        <div class="mb-3">
                                            <label for="quizAnswer" class="form-label">Câu trả lời</label>
                                            <input name="answer" type="text" class="form-control" id="quizAnswer">
                                        </div>
                                        <div class="mb-3">
                                            <input name="create" type="submit" href="create_answer.php" class="btn btn-outline-success" value="Trả lời">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12 mb-3">
                            <div><b>Đáp án: </b>{{ $quiz->getFileWithoutTimestamp() }}</p></div>
                            <div><b>Đáp án của bạn: </b><p class="d-inline-block text-success">con_cho</p></div>
                            <p class="my-0"><b>Phần thưởng:</b></p>
                            <p>Nội dung file</p>
                        </div>
                        
                        <hr class="text-muted">
                        <div class="col-12">
                            <a href="{{ URL::route('quizzes.get-update', ['id'=>$quiz->id]) }}" class="btn btn-outline-primary">Chỉnh sửa</a>
                            <a onclick="setDeleteUrl('{{ URL::route('quizzes.delete', ['id'=>$quiz->id]) }}')" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                        </div>
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