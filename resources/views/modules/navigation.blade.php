<div class="navbar-header">
    <a href="{{ url('../') }}" class="navbar-brand">
        @include('modules.logo')
    </a>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".sq-global-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>

<nav class="collapse navbar-collapse sq-global-navbar-collapse" role="navigation">

    <ul class="nav navbar-nav">
        @if( Request::is('home', 'home/*') )

        @else
            {!! Html::navbarItem('pricing', 'Pricing') !!}
            {!! Html::navbarItem('', 'Docs') !!}

            @if( Auth::guest() )
                {!! Html::navbarItem('register', 'Get Started') !!}
            @elseif( Auth::check() )
                {!! Html::navbarItem('home', 'Dashboard') !!}
            @endif
        @endif

    </ul>

    <ul class="nav navbar-nav navbar-right">
        @if( Auth::guest() )
            {!! Html::navbarItem('login', 'Sign in') !!}
        @else

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Your account <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('settings') }}">Account Settings</a></li>
                    @if( auth()->user()->subscribed('main') )
                        <li class="divider"></li>
                        <li><a href="{{ route('billing') }}">Billing Settings</a></li>
                    <li><a href="{{ route('invoices') }}">Payment History</a></li>
                    @endif
                    <li class="divider"></li>
                    <li><a href="#">Send Feedback...</a></li>
                    <li><a href="#">Send Invites...</a></li>

                    @if( Auth::check() and Auth::user()->isAdmin() )
                        <li class="divider"></li>
                        {!! Html::navbarItem('admin', 'Admin Dashboard') !!}
                    @endif

                    <li class="divider"></li>
                    <li>{!! Html::navbarLogout('logout', 'Sign out') !!}</li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </li>

        @endif
    </ul>

</nav>