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
                        @if($user->avatar)
                        <div class="col-lg-3 col-sm-12">
                            <img style="width: 200px;" src="{{ asset('avatars/'.$user->avatar) }}" alt="" class="my-3 rounded">
                        </div>
                        @endif
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
                @if(!$user->is_teacher)
                <div class="col-7 mb-3">
                    <a class="h3" href="#exerciseHistory" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="exerciseHistory">Lịch sử làm bài</a>
                    @php
                    $exerciseAnswers = App\Models\ExerciseAnswer::where('user_id', '=', $user->id)->get();
                    $exerciseCount = App\Models\Exercise::where('is_published', '=', 1)->count();
                    @endphp
                    <div class="collapse" id="exerciseHistory">
                        <p>Đã hoàn tất <b>{{ $exerciseAnswers->count().' / '.$exerciseCount }}</b> bài tập</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên bài</th>
                                    <th scope="col">Thời gian nộp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exerciseAnswers as $answer)
                                @php $exercise = App\Models\Exercise::find($answer->exercise_id, ['title']) @endphp
                                <tr>
                                    <th scope="row">{{ $loop->index }}</th>
                                    <td><a href="{{ URL::route('exercises.detail', ['id'=>$answer->exercise_id]) }}">{{ $exercise->title }}</a></td>
                                    <td>{{ $answer->answer_time }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-7 mb-3">
                    <a class="h3" href="#quizHistory" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="quizHistory">Lịch sử giải đố</a>
                    @php
                    $quizAnswers = App\Models\QuizAnswer::where('user_id', '=', $user->id)->get();
                    $quizCount = App\Models\Quiz::where('is_published', '=', 1)->count();
                    @endphp
                    <div class="collapse" id="quizHistory">
                        <p>Đã hoàn tất <b>{{ $quizAnswers->count().' / '.$quizCount }}</b> câu đố</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên bài</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quizAnswers as $quizAnswer)
                                @php $quiz = App\Models\Quiz::find($quizAnswer->quiz_id, ['title']); @endphp
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td><a href="#">{{ $quiz->title }}</a></td>
                                    <td>{{ $quizAnswer->answer_time }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @can('send', $user)
                @php 
                $messages = App\Models\Message::where([
                    ['from_id', '=', Request::user()->id], 
                    ['to_id', '=', $user->id]
                ])->get();
                @endphp
                <div class="col-12 mb-3">
                    <a class="h3" href="#userMessages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="userMessages">Tin nhắn đã gửi</a>
                    
                    <div class="collapse show" id="userMessages">
                        @if($messages->count() === 0) <p>Bạn chưa gửi tin nhắn nào đến người này</p>
                        @else <p>Đã gửi <b>{{ $messages->count() }}</b> tin nhắn</p> @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Ngày gửi</th>
                                    <th scope="col">Nội dung</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $msg)
                                <tr>
                                    <td>{{ $msg->send_time }}</td>
                                    <td>{{ $msg->content }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" onclick="setMsgUpdate({{ $msg->id }}, '{{ $msg->content }}')" data-bs-toggle="modal" data-bs-target="#updateMsgModal">Chỉnh sửa</a>
                                        <a class="btn btn-sm btn-outline-danger" onclick="setMsgDelete({{ $msg->id }})" data-bs-toggle="modal" data-bs-target="#deleteMsgModal">Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form action="{{ URL::route('users.messages.send') }}" method="POST" class="form-block">
                            @csrf
                            <input name="to_id" type="hidden" value="{{ $user->id }}" >
                            <div class="mb-3">
                                <label for="inputMessage" class="form-label">Nhập tin nhắn</label>
                                <textarea name="content" id="inputMessage" cols="30" rows="5" class="form-control">{{ old('content') }}</textarea>
                                @error('content') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <input type="submit" value="Gửi tin nhắn" class="btn btn-outline-success">
                        </form>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </section>

    @can('delete', $user)
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
                    <a href="{{ URL::route('users.delete', ['id'=>$user->id]) }}" type="button" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>
    <!--End delete modal-->
    @endcan
    <!--Update message modal-->
    <div class="modal fade" id="updateMsgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <form action="{{ URL::route('users.messages.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="msgUpdateId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thay đổi tin nhắn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Nhập nội dung tin nhắn mới</p>
                        <textarea name="content" id="msgContent" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Chỉnh sửa" class="btn btn-primary">
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
                    <form action="{{ URL::route('users.messages.delete') }}" method="POST">
                        @csrf
                        <input id="msgDeleteId" name="id" type="hidden">
                        <input type="submit" value="Xóa" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End delete message modal-->

    <script>
        function setMsgDelete(id){
            let msgId = document.getElementById("msgDeleteId");
            msgId.value = id;
        }

        function setMsgUpdate(id, content){
            console.log(id);
            let msgId = document.getElementById("msgUpdateId");
            let msgContent = document.getElementById("msgContent");

            msgId.value = id;
            msgContent.innerText = content;
        }

    </script>
</body>

</html>