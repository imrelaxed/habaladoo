<!doctype html>
<html lang="en" role="document">

  @include('base.head')
  <script src="https://d26b395fwzu5fz.cloudfront.net/{{ $keen_io_api_version or '3.2.4' }}/keen.min.js"></script>
  @yield('keen')

  <body class="page page--admin clearfix">
      
      <aside class="sidebar full-height top-layer text-center">
        <nav role="navigation">

          {!! Html::navItem('/admin', 'Settings', 'cog') !!}
          {!! Html::navItem('/admin/users', 'Users', 'users') !!}
          {!! Html::navItem('/admin/plans', 'Plans', 'birthday-cake') !!}
          {!! Html::navItem('/admin/developer-zone', 'Developer Zone', 'code') !!}
          {!! Html::navItem('/admin/analytics', 'Analytics', 'bar-chart') !!}
          {!! Html::navItem('/admin/engine-room', 'Engine Room', 'key') !!}
          {!! Html::navItem('/admin/logout', 'Sign out', 'sign-out', 'bottom') !!}

        </nav>
      </aside>

      <header class="header">
        <h1 class="header__title">{{ $title }}</h1>
      </header>

      <main>
      @yield('content')
      </main>
   
    @include('base.scripts')
    <script src="/js/admin/admin.js"></script>

  </body>
</html>
