<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head');
    <title>Danh sách bài tập</title>
</head>

<body>
    @include('layouts.navbar');

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <h1>Danh sách bài tập</h1>
                </div>
                @can('access', App\Models\Exercise::class)
                <div class="col-12 mb-3">
                    <a href="{{ URL::route('exercises.get-add') }}" class="btn btn-outline-success">Tạo bài tập mới</a>
                </div>
                @endcan
                @empty($exercises)
                <p>Hiện tại không có bài tập nào</p>
                @endempty
                @foreach ($exercises as $exercise)
                @php
                $creator = App\Models\User::select('fullname')->where('id', '=', $exercise->creator_id)->first();
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-12 pb-5">
                    <div class="card done">
                        <div class="card-header d-flex justify-content-between">
                            <p class="m-0">{{ $exercise->title }}</p>
                            <p class="text-success m-0">Đã giao</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7 text-muted"><a href="{{ URL::route('users.profile', ['id'=>$exercise->creator_id]) }}">{{ $creator->fullname }}</a></div>
                                <div class="col-5 text-muted text-end">{{ $exercise->start_time }}</div>
                            </div>
                            <div class="card-text py-3">{{ $exercise->description }}</div>
                            <a href="{{ URL::route('exercises.detail', ['id'=>$exercise->id]) }}" class="btn btn-primary">Xem bài tập</a>
                            @can('access', App\Models\Exercise::class)
                            <a href="{{ URL::route('exercises.get-update', ['id'=>$exercise->id]) }}" class="btn btn-outline-info">Sửa</a>
                            <a onclick="setDeleteUrl('{{ URL::route('exercises.delete', ['id'=>$exercise->id]) }}')" href="#" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
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
            deleteBtn = document.getElementById('deleteBtn');
            deleteBtn.href = url;
        }
    </script>
</body>

</html>