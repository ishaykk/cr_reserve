@extends('layout')
@section('title', 'Orders Data')
@section('headjs')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
@endsection

@section('content')
<div id="chartdiv" style="width:100%; height:500px"></div>
<div class="m-4 text-center">
    <button class="btn btn-link" id="ordersToggle">Show Last 7 Days Orders Data</button>
</div>    
@endsection

@section('javascripts')
    <script>
        const ordersData = {!! $ordersJsonData !!}; // get orders data from OrdersController@getOrdersStats method
        let chart = am4core.create("chartdiv", am4charts.XYChart);
    </script>
    <script src="{{ asset('js/amcharts/gantt.js') }}"></script>
    <script>
        // set chart title and change it later when toggling between month/week/day orders
        let title = chart.titles.create();
        title.text = 'Last 30 Days Orders';
        title.fontSize = 25;
        title.marginBottom = 20;
        title.marginTop = 20;

        const ordersModes = {
            MONTH: 1,
	        WEEK: 2,
	        DAY: 3,
        }
        
        let ordersMode = ordersModes.MONTH;

        $('#ordersToggle').on('click', function(){
            switch(ordersMode)             
            {
                case ordersModes.MONTH:
                    ordersMode = ordersModes.WEEK;
                    chart.data = weeklyOrders;
                    title.text = 'Last 7 Days Orders';
                    $(this).text('Show Todays Orders Data');
                    break;
                    
                case ordersModes.WEEK:
                    ordersMode = ordersModes.DAY;
                    chart.data = todaysOrders;
                    title.text = 'Todays Orders';
                    $(this).text('Show Last Month Orders Data');
                    break;
                case ordersModes.DAY:
                    showOrdersMode = ordersModes.MONTH;
                    chart.data = ordersData;
                    title.text = 'Last 30 Days Orders';
                    $(this).text('Show Last 7 Days Orders Data');
                    break;
                default:
                    alert('invalid ordersMode value!!!');
            }
        });
    </script>
@endsection