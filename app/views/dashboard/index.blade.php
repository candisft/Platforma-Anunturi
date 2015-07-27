<!DOCTYPE html>
<html>
<head>
    <title>AdsGalati</title>
    <meta name="viewport" content="width=device-width">
    <meta charset="utf-8" >
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/animate.css" >
    <link rel="stylesheet" href="/css/perfect-scrollbar.min.css" >
    <link rel="stylesheet" href="/css/jquery-ui.min.css" >
    <link rel="stylesheet" href="/css/jquery-ui.structure.min.css" >
    <link rel="stylesheet" href="/css/jquery-ui.theme.min.css" >
    <link rel="stylesheet" href="/css/dashboard.css" >
    <link rel="stylesheet" href="/css/icon.css" >
    <link rel="stylesheet" href="/css/app-responsive.css" media="screen and (max-width: 655px)" >
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/jquery.iframe-transport.js"></script>
    <script src="/js/perfect-scrollbar.with-mousewheel.min.js"></script>
    <script src="/js/perfect-scrollbar.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
</head>
<body>
<body>
<div class="alert">
    <div class="alertcon">
    </div>
</div>
<div class="continut">
    <div class="logo"><span>Admin Panel</span><div class="logout">Delogeaza-ma</div></div>
    <div class="meniu">
        <ul>
            <li><a href="/administrator/dashboard"><img src="/img/avatar.png" alt="Avatar" />Salut, {{Auth::user()->nume}}</a></li>
           <li> <a href="/administrator/utilizatori"><span class="icon-users"></span>Utilizatori</a></li>
            <li><a href="/administrator/anunturi"><span class="icon-anunt"></span>Anunturi @if (Anunt::where('confirm', '0')->where('confirm_code', '')->count()>0) <div class="notificare">{{Anunt::where('confirm', '0')->where('confirm_code', '')->count()}}</div>@endif</a></li>
            <li><span class="icon-modanunt"></span>Modificari Anunturi @if (ModAnunt::count()>0) <div class="notificare">{{ModAnunt::count()}}</div>@endif</li>
            <li><a href="/administrator/plati"><span class="icon-pays"></span>Plati</a></li>
            <li><a href="/administrator/tichete"><span class="icon-suport"></span>Tichete @if (Ticket::count()>0) <div class="notificare">{{Ticket::count()}}</div>@endif</a></li>
        </ul>
    </div>
    <div class="content">
        @if ($data['ramura']=="dashboard")
          @yield('index')
        @elseif ($data['ramura']=="utilizatori")
          @yield('utilizatori')
        @elseif ($data['ramura']=="anunturi")
          @yield('anunturi')
        @elseif ($data['ramura']=="modanunturi")
        modanunturi
        @elseif ($data['ramura']=="plati")
          @yield('plati')
        @elseif ($data['ramura']="tichete")
          @yield('tickete')
        @else
        Error 404
        @endif
    </div>
</div>
<script src="/js/dashboard.js"></script>
</body>
</html>