<div class="form-group ">
    
@if(!empty($label))
  
<label for="{{$label}}" >{{$labelCaption}}:</label>

@endif
<input type="{{$type}}" class="form-control border border-secondary mb-4" @if($type=='number') step="0.00000001" @endif
@if(!empty($id))
id="{{$id}}" @endif
@if(!empty($name))

name="{{$name}}"  @endif
@if(!empty($placeholder))

placeholder="{{$placeholder}}"
@endif

@if(!empty($inputData))
value="{{$inputData}}"
@endif
value="{{old($name)}}"/>                  
 </div>
