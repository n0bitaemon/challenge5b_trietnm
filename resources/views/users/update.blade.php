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
                    <h1>Thay đổi thông tin</h1>
                    <p>Họ tên: {{ $user->fullname }}</p>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('users.post-update', ['id'=>$user->id]) }}" method="POST" enctype="multipart/form-data" class="form-block">
                        <div class="row g-3">
                            @csrf
                            <input name="id" type="hidden" value="{{ $user->id }}">
                            @can('access', App\Models\User::class)
                            <div class="col-md-6 col-sm-12">
                                <label for="userFullName" class="form-label">Họ tên</label>
                                <input name="fullname" type="text" value="{{ old('fullname', $user->fullname) }}" class="form-control" id="userFullName" placeholder="Nguyễn Văn A">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="userUsername" class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" value="{{ old('username', $user->username) }}" class="form-control" id="userUsername">
                                @error('username') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            @endcan
                            <div class="col-md-6 col-sm-12">
                                <label for="userEmail" class="form-label">Email</label>
                                <input name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control" id="userEmail" placeholder="abc@example.com">
                                @error('email') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="userPhone" class="form-label">Số điện thoại</label>
                                <input name="phone" type="tel" value="{{ old('phone', $user->phone) }}" class="form-control" id="userPhone" placeholder="0123456789">
                                @error('phone') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <label for="userAvatar" class="form-label">Upload avatar</label>
                                <input name="avatar" onchange="avatarToggle()" type="file" class="form-control" id="userAvatar" accept="image/*">
                                <label for="urlAvatar" class="form-label mt-3">Upload avatar from url</label>
                                <input name="url_avatar" onchange="avatarToggle()" value="{{ old('url_avatar') }}" type="text" class="form-control" id="urlAvatar">
                                @error('url_avatar') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                <div class="figure">
                                    <img style="width: 200px;" src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="Không thể hiển thị hình ảnh" class="my-3 rounded">
                                    <figcaption class="figure-caption text-center">Avatar hiện tại</figcaption>
                                </div>
                            </div>
                            <div class="col-12 mb-5">
                                <input type="submit" value="Cập nhật" class="btn btn-outline-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function avatarToggle(){
            let fileInput = document.querySelectorAll('input[name="avatar"]')[0];
            let urlInput = document.querySelectorAll('input[name="url_avatar"')[0];
            
            urlInput.disabled = fileInput.value ? true : false;
            fileInput.disabled = urlInput.value ? true : false;
        }
    </script>
</body>

</html>