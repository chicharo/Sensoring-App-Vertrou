/**
*@author Olivier Peurichard & Etienne Marois
*/
        /** The table which contain the values (and other specifications) of the container(s)*/
        var containerAllValues = [];
        /**Is the container a double type?*/
        var isDoubleType = false;
        var json;
        var boolColumn = false;

        var chart;
        //type of chart (line, column...)
        var typeChart;
        var columnOn = false;

        var last_value1;

//handlingAjax();

displayChart();

function displayChart(){
    containerAllValues = [];
        handlingAjax();
    //--------------------
    
    //handlingAjax();
    setTimeout(displayChart,20000);
}

function handlingAjax(){


        $.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+ 'getAllValues',
      /**
       * If the ajax success, we launch this method
       * This function use the JSON file and store it in the table containerAllValues
       * @method success
       * @param {} result the JSON file of all values
       * @return the table containerAllValues which contain the values (and other specifications) of the container(s)
       */
      success: function(result){
        json=JSON.parse(result);
        json.forEach(function(d){
          containerAllValues.push([d.value,d.content_type_container,d.name, d.date]);
        
          
          });
        
        //Is the container a double type?
        for(i=0;i<containerAllValues.length;i++){
            if(containerAllValues[i][1]!=containerAllValues[0][1]){
                isDoubleType = true;
                break;
            }
        }
        /** the tables for the datas' manipulation*/
        var dataTab = [], dataTab2 = [], dataTabFin1 = [], dataTabFin2 = [];
        var datesTab = [];
        var type1 , type2, title1, title2, title;
        title1 = containerAllValues[0][2];

        //initialise the table of dates
        /*for(i=0;i<containerAllValues.length;i++){
            datesTab[i] =  containerAllValues[i][3];  
        }*/
        datesTab[0] = containerAllValues[0][3];
        var j =0;
        for(i=0;i<containerAllValues.length;i++){
            if(datesTab[j-1] !=  containerAllValues[i][3]){
                datesTab[j] =  containerAllValues[i][3];
                j++;
            }
        }

            if(isDoubleType==true){
                type1=containerAllValues[0][1]; 

                //save the other type and other title in a variable
                for(i=0;i<containerAllValues.length;i++){
                    if(containerAllValues[i][1] != type1){
                        type2 = containerAllValues[i][1];
                        title2 = containerAllValues[i][2];
                        break;
                    }
                }

                //attach values to date
                for(i=0;i<containerAllValues.length;i++){
                    if(containerAllValues[i][1]==type1){

                        dataTab.push([Math.floor(containerAllValues[i][0]), containerAllValues[i][3]]);
                    }
                    else{
                        dataTab2.push([Math.floor(containerAllValues[i][0]), containerAllValues[i][3]]);

                    }
                }

                //the final title is the two containers' names
                title = title1 + ' & '+ title2;

                //initialisation of the finals table
                var bool;
                var k = 0;
                //creation of final table for the graphs
                for(i=0;i<datesTab.length;i++){

                    for(j=0;j<dataTab.length;j++){

                        if(dataTab[j][1]==datesTab[i]){

                            bool = true;
                            dataTabFin1.push(dataTab[j][0]);
                            k++;
                        }
                    }
                    if(bool==false){
                        if(dataTabFin1.length==0){
                            dataTabFin1.push(null);
                            k++;
                        }
                        else{
                            dataTabFin1.push(dataTabFin1[k-1]);
                            k++;
                        }
                    }

                    bool = false;
                }

                bool = false;
                k = 0;
                for(i=0;i<datesTab.length;i++){

                    for(j=0;j<dataTab2.length;j++){

                        if(dataTab2[j][1]==datesTab[i]){

                            bool = true;
                            dataTabFin2.push(dataTab2[j][0]);
                            k++;
                        }
                    }
                    if(bool==false){
                        if(dataTabFin2.length==0){
                            dataTabFin2.push(null);
                            k++;
                        }
                        else{
                            dataTabFin2.push(dataTabFin2[k-1]);
                            k++;
                        }
                    }

                    bool = false;
                }

                if(columnOn == true){
                    typeChart = 'column';
                }
                else{
                    typeChart = 'line';
                }

               // initiateTabTwo();
                initiateDetailsTwo(type1, type2, title, dataTabFin1, dataTabFin2, datesTab);

                if(columnOn == true){
                    changeChartType(true);                
                }

            }
            else{
                title = containerAllValues[0][2];
                type1 = containerAllValues[0][1];
                for(i=0;i<containerAllValues.length;i++){
                    dataTabFin1[i] = Math.floor(containerAllValues[i][0]);
                    last_value1 = Math.floor(containerAllValues[i][0]);       
                }

                //initiateTab();
                initiateDetails(type1, title, dataTabFin1, datesTab);
                
            }
            init_map();

            for(i=1;i<3;i++){
                document.getElementById('radio'+i).onclick=function(){
                    

                    changeChartType(true);

                    
                    
                        
                    
                    

                }
            }
            initiateTable();
            initiateDetail();
            if(isDoubleType != true){
                initiateGauge();
            }
    }



  });
}

    function initiateGauge(){
        var max_value1;
        $.ajax({

      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+ 'getDetail',

      success: function(result){
        var text;
        res = JSON.parse(result);
        res.forEach(function(d){
            max_value1 = d.max_value;
        });


        mx_value1 = Math.floor(max_value1);
        percentage = (last_value1/mx_value1)*100;
        x = Math.ceil(percentage);
        loadLiquidFillGauge("fillgauge", x);
      }
    });
       
    }
    var myBool = false;
    function initiateDetail(){
    if(myBool==false){
    $.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+ 'getDetail',

      success: function(result){
        var text;
        res = JSON.parse(result);

        res.forEach(function(d){
            max_value1 = d.max_value;
          text = document.createTextNode(d.details);
        });

        div = document.getElementById('details');
        div.appendChild(text);
      }
    });
    }
    myBool = true;  

    }

    function initiateTable(){
        dataTable = $('#myTable').DataTable();
        dataTable.destroy();
        dataTable = $('#myTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"../model/getValuesTable.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".myTable").html("");
                    $("#myTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#myTable_processing").css("display","none");
 
                }
            }
        } );
    }

    /**
     * Initiate the chart of the container with two types (he contain 2 containers)
     * @method initiateDetailsTwo
     * @param {} type1 The first type
     * @param {} type2 The second type
     * @param {} title Name of both containers
     * @param {} dataTab Table which contain the values of the first container
     * @param {} dataTab2 Table which contain the values of the second container
     * @param {} datesTab Table which contain the dates of values 
     */
    function initiateDetailsTwo(type1, type2, title, dataTab, dataTab2, datesTab) {

        $('#contChart').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: title
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: datesTab
        },
        yAxis: {
            title: {
                text: 'Volume (m3)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: type1,
            data: []
        },
        {
            name: type2,
            data: []
        }]
    });
    chart = $('#contChart').highcharts();
        chart.series[0].setData(dataTab);
        chart.series[1].setData(dataTab2);
};

