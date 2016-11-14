@extends('back.template')

@section('main')

	<!-- Entête de page -->
	@include('back.partials.entete', ['title' => trans('back/users.dashboard'), 'icone' => 'user', 'fil' => link_to('user', trans('back/users.Users')) . ' / ' . trans('back/users.edition')])

	<div class="col-sm-12">
		{!! Form::model($staff, ['route' => ['staff.update', $staff->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
			{!! Form::control('text', 0, 'staff_last_name', $errors, 'Nom') !!}
			{!! Form::control('text', 0, 'staff_first_name', $errors, 'Prénom') !!}
			{!! Form::control('text', 0, 'staff_first_email', $errors, 'Email') !!}
			{!! Form::control('text', 0, 'contract_number', $errors, 'Numéro de contrat') !!}
			{!! Form::submit('Modifier') !!}
		{!! Form::close() !!}
	</div>

@stop