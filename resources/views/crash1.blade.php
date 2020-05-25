<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Crash :: STOREGAMER.RU</title>
        <meta property="og:title" content="STOREGAMER.RU" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta name="description" content="Play with Your Friends and Win Skins!">
		<meta name="keywords" content="csgojackpot, csgo, wild, coin flip, item, jackpot, raffle, roulette">


        <meta name="csrf-token" content="63rWLQI6W2YMswWrBZLCww00RRFrqaq8AjeJtALr" />
        <meta name="language" content="en" />
        <meta name="websocket" content=":8080" /> 
        <meta name="game" content="crash" />
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
		<link rel="stylesheet" href="/css/app.css">
		<link rel="stylesheet" href="/css/loaderok.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="/js/jquery-1.8.3.js"></script>		

		
    </head>
<body>=
  
<div class="loaderArea">
  <div id="loader"></div>
</div>
<div class="page-content">
<nav class="navbar">
<div id="sidebar-wrapper" style="background: #1A1D26;border-left: 0px solid transparent!important;">
<ul id="sidebar-nav sidebarshow" class="sidebar-nav sidebarshow">
<div class="toggle menu-toggle-button">
      <i class="fa fa-angle-right" style="color: #15181F;font-weight: 700;"></i>
</div>
@if (Auth::check())
<li class="account">
<div class="avatar">
<img src="{{Auth::user()->avatar}}">
<span class="welcome1"> МЕНЮ САЙТА </span>
</div>

</li>
@else
<li class="test123">
<a href="/vklogin">
<div class="icon">
<i class="fa fa-vk" aria-hidden="true"></i>
</div>
<span class="sidespan sidespanvisible">ВОЙТИ ВК</span>
</a>
</li>
@endif
<li>
<a href="/">
<div class="icon">
<img src="/img/side-bar/roul.png">
</div>
<span class="sidespan sidespanvisible">РУЛЕТКА</span>
</a>
</li>
<li>
<a href="/coinflip">
<div class="icon">
<img src="/img/side-bar/flip.png">
</div>
<span class="sidespan sidespanvisible">МОНЕТКА</span>
</a>
</li>
<li>
<a href="/jackpot">
<div class="icon">
<img src="/img/side-bar/jackpot.png">
</div>
<span class="sidespan sidespanvisible">КЛАССИК</span>
</a>
<li style="border-bottom: 4px solid #15181F;">
<a href="/crash">
<div class="icon">
<img src="/img/side-bar/crash.png" style="opacity: 1 !important;">
</div>
<span class="sidespan sidespanvisible">КРАШ</span>
</a>
</li>
@if (Auth::check())
<li>
<a href="/user/profile">
<div class="icon">
<img src="/img/side-bar/account.png">
</div>
<span class="sidespan sidespanvisible">ПРОФИЛЬ</span>
</a>
</li>
<li style="border-bottom: 4px solid #15181F;">
<a href="/user/referrals">
<div class="icon">
<img src="/img/side-bar/stats.png">
</div>
<span class="sidespan sidespanvisible">ПАРТНЕРКА</span>
</a>
</li>
<li>
<a href="/user/deposit">
<div class="icon">
<img src="/img/side-bar/funds.png">
</div>
<span class="sidespan sidespanvisible">ПОПОЛНИТЬ</span>
</a>
</li>
<li style="border-bottom: 4px solid #15181F;">
<a href="/user/withdraw">
<div class="icon">
<img src="/img/side-bar/shop.png">
</div>
<span class="sidespan sidespanvisible">ВЫВОД</span>
</a>
</li>
@endif
<li>
<a href="/faq">
<div class="icon">
<img src="/img/side-bar/support.png">
</div>
<span class="sidespan sidespanvisible">ВОПРОСЫ</span>
</a>
</li>
@if (Auth::check())
<li style="border-bottom: 4px solid #15181F;">
<a href="/auth/logout">
<div class="icon">
<i class="fa fa-power-off"></i>
</div>
<span class="sidespan sidespanvisible">ВЫЙТИ</span>
</a>
</li>
@endif
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
</ul>
</div>

