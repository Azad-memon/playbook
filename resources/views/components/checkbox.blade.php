
<div class="form-row">
    <h5 style="width:100%">{{ $labelCaption }}</h5>
<br>
<div class="row" style=" margin-left:10px; margin-top:10px" >
    @if($checkboxToCheck!="")
    <?php 
    $checkboxToCheckArray=explode(',',strtoupper($checkboxToCheck));
   //
    ?>
    @else
    <?php 
     $checkboxToCheckArray= Array();
    ?>
    @endif
   
    @if(isset($options))
  
        @foreach($options as $key=>$value)
           
                            <input id="checkbox-tiny" style="margin-left:20px; " class= "{{$class}}" data-value={{$value}} name="{{$name}}" 
                            value="{{$key}}" type="checkbox"
                            @if (in_array($key, $checkboxToCheckArray))
                                {{"checked"}}
                                    
                        @endif
                            />
                            
                            <div class="checkbox-checkmark"></div>
                        
                        <label for="{{$value}}" style="color:black; margin-left:10px;"><b>{{$value}}</b></label>
        
        @endforeach
    @endif
</div>
</div>
                    