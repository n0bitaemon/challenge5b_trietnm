<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <title>Tin nhắn</title>
</head>
<body>
    @include('layouts.navbar')
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Tin nhắn của bạn</h1>
                <table class="table">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Người gửi</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Ngày gửi</th>                        
                    </thead>
                    <tbody>
                        @foreach($messages as $msg)
                        @php $sender = App\Models\User::find($msg->from_id, ['fullname']) @endphp
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td><a href="{{ URL::route('users.profile', ['id'=>$msg->to_id]) }}">{{ $sender->fullname }}</a></td>
                            <td>{{ $msg->content }}</td>
                            <td>{{ $msg->send_time }}</td>
                        <tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
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
</body>
</html>