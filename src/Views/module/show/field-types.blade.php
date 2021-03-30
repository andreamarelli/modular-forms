<?php
/** @var String $type */
/** @var String $value */
/** @var bool $only_label */

$value = $value==='' ? null : $value;
$only_label = $only_label ?? false;


if($value!==null){
    if(preg_match('/dropdown[\w]*-/', $type)>0){
        $value = \AndreaMarelli\ModularForms\Helpers\Input\SelectionList::getLabel($type, $value);
    }
    elseif(preg_match('/[\w]*-yes_no/', $type)>0){
        $value = $value ? 'true' : 'false';
    }
    elseif($type=='numeric' || $type=='currency'){
        $value = number_format($value, 2, ',', ' ');
    }
    elseif($type=='integer'){
        $value = number_format($value, 0, ',', ' ');
    }
}

?>
@if($type=="hidden")
    {{-- nothing to show --}}

@elseif(\Illuminate\Support\Str::contains($type, "dropdown_multiple-") || \Illuminate\Support\Str::endsWith($type, '_multiple'))
    <div class="field-preview">
        @if($value!==null)
            @php
                $values = json_decode($value)===null ? explode(',', $value) : json_decode($value);
            @endphp
            @foreach($values as $v)
                <span class="multiple">{{ $v }}</span>
            @endforeach
        @endif
    </div>

@elseif(\Illuminate\Support\Str::contains($type, 'checkbox-boolean'))
    <span class="checkbox">
        <input type="checkbox" {{ $value ? 'checked="checked"' : '' }}>
        <label></label>
    </span>
@elseif(\Illuminate\Support\Str::contains($type, 'checkbox-'))
    @foreach(\AndreaMarelli\ModularForms\Helpers\Input\SelectionList::getList($type) as $item)
        <input type="checkbox" disabled="disabled"
                {{ in_array($item, $value) ? 'checked="checked"' : '' }}
        /> {{ $item }}<br />
    @endforeach

@elseif(\Illuminate\Support\Str::contains($type, 'toggle-'))
    <span class="toggle">
         @foreach(\AndreaMarelli\ModularForms\Helpers\Input\SelectionList::getList($type) as $k=>$v)
            @if((string) $v !== '')
                <button type="button" value="true" class="btn
                    {{(string) $k === (string)$value ? 'active' : '' }}"
                >{{ $v }}</button>
            @endif
        @endforeach
    </span>

@elseif($type=='upload')
    <div class="field-preview">
        @if($value['original_filename']!==null)
            <a target="_blank" href="{{ $value['download_link'] }}">
                {!! \AndreaMarelli\ModularForms\Helpers\Template::icon('file') !!} {!! $value['original_filename'] !!}
            </a>
        @else
            &nbsp;
        @endif
    </div>
@elseif(\Illuminate\Support\Str::contains($type, 'boolean-') || \Illuminate\Support\Str::contains($type, 'boolean_numeric-'))

    <span class="checkbox">
        <input type="checkbox" {{ $value==1 ? 'checked=checked' : '' }} />
        <label></label>
    </span>

@elseif(\Illuminate\Support\Str::contains($type, "rating-"))
    @php
        $ratingType = explode('-', $type);
        $ratingType = end($ratingType);
        $ratingType = str_replace('WithNA', '', $ratingType);
        $ratingType = str_replace('Minus', '-', $ratingType);
        [$min, $max] = explode('to', $ratingType);
    @endphp
    <span ref="ratingOptions" class="rating-container">
        @if( Str::contains($type, 'WithNA'))
            <span class="rating field-edit ratingNa {{ $value=='-99' ? 'active' : '' }}">N/A</span>
        @endif
        @for($i=$min; $i<=$max; $i++)
            <span class="rating field-edit ratingNum {{ $value!==null && $i<=$value ? 'active' : '' }}">{{ $i }}</span>
        @endfor
    </span>


@elseif($only_label)
    {!! $value ?? '&nbsp;' !!}
@elseif($type==='numeric' || $type==='currency' || $type==='integer')
    <div class="field-preview">
        <div class="text-right">
            {!! $value ?? '&nbsp;' !!}
        </div>
    </div>
@else
    <div class="field-preview">
        {!! $value ?? '&nbsp;' !!}
    </div>
@endif
