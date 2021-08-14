am4core.ready(function() {
        
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var label = chart.createChild(am4core.Label);
label.text = "Time";
label.fontSize = 20;
label.align = "center";

var topContainer = chart.chartContainer.createChild(am4core.Container);
topContainer.layout = "absolute";
topContainer.toBack();
topContainer.paddingBottom = 0;
topContainer.width = am4core.percent(100);

var axisTitle = topContainer.createChild(am4core.Label);
axisTitle.text = "Room ID";
axisTitle.fontWeight = 600;
axisTitle.align = "left";
axisTitle.paddingLeft = 10;

chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.paddingRight = 30;
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

let colorSet = new am4core.ColorSet();
colorSet.saturation = 0.4;

todaysOrders = [] 
weeklyOrders = []
const dateNow = new Date();
const date1WeekAgo = new Date(dateNow.getTime() - (7 * 24 * 60 * 60 * 1000));

// extract last week & today orders from last 30 days orders (ordersData)
ordersData.forEach((order, i) => {
    order['color'] = colorSet.getIndex(i).lighten(Math.random() * 0.5); // set different color for each order slot
    let orderDateObj = new Date(order['fromDate'].substring(0, 10));
    if(dateNow.toISOString().split('T')[0] === orderDateObj.toISOString().split('T')[0]) // exract todays orders
        todaysOrders.push(order);
    else if (orderDateObj >= date1WeekAgo) // extract last 7 days orders from last 30 days orders
        weeklyOrders.push(order);
});

chart.data = ordersData;

let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "roomid";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.inversed = true;

let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.dateFormatter.dateFormat = "yyyy-MM-dd HH:mm";
dateAxis.renderer.minGridDistance = 70;
dateAxis.baseInterval = { count: 15, timeUnit: "minute" };
//dateAxis.max = new Date(2021, 5, 27, 24, 0, 0, 0).getTime();
//onsole.log(dateAxis.max);
dateAxis.strictMinMax = true;
dateAxis.renderer.tooltipLocation = 0;

let series1 = chart.series.push(new am4charts.ColumnSeries());
series1.columns.template.width = am4core.percent(80);
series1.columns.template.tooltipText = "Room: {roomid}\n{openDateX} - {dateX}\nCreated by: {createdBy}";

series1.dataFields.openDateX = "fromDate";
series1.dataFields.dateX = "toDate";
series1.dataFields.categoryY = "roomid";
series1.columns.template.propertyFields.fill = "color"; // get color from data
series1.columns.template.propertyFields.stroke = "color";
series1.columns.template.strokeOpacity = 1;

//chart.scrollbarX = new am4core.Scrollbar();

// Add scrollbar
var scrollbar = new am4charts.XYChartScrollbar();
scrollbar.series.push(series1)
chart.scrollbarX = scrollbar;
chart.scrollbarX.background.fill = am4core.color("#dc67ab");
chart.scrollbarX.background.fillOpacity = 0.2;

}); // end am4core.ready()