/**
 * Initiate the chart of the container with one type
 * @method initiateDetails
 * @param {} type Type of container.
 * @param {} title Name of container.
 * @param {} dataTab Table which contain the values of the second container.
 * @param {} datesTab Table which contain the dates of values.
 */
function initiateDetails(type, title, dataTab, datesTab) {
    var chart;
        $(function () {

    $.getJSON('http://localhost/Sensoring-App-Vertrou/model/getJson.php', function (data) {

        // Create a timer
        var start = +new Date();

        // Create the chart
        $('#contChart').highcharts('StockChart', {
            chart: {
                events: {
                    load: function () {
                        if (!window.isComparing) {
                            this.setTitle(null, {
                                text: 'Built chart in ' + (new Date() - start) + 'ms'
                            });
                        }
                    }
                },
                zoomType: 'x'
            },

            rangeSelector: {
                
                buttons: [{
                    type: 'day',
                    count: 3,
                    text: '3d'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1w'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6m'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1y'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                selected: 3
            },

            yAxis: {
                title: {
                    text: 'Volume(Liters)'
                }
            },

            title: {
                text: type + ' : ' + title
            },

            subtitle: {
                text: type // dummy text to reserve space for dynamic subtitle
            },

            series: [{
                name: type+' (Liters)',
                data: data,
                pointStart: Date.UTC(2015, 4, 28),
                pointInterval: 3600 * 1000,
                tooltip: {
                    valueDecimals: 1,
                    valueSuffix: 'L'
                }
            }]

        });
    });
});
};

/**
 * Initiate the table of values for the double container
 * @method initiateTabTwo
 */
function initiateTabTwo(){
        $('#resTitleType').append('Type');
    var myBody = document.getElementById("myBody");

   for(i=0;i<containerAllValues.length;i++){

        $('#resDate').append('<p>'+containerAllValues[i][3]+'</p>');
        $('#resType').append('<p>'+containerAllValues[i][1]+'</p>');
        $('#resValue').append('<p>'+containerAllValues[i][0]+'</p>');

    }
    
}

/**
 * Initiate the table of values for the simple container
 * @method initiateTab
 */
function initiateTab(){
    var myBody = document.getElementById("myBody");

   for(i=0;i<containerAllValues.length;i++){

        $('#resDate').append('<p>'+containerAllValues[i][3]+'</p>');
        $('#resValue').append('<p>'+containerAllValues[i][0]+'</p>');

    }
    
}
/**
 * Initiate the localisation of the container with a map
 * @method init_map
 */
function init_map() {
  var longitude;
  var latitude; 
  $.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+ 'getLoc',
      /**
       * If the ajax success, we launch this method
       * This function use the JSON file of localisation of container and store this localisation in two variables for the longitude and latitude
       * @method success
       * @param {} result
       */
      success: function(result){
        res = JSON.parse(result);
        res.forEach(function(d){
          longitude = d.geolong;
          latitude = d.geolat;
        
        });
        if(longitude!=null && latitude != null){
          var var_location = new google.maps.LatLng(latitude,longitude);
        var var_mapoptions = {
          center: var_location,
          zoom: 14
        };
 
    var var_marker = new google.maps.Marker({
      position: var_location,
            map: var_map,
      title:"Location"});
 
        var var_map = new google.maps.Map(document.getElementById("map-container"),
            var_mapoptions);
 
    var_marker.setMap(var_map); 

        }
    
 
      }
    });
}
var idContSession;

