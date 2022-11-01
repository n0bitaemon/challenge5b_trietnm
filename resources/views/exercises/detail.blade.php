<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Thông tin bài tập</title>
</head>

<body>
    @include('layouts.navbar')

    <section class="content">
        <div class="container-lg">
            <div class="row">

                <!-- Left column -->
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="row">
                        <h1 class="col-12">{{ $exercise->title }}</h1>
                        <div class="col-12">
                            <p class="text-muted">{{ $creator->fullname }} - Tạo vào ngày {{ $exercise->start_time }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-bold text-start">?/10 điểm</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-bold text-end">Đến hạn {{ $exercise->end_time }}</p>
                        </div>
                        <hr>
                        <div class="col-12 mb-3">
                            <div class="col-6 py-1">
                                <div class="card">
                                    <div class="card-body p-0">
                                    <a class="d-block p-2 text-center" href="{{ URL::route('exercises.download', ['id'=>$exercise->id]) }}">{{ $exercise->getFileWithoutTimestamp() }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('access', App\Models\Exercise::class)
                        <hr class="text-muted">
                        <div class="col-12 mb-">
                            <a href="{{ URL::route('exercises.get-update', ['id'=>$exercise->id]) }}" class="btn btn-outline-primary">Chỉnh sửa</a>
                            <a onclick="setDeleteUrl('{{ URL::route('exercises.delete', ['id'=>$exercise->id]) }}')" href="#" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                        </div>
                        @endcan
                    </div>
                </div>

                @cannot('access', App\Models\Exercise::class)
                <!--Left column -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between">
                                        <h5 class="d-inline-block m-0">Bài tập</h5>
                                        <p class="d-inline-block text-success m-0">Hoàn thành/Đã giao</p>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <form action="detail.php" method="POST" enctype="multipart/form-data">
                                            <input name="user_id" value="User ID" type="hidden">
                                            <input name="exercise_id" value="{{ $exercise->id }}" type="hidden">
                                                <div class="card mb-2">
                                                    <div class="card-body p-0">
                                                    <a class="d-block p-2 text-center" href="#">File path</a>
                                                    </div>
                                                </div>
                                                <p class='mb-2'>Chưa upload file</p>
                                                <input name='file' type='file' class='form-control mb-2'>
                                                <input name='submit_ans' value='Nộp bài' type='submit' class='btn btn-primary'>
                                                <div class="col-12 mb-3 py-1">
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <a class="d-block p-3" href="#">Ans file</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="detail.php" method="POST">
                                                    <input name="user_id" value="" type="hidden">
                                                    <input name="exercise_id" value="" type="hidden">
                                                    <input name='cancle_ans' value='Hủy nộp bài' type='submit' class='btn btn-danger'>
                                                </form>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcannot
                @can('access', App\Models\Exercise::class)
                <div class="col-12 mt-5">
                    <h3>Danh sách bài làm</h3>
                    <table class="table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Điểm</th>
                            <th scope="col">Ngày nộp</th>
                            <th scope="col">File bài làm</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td><a href="#">Fullname</td>
                                <td>Chưa chấm / đã chấm</td>
                                <td>submit_date</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endcan
            </div>
        </div>
    </section>

    <!--Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Bạn có chắc rằng muốn xóa bài tập này?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a type="button" class="btn btn-danger" id="deleteBtn">Xóa</a>
            </div>
          </div>
        </div>
      </div>
    <!--End modal-->

    <script>
        function setDeleteUrl(url){
            deleteBtn = document.getElementById("deleteBtn");
            deleteBtn.href = url;
        }
    </script>
</body>

</html>