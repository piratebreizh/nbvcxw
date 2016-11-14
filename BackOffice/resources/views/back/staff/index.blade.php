@extends('back.template')

@section('head')

<style type="text/css">
  
  .badge {
    padding: 1px 8px 1px;
    background-color: #aaa !important;
  }

</style>

@stop

@section('main')

  @include('back.partials.entete', ['title' => "Gestion des Staff" . link_to_route('staff.create', "Ajouter un Staff", [], ['class' => 'btn btn-info pull-right']), 'icone' => 'user', 'fil' => "Staff"])
 
  <div id="tri" class="btn-group btn-group-sm">
    <a href="{!! url('staff') !!}" type="button" name="total" class="btn btn-default {{ classActiveOnlyPath('user') }}">Tous 
       <span class="badge">{{  $totalStafferView }}</span>
    </a>
    @foreach ($jobs as $job)
      <a href="{!!  url('staff/sort/' .  $job['name'] ) !!}" type="button" name="{!! $job['name'] !!}" class="btn btn-default {{ classActiveOnlySegment(3, $job['name']) }}">{{ $job['name']  }} 
        <span class="badge">{{  $job['skills'] }}</span>  
      </a>
    @endforeach
  </div>

	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
          <th></th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
          <th>Validé</th>
          <th>Date de création</th>
          <th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.staff.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>
    
    $(function() {

      // Seen gestion
      $(document).on('change', ':checkbox', function() {    
        $(this).parents('tr').toggleClass('warning');
        $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
        var token = $('input[name="_token"]').val();
        $.ajax({
          url: '{!! url('userseen') !!}' + '/' + this.value,
          type: 'PUT',
          data: "seen=" + this.checked + "&_token=" + token
        })
        .done(function() {
          $('.fa-spin').remove();
          $('input[type="checkbox"]:hidden').show();
        })
        .fail(function() {
          $('.fa-spin').remove();
          var chk = $('input[type="checkbox"]:hidden');
          chk.show().prop('checked', chk.is(':checked') ? null:'checked').parents('tr').toggleClass('warning');
          alert('{{ trans('back/users.fail') }}');
        });
      });

    });

  </script>

@stop