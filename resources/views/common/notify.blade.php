@if(@$errors)
	@if(count($errors) > 0)
		<div class="card-alert card notificationerror card-alert card gradient-45deg-red-pink ensober_alert">
			<div class="d-flex rightcard">
				<div class="card-content white-text">
					<ul>
						@foreach ($errors->all() as $error)
						<li style="color:#fff;"> {{ $error }}</li>
						@endforeach
					</ul>
				</div>
				<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		</div>
	@endif
@endif

@if(Session::has('flash_error'))
	<div class="card-alert card notificationerror card-alert card gradient-45deg-red-pink ensober_alert">
		<div class="d-flex rightcard">
			<div class="card-content white-text">
				<p>{{ Session::get('flash_error') }}.</p>
			</div>
			<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>
@endif


@if(Session::has('flash_success'))
	<div class="card-alert card  notificationerror card-alert card gradient-45deg-green-teal ensober_alert">
		<div class="d-flex rightcard1">
			<div class="card-content white-text">
				<p><i class="mdi mdi-check-circle text-success"></i> {!! Session::get('flash_success') !!}.</p>
			</div>
			<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>
@endif