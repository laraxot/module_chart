@php
    isset($var['style_float'])?$float=$var['style_float']:$float='none';
    isset($var['style_clear'])?$clear=$var['style_clear']:$clear='none';
@endphp

<div style="clear:{{$clear}};float:{{$float}}">
    {!! $chartjs->render() !!}
</div>

{{-- @push('styles')
<style>
canvas{

    width:400px !important;
    height:400px !important;
  
  }
  </style>
@endpush --}}