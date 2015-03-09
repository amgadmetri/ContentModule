<html>
<head>
	<title>Content Module</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tokenize.css') }}">
</head>

<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Content Management</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="{{ url('content') }}">Home</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
						<li><a href="{{ url('ACL/login') }}">Login</a></li>
						<li><a href="{{ url('ACL/register') }}">Register</a></li>
						@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('ACL/logout') }}">Logout</a></li>
							</ul>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
		<!-- sidebar start -->
		
		<div class="row row-offcanvas row-offcanvas-left">
			<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
				<p class="visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
				</p>
				<div class="well sidebar-nav">
					<ul class="nav">
						<li>Manage Contents </li>
						<li class="active"><a href="{{ url('/content') }}">All Contents</a></li>
						<li><a href="{{ url('/content/create') }}">Add Content</a></li>
						<li>Manage Tags</li>
						<li><a href="{{ url('/content/tags/view') }}">All Tags</a></li>
						<li><a href="{{ url('/content/tags/create') }}">Add Tag</a></li>
						<li>Manage Sections</li>
						<li><a href="{{ url('/content/sections/view') }}">All Sections</a></li>
						<li><a href="{{ url('/content/sections/create') }}">Add Section</a></li>
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- sidebar ends -->
			
					@yield('content')

			<!-- Scripts -->
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script src="{{ asset('js/jquery.tokenize.js') }}"></script>
    <script type="text/javascript">
        $('#tokenize').tokenize();
    </script>
		</body>

</html>