{{-- 
Attributes of select fields: 

- label (Label text)
- name (Field name)
- id (HTML ID)
- defaultOption (Default option of Select)
- options['options'] (Array of all select options)
- options['userSelectedOption']['Key'] (Array of selected keys)
- options['userSelectedOption']['Value'] (Array of selected values)
--}}

@if(!empty(old($name)))
    <?php $options['userSelectedOption']['Key'] = old($name, $options['userSelectedOption']['Key'] ?? []); ?>
@endif

<div class="form-group" style="width:100%">

    @if(!empty($label))
        <label for="{{ $id ?? '' }}" style="color:black">{{ $labelCaption ?? '' }}:</label>
    @endif

    <select 
        class="form-control col-lg-12 col-xs-12 {{ $className ?? '' }}" 
        multiple="multiple" 
        aria-label="Default select example"
        @if(!empty($defaultOption)) data-placeholder="{{ $defaultOption }}" @else data-placeholder="Choose ..." @endif
        @if(!empty($id)) id="{{ $id }}" @endif
        @if(!empty($name)) name="{{ $name }}[]" @endif>
        
        <optgroup label="{{ $defaultOption ?? 'Choose..' }}">

            @if(isset($options['options']) && is_array($options['options']))
                @foreach($options['options'] as $key => $value)
                    <option 
                        value="{{ $key }}" 
                        @if(isset($options['userSelectedOption']['Key']) && is_array($options['userSelectedOption']['Key']) && in_array($key, $options['userSelectedOption']['Key'])) 
                            selected 
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            @endif

        </optgroup>
        
    </select>
    
</div>
