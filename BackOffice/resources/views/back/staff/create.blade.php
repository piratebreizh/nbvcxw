@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => "Gestion des Staff", 'icone' => 'user', 'fil' => link_to('staff', "Staff") . ' / ' . "Création"])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'staff', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}	
			{!! Form::control('text', 0, 'staff_last_name', $errors, "Nom") !!}
			{!! Form::control('text', 0, 'staff_first_name', $errors, "Prénom") !!}
			{!! Form::control('email', 0, 'staff_first_email', $errors, "Email") !!}
			{!! Form::control('text', 0, 'contract_number', $errors, "Numéro de contrat") !!}
			{!! Form::submit("Créer") !!}
		{!! Form::close() !!}
	</div>

@stop