@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2  nopadding">
            <a href="/results" class="btn btn-danger">BACK</a>
    </div>
    <div class="col-md-6 offset-md-2">
        <h2><b> <?php echo DB::table('categories')->where('cat_id',$id)->value('cat_name'); ?></b></h2>
    </div>
</div><br>
{{-- <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div> --}}

<div id="container2" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>


<script>
$(document).ready(()=>{
    console.log('i am inside ');
    $.ajax({
        type: "GET",
        url: "/resultsget/{{$id}}",
        success: function (data) { 
            makeChart(data) ; 
        }
    });
});

// function makeChart(data){
    // Highcharts.chart('container', {
    //     chart: {
    //         type: 'column'
    //     },
    //     title: {
    //         text: 'Category Analysis'
    //     },
    //     xAxis: {
    //         // categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
    //         // categories: data
    //         type: 'category',
    //         // categories : data.num,
    //         title: {
    //             text: 'Level #'
    //         },
            
    //         // console.log(categories);
    //     },
    //     yAxis: {
            
    //         title: {
    //             text: 'Percentage of correct response'
    //         },
    //         labels: {
    //             format: '{value}%'
    //         },
    //         stackLabels: {
    //             enabled: true,
    //             style: {
    //                 fontWeight: 'bold',
    //                 color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
    //             }
    //         }
    //     },
    //     legend: {
    //         align: 'right',
    //         x: -30,
    //         verticalAlign: 'top',
    //         y: 25,
    //         floating: true,
    //         backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
    //         borderColor: '#CCC',
    //         borderWidth: 1,
    //         shadow: false
    //     },
    //     tooltip: {
    //         headerFormat: '<b>{point.x}</b><br/>',
    //         pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    //     },
    //     plotOptions: {
    //         column: {
    //             stacking: 'normal',
    //             dataLabels: {
    //                 enabled: true,
    //                 color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
    //             }
    //         }
    //     },
    //     series: [{
    //         name: 'Percentage',
    //         data: data.num
    //     }]
    // });
// }

function makeChart(data1){
    //console.log('this is the level numbers: '+data1.num);
Highcharts.chart('container2', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text: 'Category results per Level'
    },
    xAxis: {
        title: {
            enabled: true,
            text: 'Levels (#)'
        },
        tickInterval: 1,
        allowDecimals: false,
        startOnTick: true,
        endOnTick: true,
        // showLastLabel: true
    },
    yAxis: {
        title: {
            text: 'Percentage (%)'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 70,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
        borderWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: 'Level #{point.x}, {point.y} %'
            }
        }
    },
    series: [{
        name: 'Scores per Level',
        color: 'rgba(40, 40, 235,.5)',
        data: data1.score
    }]
});
}


</script>
@endsection