<style type="text/css">
	a:hover {

		text-decoration: none !important;
	}
</style>
@if(count($services))
	@foreach($services as $key => $service)
		<?php $key = $key+1; ?>
		<div class="col-md-4">
			<div class="thumbnail">
			  <a href="/store/service/{{$service->id}}">
			    <img src="{{asset('/image/vat/gtgt-0'.$key.'.svg')}}" alt="Nature" style="width:60%">
			    <div class="caption text-center">
			      <p>{{$service->description}}</p>
			    </div>
			  </a>
			</div>
		</div>
	@endforeach
@endif
