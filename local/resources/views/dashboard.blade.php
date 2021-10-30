<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../favicon.ico">
    <!--<link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/navbar-fixed-top/">-->

    <title>Persediaan - Beranda</title>

    <!-- Bootstrap core CSS -->
    <link href="{{$baseurl}}/bootstrap337/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{$baseurl}}/bootstrap337/css/bootstrap-cosmo.min.css" rel="stylesheet">
    <link href="{{$baseurl}}/bootstrap337/css/navbar-fixed-top.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{$baseurl}}/bootstrap337/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link rel="stylesheet" href="{{$baseurl}}/bootstrap337/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{$baseurl}}/bootstrap337/css/chosen.css" />
	
    <!-- Custom styles for this template -->
    <!--<link href="navbar-fixed-top.css" rel="stylesheet">-->
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{$baseurl}}/bootstrap337/js/ie-emulation-modes-warning.js"></script>
	<script src="{{$baseurl}}//bootstrap337/js/jquery.min.js"></script>
	<script src="{{$baseurl}}//bootstrap337/js/jquery-ui.js"></script>
	
	<!--<script src="{{$baseurl}}//bootstrap337/js/alertify.core.js"></script>-->
	<!--<script src="{{$baseurl}}//bootstrap337/js/alertify.bootstrap.js"></script>-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{$baseurl}}/beranda">Persediaan</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">{{ session('username') }}</a></li>
            <li><a href="{{$baseurl}}/input/show">Input Barang</a></li>
            <li><a href="{{$baseurl}}/simpan/show">Simpan Barang</a></li>
            <li><a href="{{$baseurl}}/saldo/show">Saldo Barang</a></li>
            <li><a href="{{$baseurl}}/keluar/show">Keluar Barang</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Referensi <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{$baseurl}}/ref/barang/show">Barang</a></li>
                <li><a href="{{$baseurl}}/ref/lokasi/show">Lokasi</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
			  <form method="post" class="navbar-form navbar-left" action="{{ \URL::to('/logout') }}">
				  {{ csrf_field() }}
				<button type="submit" class="btn btn-default">Logout</button>
			  </form>
			</li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container" id="konten">
	  @yield('content')
      

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="{{$baseurl}}/bootstrap337/js/jquery.min.js"></script>-->
    <!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
    <script src="{{$baseurl}}/bootstrap337/js/bootstrap.min.js"></script>
    <script src="{{$baseurl}}/bootstrap337/js/jquery.dataTables.min.js"></script>
    <script src="{{$baseurl}}/bootstrap337/js/chosen.jquery.js"></script>
    <!--<script src="{{$baseurl}}/bootstrap337/js/alertify.js"></script>-->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{$baseurl}}/bootstrap337/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
