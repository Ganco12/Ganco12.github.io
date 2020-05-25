@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Пользователи</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Пользователи </h1>
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Аватар</th>
							<th>Имя Фамилия</th>
							<th>Ссылка</th>
							<th>Баланс</th>
							<th>Управление</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
							<td style="vertical-align: middle;">{{$user->id}}</td>
							<td align="center"><img width="50px" src="{{$user->avatar}}"/></td>
							<td style="vertical-align: middle;">{{$user->username}}</td>
							<td style="vertical-align: middle;"><a href="https://vk.com/id{{$user->steamid}}" target="_blank">https://vk.com/id{{$user->steamid}}</a></td>
							<td style="vertical-align: middle;">{{$user->wallet}}</td>
							<td align="center" style="vertical-align: middle;">
								<button type="button" class="btn blue btn-sm" data-toggle="modal" data-target="#usr_edit" href="/admin/user/{{ $user->id }}/edit">Редактировать</button>
							</td>
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
			@include('admin.includes.modal_users', ['user' => $user])
		</div>
	</div>
</div>
@endsection