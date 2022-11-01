<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Thông tin người dùng</title>
</head>

<body>
    @include('layouts.navbar')

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <img style="width: 200px;" src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="" class="my-3 rounded">
                        </div>
                        <div class="col-lg-9 col-sm-12 pt-5">
                            <h1>Thông tin cơ bản</h1>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Họ tên</td>
                                        <td>{{ $user->fullname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại</td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @can('update', $user)
                            <a href="{{ URL::route('users.get-update', ['id'=>$user->id]) }}" class="btn btn-outline-success">Cập nhật</a>
                            <a href="{{ URL::route('users.get-password', ['id'=>$user->id]) }}" class="btn btn-outline-primary">Đổi mật khẩu</a>
                            @endcan
                            @can('delete', $user)
                            <a href="{{ URL::route('users.delete', ['id'=>$user->id]) }}" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-7 mb-3">
                    <a class="h3" href="#exerciseHistory" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="exerciseHistory">Lịch sử làm bài</a>
                    <div class="collapse" id="exerciseHistory">
                        <p>Đã hoàn tất <b>6/10</b> bài tập</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên bài</th>
                                    <th scope="col">Thời gian nộp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><a href="#">exercise_title</a></td>
                                    <td>ex_submit_time</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-7 mb-3">
                    <a class="h3" href="#quizHistory" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="quizHistory">Lịch sử giải đố</a>
                    <div class="collapse" id="quizHistory">
                        <p>Đã hoàn tất <b>6/9</b> câu đố</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên bài</th>
                                    <th scope="col">Kết quả</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><a href="#">quiz_title</a></td>
                                    <td>Đúng/Sai</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <a class="h3" href="#userMessages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="userMessages">Tin nhắn đã gửi</a>
                    <div class="collapse show" id="userMessages">
                        <p>Đã gửi <b>5</b> tin nhắn</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Ngày gửi</th>
                                    <th scope="col">Nội dung</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <body>
                                <tr>
                                    <td>msg_create_date</td>
                                    <td>msg_content</td>
                                    <td>
                                        <form action="profile.php" method="POST">
                                            <input name="id" type="hidden" value="msg_id">
                                            <input name="receiver" type="hidden" value="msg_receiver_id">
                                            <a class="btn btn-sm btn-outline-primary" onclick="setMsgUpdate(msg_id)" data-bs-toggle="modal" data-bs-target="#updateMsgModal">Chỉnh sửa</a>
                                            <a class="btn btn-sm btn-outline-danger" onclick="setMsgDelete(msg_id)" data-bs-toggle="modal" data-bs-target="#deleteMsgModal">Xóa</a>
                                        </form>
                                    </td>
                                </tr>
                            </body>
                        </table>
						<p>Bạn chưa gửi tin nhắn nào đến người này</p>
                        <form action="profile.php" method="POST" class="form-block">
                            <input name="sender" type="hidden" value="user_session_id">
                            <input name="receiver" type="hidden" value="user_profile_id" >
                            <div class="mb-3">
                                <label for="inputMessage" class="form-label">Nhập tin nhắn</label>
                                <textarea name="message" id="inputMessage" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <input type="submit" value="Gửi tin nhắn" name="send_msg" class="btn btn-outline-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Delete modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc rằng muốn xóa người dùng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <!--End delete modal-->
    <!--Update message modal-->
    <div class="modal fade" id="updateMsgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <form action="profile.php" method="POST">
                <input type="hidden" name="id" id="msgUpdateIdInput">
                <input type="hidden" name="receiver" id="receiverUpdateIdInput">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thay đổi tin nhắn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Nhập nội dung tin nhắn mới</p>
                        <input id="msgUpdateContent" name="message" type="text" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input name="update_msg" type="submit" value="Chỉnh sửa" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--End update message modal-->
    <!--Delete message modal-->
    <div class="modal fade" id="deleteMsgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa tin nhắn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xóa tin nhắn này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="profile.php" method="POST">
                        <input id="msgDeleteIdInput" name="id" type="hidden">
                        <input id="receiverDeleteIdInput" name="receiver" type="hidden">
                        <input name="delete_msg" type="submit" value="Xóa" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End delete message modal-->

    <script>
        function setMsgDelete(msgId, receiverId){
            let msgIdInput = document.getElementById("msgDeleteIdInput");
            let receiverIdInput =  document.getElementById("receiverDeleteIdInput");

            msgIdInput.value = msgId;
            receiverIdInput.value = receiverId;
        }

        function setMsgUpdate(msgId, receiverId){
            let msgIdInput = document.getElementById("msgUpdateIdInput");
            let receiverIdInput = document.getElementById("receiverUpdateIdInput");

            msgIdInput.value = msgId;
            receiverIdInput.value = receiverId;
        }

    </script>
</body>

</html>