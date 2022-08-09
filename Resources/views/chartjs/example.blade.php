@php
    //dddx($chartjs->render());
    isset($var['style_float'])?$float=$var['style_float']:$float='none';
    isset($var['style_clear'])?$clear=$var['style_clear']:$clear='none';
    isset($var['style_display'])?$display=$var['style_display']:$display='none';
@endphp
<div style="clear:{{$clear}};float:{{$float}};display:{{$display}}">
    {!! $chartjs->render() !!}
</div>