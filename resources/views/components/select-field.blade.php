{{-- 
  Attributes of select fields
  - label, name, id, defaultOption (default option of Select)
  - options['options'] (all options of select) (Array)
  - options['userSelectedOption']['Key'] (compare key with options key)
  - options['userSelectedOption']['Value'] (compare value with options value)
--}}

@if(!empty(old($name)))
    <?php  $options['userSelectedOption']['Key'] = old($name); ?>
@endif

<?php $nameOfClass = "" ?>
@if(!empty($className))
    <?php $nameOfClass = $className ?>
@endif

<div class="form-group" style="width:100%">
    @if(!empty($label))
        <label for="{{ $label }}" >{{ $labelCaption }}:</label>
    @endif

    <select class="form-control col-lg-12 col-xs-12 {{ $nameOfClass }}" aria-label="Default select example"
            @if(!empty($id)) id="{{ $id }}" @endif
            @if(!empty($name)) name="{{ $name }}" @endif>

        @if(!empty($defaultOption))
            <option value="">{{ $defaultOption }}</option>
        @endif

        @if(isset($options['options']))
            @foreach($options['options'] as $key => $value)
                <option value="{{ $key }}"
                    @if(!empty($options['userSelectedOption']))
                        @if(isset($options['userSelectedOption']['Key']))
                            {{-- Check if the old selected option (Key) matches --}}
                            @if(strtolower($key) == strtolower($options['userSelectedOption']['Key']))
                                selected="selected"
                            @endif
                        @elseif(isset($options['userSelectedOption']['Value']))
                            {{-- Check if the old selected option (Value) matches --}}
                            @if($value == $options['userSelectedOption']['Value'])
                                selected="selected"
                            @endif
                        @endif
                    @endif
                >{{ $value }}</option>
            @endforeach
        @endif

    </select>
</div>
