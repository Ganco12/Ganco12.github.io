@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Панель управления</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Статистика
	<small>пополнения</small>
</h1>

<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
			<div class="visual">
				<i class="fa fa-rub"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{ $pay_today }}">{{ $pay_today }}</span>
				</div>
				<div class="desc"> за сегодня </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 red" href="#">
			<div class="visual">
				<i class="fa fa-rub"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{ $pay_week }}">{{ $pay_week }}</span></div>
				<div class="desc"> за 7 дней </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 green" href="#">
			<div class="visual">
				<i class="fa fa-rub"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{ $pay_month }}">{{ $pay_month }}</span>
				</div>
				<div class="desc"> за месяц </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 purple" href="#">
			<div class="visual">
				<i class="fa fa-rub"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{ $pay_all }}">{{ $pay_all }}</span>
				</div>
				<div class="desc"> за все время </div>
			</div>
		</a>
	</div>
</div>
<div class="clearfix"></div>

<h1 class="page-title"> Статистика
	<small>общая</small>
</h1>

<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
					<h3 class="font-green-sharp">
						<span data-counter="counterup" data-value="{{$user_money}}">{{$user_money}}</span>
						<small class="font-green-sharp">руб</small>
					</h3>
					<small>Общий баланс игроков</small>
				</div>
				<div class="icon">
					<i class="icon-pie-chart"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
					<h3 class="font-purple-soft">
						<span data-counter="counterup" data-value="{{$user_today}}">{{$user_today}}</span>
					</h3>
					<small>Новых пользователей</small>
				</div>
				<div class="icon">
					<i class="icon-user"></i>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection