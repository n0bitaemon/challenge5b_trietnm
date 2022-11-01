<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Đổi mật khẩu</title>
</head>

<body>
    @include('layouts.navbar')
    <section class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 mb-3">
                    <h1>Đổi mật khẩu</h1>
                    <p class="mb-0">Họ tên: {{ $user->fullname }}</p>
                    <p>Tên đăng nhập: {{ $user->username }}</p>
                </div>
                <div class="col-12">
                    <form action="{{ URL::route('users.post-password') }}" method="POST" class="form-block">
                        @csrf
                        <div class="row g-3">
                            <input name="id" type="hidden" value="{{ $user->id }}">
                            @cannot('ignorePassword', $user)
                            <div class="col-12">
                                <label for="oldPass" class="form-label">Mật khẩu cũ</label>
                                <input name="old_password" type="password" class="form-control" id="oldPass">
                                @error('old_password') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                @error('wrong_password') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            @endcannot
                            <div class="col-12">
                                <label for="newPass" class="form-label">Mật khẩu mới</label>
                                <input name="new_password" type="password" class="form-control" id="newPass">
                                @error('new_password') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <label for="rePass" class="form-label">Nhập lại mật khẩu</label>
                                <input name="new_password_confirmation" type="password"" class="form-control" id="rePass">
                            </div>
                            <div class="col-12 mb-5">
                                <input type="submit" value="Thay đổi" class="btn btn-outline-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>