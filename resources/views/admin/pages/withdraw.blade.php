@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Выводы</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Выводы пользователей </h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Пользователь</th>
							<th>Система</th>
							<th>Кошелек</th>
							<th>Сумма</th>
							<th>Время</th>
							<th>Статус</th>
							<th>Редактировать</th>
						</tr>
					</thead>
					<tbody>
						@foreach($withdrows as $withdrow)
						<tr>
							<td style="vertical-align: middle;">{{$withdrow->id}}</td>
							<td style="vertical-align: middle;"><a href="https://vk.com/{{ $withdrow->user->login }}" target="_blank">{{ $withdrow->user->username }}</a></td>
							<td style="vertical-align: middle;">@if($withdrow->system == 'qiwi')
																<center><img src="https://static.qiwi.com/img/qiwi_com/favicon/favicon-192x192.png" width="30px" alt = 'Qiwi Visa Wallet'></center>
																@endif</td>
							<td style="vertical-align: middle;">{{$withdrow->wallet}}</td>
							<td style="vertical-align: middle;">{{$withdrow->amount}}</td>
							<td style="vertical-align: middle;">{{$withdrow->dfh}}</td>
							<td style="vertical-align: middle;">@if($withdrow->status == 0)
																<div class="btn green btn-sm">Ожидает</div>
																@elseif($withdrow->status == 1)
																<div class="btn orange btn-sm">Выплачено</div>
																@elseif($withdrow->status == 2)
																<div class="btn red btn-sm">Отказано</div>
																@endif</td>
							<td style="vertical-align: middle;">@if($withdrow->status == 0)<a class="btn blue btn-sm" data-toggle="modal" data-target="#usr_edit" href="/admin/withdraw/{{ $withdrow->id }}/edit">Редактировать</a>@endif</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="usr_edit" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			@include('admin.includes.modal_withdrows', ['user' => $withdrow])
		</div>
	</div>
</div>
@endsection