$.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+'getSessionIdCont',
      
      success: function(result){
        
        res = JSON.parse(result);
        res.forEach(function(d){
          idContSession =d.id;
        
        });
      }
    });

function changeChartType(redraw) {
    var type = 'line';
    columnOn = true;
    var column = document.getElementById('radio2');
    var line = document.getElementById('radio1');
    //var idContSession;

    

    if(column.checked)
    {
        type="column";      
    chart = $('#contChart').highcharts();     
    var seriesOptions = new Array(chart.series.length);
    boolColumn = true;

    for (i = 0;i <chart.series.length;i++) {         
        var series = chart.series[i];
        seriesOptions[i] = {             
            type: type,
            name: series.name,
            color: series.color,
            dashStyle: series.options.dashStyle,
            lineWidth: series.options.lineWidth,
             marker: series.options.marker,
             dataLabels: series.options.dataLabels,
             enableMouseTracking: series.options.enableMouseTracking,
             data: series.options.data,
             isRegressionLine: series.options.isRegressionLine
         };
    }     
    for (i = chart.series.length - 1;i >= 0;i--) {
        chart.series[i].destroy();
    }     
    for (i = 0;i <seriesOptions.length;i++) {
        var bool = redraw && (i == seriesOptions.length - 1);
        var newSeries = chart.addSeries(seriesOptions[i],bool);
    }     
    chart.currentType = type;
    }
    else{
        document.location.href="../vue/pageDetail.php?id="+idContSession+"";
    }
}