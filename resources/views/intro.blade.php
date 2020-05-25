<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Games :: STOREGAMER.RU</title>
    <meta property="og:title" content="STOREGAMER.RU" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="/" />
    <meta name="description" content="Play with Your Friends and Win Skins!">
    <meta name="keywords" content="csgojackpot, csgo, wild, coin flip, item, jackpot, raffle, roulette">


    <meta name="csrf-token" content="63rWLQI6W2YMswWrBZLCww00RRFrqaq8AjeJtALr" />
    <meta name="language" content="en" />
	<meta name="websocket" content=":8080" />
    <meta name="game" content="other" />
    <meta name="logged" content="@if (Auth::check()){{1}}@else{{0}}@endif" />
    <meta name="steamid" content="@if (Auth::check()){{Auth::user()->steamid}}@endif" />
    <meta name="username" content="@if (Auth::check()){{Auth::user()->username}}@endif"/>
    <meta name="avatar" content="@if (Auth::check()){{Auth::user()->avatar}}@endif"/>
    <meta name="token" content="{{$token}}"/>
    <meta name="tradeURL" content="@if (Auth::check() && Auth::user()->tradeurl){{'https://steamcommunity.com/tradeoffer/new/?partner='.(substr(Auth::user()->steamid,7) - 7960265728).'&token='.Auth::user()->tradeurl}}@endif"/>
    <meta name="time" content="{{$time}}"/>
    
    <meta name="viewport" content="width=1400, initial-scale=1">
    <meta name="google-site-verification" content="1X4JxaLG_AM6F9u410Q6K4XL9HuqJjntjN3k8dmJ53E" />

    <link rel="icon" type="image/png" href="/favicon.png" />

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <script src="/js/jquery-1.8.3.js"></script>
    
    <style>
        .lobby .container .buttons .btn-1e {
           overflow: hidden;
           width: 200px;
           text-align: center;
           font-family: Titillium,sans-serif !important;
       }

       .lobby .container .buttons .btn:nth-of-type(1) {
        color: #fefefe;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn:nth-of-type(2) {
        color: #fefefe;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn:nth-of-type(3) {
        color: #fefefe;
        border: 2px solid #48d257;
    }
    .lobby .container .buttons .btn:nth-of-type(4) {
        color: #fefefe;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn:nth-of-type(1):hover {
        color: #161616;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn:nth-of-type(2):hover {
        color: #161616;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn:nth-of-type(3):hover {
        color: #161616;
        border: 2px solid #48d257;
        animation: pulse 3.5s cubic-bezier(0.4, 0, 1, 1) infinite;
    }
    .lobby .container .buttons .btn:nth-of-type(4):hover {
        color: #161616;
        border: 2px solid #48d257;
    }

    .lobby .container .buttons .btn-1e:after {
        width: 100%;
        height: 0;
        top: 50%;
        left: 50%;
        color: #161616;
        font-family: Titillium,sans-serif;
        background: #48d257;
        opacity: 0;
        transform: translateX(-50%) translateY(-50%) rotate(60deg);
    }
    .lobby {
        margin: 0;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        height: 100vh;
        background: url(/img/background.png) repeat 50%!important;
        background-size: cover;
        font-family: Titillium,sans-serif;
    }
</style>
</head>


</head>
<body class="lobby">

    <div class="main-wrapper">
        <main>
           <div class="roulette">
            <div class="container">
               <center style="font-weight: 700; font-size: 50px;margin-bottom: 15px;">ВЫБРАТЬ РЕЖИМ</center>
               <div class="buttons">
                  <button class="btn btn-3 btn-1e" onclick="window.location.href='/roulette'" href="/roulette">РУЛЕТКА</button>
                  <button class="btn btn-5 btn-1e" onclick="window.location.href='/coinflip'" href="/coinflip">Монетка</button>
                  <button class="btn btn-1 btn-1e" onclick="window.location.href='/jackpot'" href="/jackpot">КЛАССИК</button>
                  <button class="btn btn-4 btn-1e" onclick="window.location.href='/crash'" href="/crash">КРАШ</button>
              </div>
              
          </div>
      </div>
  </main>
</div>

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

<script src="/js/HackTimerWorker.min.js"></script>
<script src="/js/HackTimer.silent.min.js"></script>
@if((Auth::check()) && ((Auth::user()->rank == 'user') || (Auth::user()->rank == 'gold') || (Auth::user()->rank == 'diamond') || (Auth::user()->rank == 'streamer')))<script src="/js/chat.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat57NRz4.js"></script>
@else<script src="/js/chat.js"></script>
@endif
<script src="/js/app.js"></script>
</body>
</html>