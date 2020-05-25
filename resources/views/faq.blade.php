<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>FAQ :: saulprod</title>
        <meta property="og:title" content="saulprod" />
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
		<link rel="stylesheet" href="/css/loaderok.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="/js/jquery-1.8.3.js"></script>
 
		
    </head>
<body>
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
<img src="/img/side-bar/crash.png">
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
<img src="/img/side-bar/support.png" style="opacity: 1 !important;">
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
                <div class="rules">
        <div class="header">
            ВОПРОСЫ
            <span>Посл. обновление: 10/07/2018</span>
        </div>
        <div>
            <p><strong>ПОЧЕМУ ИНОГДА СЛУЧАЕТСЯ 1.00X/0X?</strong></p>
            <p>ЭТО РЕДКИЕ СЛУЧАИ И ОНИ СОЗДАНЫ ДЛЯ ТОГО, ЧТОБЫ ЛЮДИ НЕ ВЫВОДИЛИ НА 1.01Х КАЖДУЮ СТАВКУ.</p>
        </div>
        <div>
            <p><strong>Я ПОСТАВИЛ СТАВКУ, НО Я НЕ ХОТЕЛ.</strong></p>
            <p>МЫ НЕ МОЖЕМ ВЕРНУТЬ ВАМ ЕЁ, ДАЖЕ ЕСЛИ ОНА БЫЛА ПОСТАВЛЕНА СЛУЧАЙНО, БУДЬТЕ АККУРАТНЫ.</p>
        </div>
        <div>
            <p><strong>ЭТО ВСЁ РАБОТАЕТ ЧЕСТНО?</strong></p>
            <p>ДА, АБСОЛЮТНО, НАША СИСТЕМА РАБОТАЕТ ПО АЛГОРИТМУ SHA-256.</p>
        </div>
        <div>
            <p><strong>МОЙ ВЫВОД ОТКЛОНЁН, ЧТО ДЕЛАТЬ?</strong></p>
            <p>СКОРЕЕ ВСЕГО ВЫ ДОПУСТИЛИ ОШИБКУ В ВЕДЕНИИ ВАШЕГО НОМЕРА КИВИ/КАРТЫ, ПОВТОРИТЕ ПОПЫТКУ СНОВА.</p>
        </div>
        <div>
            <p><strong>СКОЛЬКО ПО ВРЕМЕНИ ПРОИЗВОДИТСЯ ВЫВОД?</strong></p>
            <p>ВЫВОД ОСУЩЕСТВЛЯЕТСЯ В ЗАВИСИМОСТИ ОТ НАГРУЗКИ НА НАШУ ПЛАТЕЖНУЮ СИСТЕМУ, ОН МОЖЕТ БЫТЬ ВЫПОЛНЕН ЗА 5 МИНУТ МИНИМУМ И ЗА 24 ЧАСА МАКСИМУМ.</p>
        </div>
        <div>
            <p><strong>КАК МНЕ СВЯЗАТЬСЯ С АДМИНИСТРАЦИЕЙ?</strong></p>
            <p>НАПИШИТЕ НАМ В СООБЩЕНИЯ ГРУППЫ </p>
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

        <div class="copyright copyright0">&copy; saulprod 2018</div>
        
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