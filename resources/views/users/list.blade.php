<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Danh sách thành viên</title>
</head>

<body>
    @include('layouts.navbar')

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <h1>Danh sách thành viên</h1>
                </div>
                @can('add', App\Models\User::class)
                <div class="col-12 mb-3">
                    <a href="{{ URL::route('users.get-add') }}" class="btn btn-outline-success">Thêm học sinh</a>
                </div>
                @endcan
                <p>Lớp có <b>{{ $users->count() }}</b> thành viên</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Vai trò</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
							<tr>
								<th scope="row">{{ $loop->index + 1 }}</th>
								<td><a href="{{ URL::route('users.profile', ['id'=>$user->id]) }}">{{ $user->fullname }}</a></td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->phone }}</td>
								<td>@if($user->is_teacher === 1) Giáo viên @else Học sinh @endif</td>
								<td class="action">
                  @can('update', $user)
									<a href="{{ URL::route('users.get-update', ['id'=>$user->id]) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                  @endcan
                  @can('delete', $user)
									<a onclick="setDeleteUrl('{{ URL::route('users.delete', ['id'=>$user->id]) }}')" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                  @endcan
                </td>
							</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @can('access', App\Models\User::class)
    <!--Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Bạn có chắc rằng muốn xóa người dùng này?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a id="deleteBtn" type="button" class="btn btn-danger">Xóa</a>
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
    @endcan
</body>

</html>