@extends('chart::layouts.app')
@section('content')
    <div style="width:75%;">
        {!! $chartjs->render() !!}
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@endpush
