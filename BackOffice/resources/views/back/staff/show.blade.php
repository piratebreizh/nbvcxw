@extends('back.template')

@section('main')

	@include('back.partials.entete', ['title' => "Staff", 'icone' => 'user', 'fil' => link_to('user', "Staff") . ' / ' . trans('back/users.card')])

	<p>{{'Id : ' .  $staff->id_users }}</p>
	<p>{{'Nom : ' .  $staff->staff_last_name }}</p>
	<p>{{'Prénom : ' .  $staff->staff_first_name }}</p>
	<p>{{'Email : ' .  $staff->staff_first_email }}</p>
	<p>{{'Numéro de contrat : ' .  $staff->contract_number }}</p>
	<p>{{'Date de création : ' .  $staff->created_at }}</p>
	<p>{{'Dèrnier date de modification : ' .  $staff->updated_at }}</p>
	<p>{{'Info user : ' .  $staff->updated_at }}</p>
@stop