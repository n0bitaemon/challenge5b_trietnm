<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Login</title>
</head>

<body>
    <div class="jumbotron d-flex align-items-center h-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="container block-login">
                        <div class="row justify-content-center">
                            <h1 class="col-12 mt-5 mb-3 text-center">Đăng nhập</h1>
                            <form action="{{ URL::route('login-auth') }}" method="POST" class="col-6 justify-content-center mb-5">
                                @csrf
                                <div class="mb-3">
                                    <label for="inputUsername" class="form-label">Tài khoản</label>
                                    <input name="username" value="{{ old('username') }}" type="text" class="form-control" id="inputUsername" placeholder="">
                                    @error('username') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="inputPassword" class="form-label">Mật khẩu</label>
                                    <input name="password" type="password" class="form-control" id="inputPassword">
                                    @error('password') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                </div>
                                @error('wrong_credentials') <p class="text-danger validate-err">{{ $message }}</p> @enderror
                                <div class="my-3">
                                    <button class="btn btn-outline-success">Đăng nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>