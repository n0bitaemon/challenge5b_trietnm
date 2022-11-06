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
                @php
                $answer = App\Models\ExerciseAnswer::where([
                    ['user_id', '=', Request::user()->id],
                    ['exercise_id', '=', $exercise->id]
                ])->first();
                $has_answer = false;
                $is_done = false;
                if($answer !== null){
                    $has_answer = true;
                    if($answer->is_done === 1){
                        $is_done = true;
                    }
                }
                @endphp
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between">
                                        <h5 class="d-inline-block m-0">Bài tập</h5>
                                        @if($is_done === true) <b class="text-success">Hoàn thành</b> @else <b class="text-danger">Chưa làm</b> @endif
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        @if($has_answer)
                                        <div class="card mb-2">
                                            <div class="card-body p-0">
                                            <a class="d-block p-2 text-center" href="{{ URL::route('exercises.answers.download', ['exercise_id'=>$exercise->id, 'user_id'=>Request::user()->id]) }}">{{ $answer->getFileWithoutTimestamp() }}</a>
                                            </div>
                                        </div>
                                        @else
                                        <p class='mb-2'>Chưa upload bài làm</p>
                                        @endif
                                        @if(!$is_done)
                                        <form action="{{ URL::route('exercises.answers.save') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input name="exercise_id" value="{{ $exercise->id }}" type="hidden">
                                            <input name='file' type='file' class='form-control mb-2'>
                                            @error('file') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                            <input value='Nộp bài' type='submit' class='btn btn-primary'>
                                            <div class="col-12 mb-3 py-1">
                                        </form>
                                        @else
                                        <a href="{{ URL::route('exercises.answers.cancle', ['id'=>$exercise->id]) }}" class="btn btn-danger">Hủy nộp bài</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcannot
                @can('access', App\Models\Exercise::class)
                @php
                $answers = App\Models\ExerciseAnswer::where('exercise_id', '=', $exercise->id)->get();
                $studentCount = App\Models\User::where('is_teacher', '=', 0)->count();
                @endphp
                <div class="col-12 mt-5">
                    <h3>Danh sách bài làm</h3>
                    <p>Có <b>{{ $answers->count().' / '.$studentCount }}</b> học sinh đã hoàn thành</p>
                    <table class="table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Điểm</th>
                            <th scope="col">Ngày nộp</th>
                            <th scope="col">File bài làm</th>
                        </thead>
                        <tbody>
                            @foreach($answers as $answer)
                            @php $user = App\Models\User::find($answer->user_id, ['fullname']) @endphp
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td><a href="#">{{ $user->fullname }}</td>
                                <td>Chưa chấm / đã chấm</td>
                                <td>{{ $answer->answer_time }}</td>
                                <td><a href="{{ URL::route('exercises.answers.download', ['exercise_id'=>$exercise->id, 'user_id'=>$answer->user_id]) }}" class="btn btn-sm btn-outline-primary">Download</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endcan
            </div>
        </div>
    </section>

    @can('access', App\Models\Exercise::class)
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
    @endcan
</body>

</html>