<div class="footer1" style="width: 75px;">
      <div class="data">

        <div class="online sidebarshow1"><div class="copyright"><img src="/img/icons-small/players.png"> <span class="players-online">0</span></div>
		 
</div>
      </div>


    </div>
</nav>

<div class="center">

<div class="top-navigation">
        <div class="circleButton sound-toggle-button"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
		@if (Auth::check())
        <div class="circleButton1 balance" data-balance="{{Auth::user()->wallet}}"><a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;</a> <span class="value">{{Auth::user()->wallet}}</span></div>
		@endif
</div>

	<center>
		<img src="/img/official.png" style="width: 350px;margin-top: -60px;margin-bottom: -40px;">
	</center>
    <div class="main-wrapper">
        <main>
						<br>
				<br>
				<br>
                <div class="crash">
            <div class="top">
                <div class="top-box box-chart">
                    <div class="chart"></div>
                    <div class="chart-info"></div>
                </div>
                <div class="boxes">
                    <div class="top-box box-bet">
                        <div class="way">
                            <div class="manual-way active" data-show="manual" onclick="crash.setWay(this)">Ручной</div>
                            <div class="automatic-way" data-show="automatic" onclick="crash.setWay(this) ">Автомат.</div>
                        </div>
                        <div class="manual-way-content" style="display: block;">
                            <div class="input-group">
                                <label for="bet-coins">Ставка: <span>(мин <span class="min-bet">10</span>, макс <span class="max-bet">100,000</span>)</span> </label>
                                <input id="bet-coins" type="number" step="100" value="0" min="0">
                            </div>
                            <div class="input-group">
                                <label for="bet-cashout">Авто вывод в (0 = отключен): </label>
                                <input type="number" min="1" step="0.01" value="2" id="bet-cashout">
                            </div>

                            <button class="bet-butt active" onclick="crash.bet()">PLACE YOUR BET</button>
                        </div>
                        <div class="automatic-way-content" style="display: none;">
                            <div class="input-group">
                                <label for="autobet-coins">Начало: <span>(мин <span class="min-bet">100</span> , макс <span class="max-bet">100,000</span>)</span> </label>
                                <input id="autobet-coins" type="number" step="100" value="0" min="0">
                            </div>
                            <div class="custom-row">
                                <div class="col-6">
                                    <div class="input-group">
                                        <label for="autobet-cashout">Авто вывод в (Мультипликатор): </label>
                                        <input type="number" min="1" step="0.01" value="2" id="autobet-cashout">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <label for="autobet-limit">Остановить если больше чем: </label>
                                        <input type="number" value="0" min="0" step="100" id="autobet-limit">
                                    </div>
                                </div>
                            </div>
                            <div class="custom-row radios">
                                <div class="col-5">
                                    <label class="without-input">При победе: </label>
                                    <div class="radio-group">
                                        <input type="radio" name="autobet-on-win" id="autobet-on-win-multiply-select">
                                        <label for="autobet-on-win-multiply-select">Умножить на</label>
                                        <input type="number" min="0.01" value="2" step="0.01" id="autobet-on-win-multiply">
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" name="autobet-on-win" id="autobet-on-win-back" checked>
                                        <label for="autobet-on-win-back">Вернуть начальную ставку</label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label class="without-input">При проигрыше: </label>
                                    <div class="radio-group">
                                        <input type="radio" name="autobet-on-lose" id="autobet-on-lose-multiply-select">
                                        <label for="autobet-on-lose-multiply-select">Умножить на</label>
                                        <input type="number" min="0.01" value="2" step="0.01" id="autobet-on-lose-multiply">
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" name="autobet-on-lose" id="autobet-on-lose-base" checked>
                                        <label for="autobet-on-lose-base">Вернуть начальную ставку</label>
                                    </div>
                                </div>
                                <div class="col-2 autobet-max-bets-container input-group">
                                    <label for="autobet-max-bets">Макс. ставки: </label>
                                    <input class="custom" type="number" min="0" value="0" step="1" id="autobet-max-bets">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <button class="autobet-butt" state="idle" onclick="crash.autobet()"></button>
                        </div>
                    </div>
                    <div class="top-box box-history bottomFade">
                        <div class="title">История</div>
                        <div class="history">

                        </div>
                    </div>
                </div>
            </div>
            <div class="box-bets">
                <table>
                    <tr> <td>Игроки</td> <td>Ставка</td> <td>X</td> <td>Прибыль</td> </tr>
                </table>
            </div>
        </div>
        </main>
    </div>
