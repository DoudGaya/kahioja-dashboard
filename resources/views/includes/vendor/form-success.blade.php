      <!-- <div class="alert alert-success validation" style="display: none;">
      <button type="button" class="close alert-close"><span>×</span></button>
            <p class="text-left"></p> 
      </div> -->
@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="bg-red-500 text-white py-2 px-4 text-center">
            {{$error}}
		</div>
    @endforeach
@endif

@if(session('success'))
    <div class="text-green-400 py-2 px-4 text-center">
        <h4>{{session('success')}}</h4>
	</div>
@endif


@if(session('error'))
    <div class="text-white py-2 px-4 text-center">
        <h4>{{session('error')}}</h4>
	</div>
@endif