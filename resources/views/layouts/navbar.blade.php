<header class="main-header fixed-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg main-nav px-0">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ URL::route('index') }}">TrietEdu</a>
                    <div id="mainMenu">
                        <ul class="navbar-nav ml-auto text-uppercase f1">
                            <li>
                                <a href="{{ URL::route('exercises.index') }}" class="@if(Request::is('exercise*')) active @endif">Bài tập</a>
                            </li>
                            <li>
                                <a href="{{ URL::route('quizzes.index') }}" class="@if(Request::is('quiz*')) active @endif">Quiz</a>
                            </li>
                            <li>
                                <a href="{{ URL::route('users.index') }}" class="@if(Request::is('user**')) active @endif">Lớp học</a>
                            </li>
                            <li>
                        </ul>
                    </div>
                    <div id="avatar">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  {{ Request::user()->fullname }}
                                </a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{ URL::route('users.profile') }}">Thông tin cá nhân</a></li>
                                  <li><a class="dropdown-item" href="{{ URL::route('users.get-update') }}">Cập nhật hồ sơ</a></li>
                                  <li><a class="dropdown-item" href="{{ URL::route('users.messages.get') }}">Tin nhắn</a></li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li><a class="dropdown-item" href="{{ URL::route('logout') }}">Đăng xuất</a></li>
                                </ul>
                              </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>
    </header>