</div>

<div class="chat">
	<div class="toggle chat-toggle-button">
      <i class="fa fa-angle-left" style="color: #15181F;"></i>
    </div>
    <div class="chat-header chatheader0">
        <div class="text">
            ЧАТ
        </div>
    </div>
    <div class="chat-header chatheader1 chatheaderhide">
        <div class="text">
            ЧАТ
        </div>
    </div>
    <div class="chat-messages">
    </div> 
    @if (Auth::check())
    <div class="send-area">
                    <div class="input-area">
                <input type="text" class="chat-input" placeholder="ВАШЕ СООБЩЕНИЕ..." maxlength="75" pattern="[A-Za-z0-9_./!?,$+-= ]{1,75}" required>
                <div class="emots-button">
                    <img src="/img/misc/emots-button.png">
                </div>
                <div class="emots"></div>
            </div>
            <img src="/img/chat-send-img.png" class="send-message">
            </div>
    @else
    <div class="send-area">
                    <a href="/vklogin" class="need-sign-in">
                <img src="/img/misc/sign-in-for-chat.png">
            </a>
            </div>
    @endif
	<div class="footer" style="width: 303px;">
      <div class="data">
        <div class="social">
          <a href="https://vk.com/ullubiygaming" target="_blank"><i class="fa fa-vk"></i></a>
        </div>

        <div class="copyright copyright0">&copy; STOREGAMER.RU 2018</div>
        
        <div class="legal">
          <a href="/terms" target="_blank">УСЛОВИЯ ИСПОЛЬЗОВАНИЯ</a>
           <a class="chat-info" style="cursor: pointer;">ПРАВИЛА</a>
        </div>

      </div>


    </div>
</div>
<div class="popup">
    <div class="popup-inner">
        <div class="popup-title">
            ПРАВИЛА
            <div class="popup-close">x</div>
        </div>
        <div class="content">
            <p>В ЧАТЕ ЗАПРЕЩЕНО:</p>
            <ul>
                <li>ИСПОЛЬЗОВАТЬ НЕНОРМАТИВНУЮ ЛЕКСИКУ - МАТЫ И ПРОЧЕЕ.</li>
                <li>ОСКОРБЛЯТЬ ДРУГ-ДРУГА, А ТАКЖЕ АДМИНИСТРАЦИЮ САЙТА!</li>
                <li>НЕГАТИВНЫЕ СООБЩЕНИЯ В СТОРОНУ САЙТА, ЕГО ГРУППЫ И Т.Д.</li>
                <li>СПАМ И ДУБЛИРОВАНИЕ СООБЩЕНИЙ.</li>
                <li>ЗАПРЕЩЕНО ПИСАТЬ ПРОМОКОДЫ В ЧАТ.</li>
                <li>ПОПРОШАЙНИЧЕСТВО В ЛЮБЫХ ЕГО ПРОЯВЛЕНИЯХ.</li>
                <li>СООБЩЕНИЯ, НАПИСАННЫЕ ЗАГЛАВНЫМИ БУКВАМИ.</li>
            </ul>


            <p><button class="popup-close">Я ПОНЯЛ</button></p>
        </div>
    </div>
</div>

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

    <script src="/js/crash.js"></script>
@if((Auth::check()) && ((Auth::user()->rank == 'user') || (Auth::user()->rank == 'gold') || (Auth::user()->rank == 'diamond') || (Auth::user()->rank == 'streamer')))<script src="/js/chat.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat57NRz4.js"></script>
@else<script src="/js/chat.js"></script>
@endif
    <script src="/js/HackTimerWorker.min.js"></script>
    <script src="/js/HackTimer.silent.min.js"></script>
    <script src="/js/app.js"></script>
	<script>
  $(window).on('load', function () {
    $preloader = $('.loaderArea'),
      $loader = $preloader.find('.loader');
    $loader.fadeOut();
	$preloader.delay(350).fadeOut('slow');
  });
</script>
</body>
</html>
