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
                    <h1>Thêm học sinh mới</h1>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('users.post-add') }}" method="POST" enctype="multipart/form-data" class="form-block">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 col-sm-12">
                                <label for="userFullname" class="form-label">Họ tên</label>
                                <input name="fullname" type="text" value="{{ old('fullname') }}" class="form-control" id="userFullname" placeholder="Nguyễn Văn A">
                                @error('fullname') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="userUsername" class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" value="{{ old('username') }}" class="form-control" id="userUsername">
                                @error('username') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <label for="userPassword" class="form-label">Mật khẩu</label>
                                <input name="password" type="password" class="form-control" id="userPassword">
                                @error('password') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <label for="userRepassword" class="form-label">Nhập lại mật khẩu</label>
                                <input name="password_confirmation" type="password" class="form-control" id="userRepassword">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="userEmail" class="form-label">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="form-control" id="userEmail" placeholder="abc@example.com">
                                @error('email') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="userPhone" class="form-label">Số điện thoại</label>
                                <input name="phone" type="tel" value="{{ old('phone') }}" class="form-control" id="userPhone" placeholder="0123456789">
                                @error('phone') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12 mb-5">
                                <input type="submit" value="Tạo mới" class="btn btn-outline-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>