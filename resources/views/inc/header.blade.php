<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="/">PERSONAL TASK MANAGER</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      @if (Route::has('login'))
          @auth
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/time-blocks') }}">Журнал</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/tasks') }}">Задачи</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/stat') }}">Статистика</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/categories') }}">Категории</a>
              </li>
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 {{ Auth::user()['name'] }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarUser">
                    <a class="dropdown-item" href="{{ url('/settings') }}">Настройки</a>
                    <a class="dropdown-item" href="{{ url('/logout') }}">Выход</a>
                </div>
              </li>              
          @else
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/login') }}">Войти</a>
              </li>
              @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/register') }}">Регистрация</a>
                  </li>
              @endif
          @endif
      @endif
      </ul>	
    </div>
  </div>
</nav>