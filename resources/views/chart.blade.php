@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Statistic')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Statistic')

{{-- Content body: main page content --}}

@section('content_body')
<div>
    <div style="display: flex;">
        <div style="flex: 1;">
            <canvas id="subChart" style="width:100%;max-width:700px"></canvas>
        </div>
        <div style="flex: 1;">
            <canvas id="popChart" style="width:100%;max-width:700px"></canvas>
        </div>
    </div>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Subscription Chart
        fetch('/admin/stat/subscription')
            .then(response => response.json())
            .then(data => {
                const xValues = data.labels;
                const datasets = data.datasets.map(dataset => ({
                    label: dataset.label,
                    data: dataset.data,
                    borderColor: dataset.borderColor,
                    fill: false
                }));

                // Create Chart.js chart
                new Chart("subChart", {
                    type: "line",
                    data: {
                        labels: xValues,
                        datasets: datasets
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Subscription data for the last 10 days.',
                            fontSize: 13,
                            fontColor: 'gray',
                            fontStyle: 'bold'
                        },
                        legend: {
                            display: true,
                            labels: {
                                fontColor: 'gray',
                                fontSize: 13,
                                fontStyle: 'normal',
                            },
                            position: 'right',
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        // Table Popularity chart
        fetch('/admin/stat/popularity')
            .then(response => response.json())
            .then(data => {
                const xValues = data.labels;
                const yValues = data.data;
                const barColors = [
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145",
                    "gray"
                ];

                // Create Chart.js chart
                new Chart("popChart", {
                    type: "doughnut",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "Table Popularity of the last month (Top 5)."
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
</script>
@endpush