/**
*@author Olivier Peurichard & Etienne Marois
*/
/**grid is the principal division wich contain and display the elements */
var grid = null;
/**myElem is a array which contain all the elements of a user*/
var myElem = [];
/** tabId contains the id of elements which are added on the grid*/
var tabId = [];
/**tabCheckB contains all the types and if they are checked or not*/
var tabCheckB = []; /* var for save*/ var tmptabCheckB = [];
/**is the tabCheckB instanciate ?*/
var bTabInstanciate = false;
/**is the point All checked ?*/
var bAll = true;
/** The table which store the specifications of elements */
var items = [];

var k =0;

var nb_page = 0;

$(document).ready(function(){
  
    //we pick the data from the database
    $.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data:'myFunction='+'getContainers',
      success: function(result){
        grid = $('.grid-stack').data('gridstack');

        res = JSON.parse(result);
        res.forEach(function(d){
          items.push([d.id,d.content_type,d.name,d.max_value,d.alert_value]);
        });

        //for each tank
        for(i=0; i<items.length;i++){
          
            //if the tank contains two different liquids
            if(i<(items.length-1) && (items[i][0]==items[i+1][0])){
            
              //cretion of the element
              element = document.createElement("div");
              element.className ="grid-stack-item";
              // add the tank's name in the element an the other things
              element.id = "gridstackitem" + items[i][0];

              content = document.createElement("div");
              content.className = "grid-stack-item-content";
              content.id = "gridstackitemcontent" + i;
              content.style.outline = "1px solid black";
              
              buttonClose = document.createElement("button");
              buttonClose.className = "close";
              buttonClose.id = "itemclose" + i;
              buttonClose.setAttribute("aria-hidden",true);
              textButton = document.createTextNode("x");
              buttonClose.appendChild(textButton);

              spanType = document.createElement("span");
              spanType.className = "label label-default";
               textType = document.createTextNode(items[i][1] + "&" + items[i+1][1]);
              spanType.appendChild(textType);


              span = document.createElement("span");
              span.className = "label label-primary";
               text = document.createTextNode(items[i][2] + "&" + items[i+1][2]);
              span.appendChild(text);
              

              div = document.createElement("div");

              div.setAttribute("style","width: 400px; height: 200px;margin: 0 auto");
              div.style.width='400px';
              div.style.height='200px';
              
              div1 = document.createElement("div");
              div1.id = items[i][0]+items[i][1];
              div1.setAttribute("style","width: 130px; height: 200px;float: left");
              div1.style.width='130px';
              div1.style.height='200px';
              
              div2 = document.createElement("div");
              div2.id = items[i+1][0]+items[i+1][1];
              div2.setAttribute("style","width: 130px; height: 200px;float: left");
              div2.style.width='130px';
              div2.style.height='200px';
              
              div.appendChild(div1);
              div.appendChild(div2);

              divAlert = document.createElement("div");
              divAlert.className = "alert alert-warning";
              divAlert.id = "alert"+items[i][0];


              text = document.createTextNode("This tank is low, be careful !");
              divAlert.appendChild(text);


              content.appendChild(buttonClose);
              content.appendChild(spanType);
              content.appendChild(span);
              content.appendChild(div);
              content.appendChild(divAlert);
              
              element.appendChild(content);



              myElem.push([items[i][1],element, items[i][0]]);
              myElem.push([items[i+1][1],element, items[i+1][0]]);


              //add the element in the grid, the other params are for the gridstack settings
              grid.add_widget(element,1,1,3,4,true);
              
              initiateDoubleChart(div1.getAttribute('id'),items[i][1],items[i][3], items[i][4],div2.getAttribute('id'),items[i+1][1],items[i+1][3], items[i+1][4]);
              
              i++;
              k++;
              
            }//end of the if with double type

            //if the tank contain one type of liquid
            else{
             //the same but without the concatenation of tank's names with the simple chart, etc...
              element = document.createElement("div");
              element.className ="grid-stack-item";
              element.id = "gridstackitem" + items[i][0];

              content = document.createElement("div");
              content.className = "grid-stack-item-content";
              content.id = "gridstackitemcontent" + i;
              content.style.outline = "1px solid black";

              buttonClose = document.createElement("button");
              buttonClose.className = "close";
              buttonClose.id = "itemclose" + i;
              buttonClose.setAttribute("aria-hidden",true);
               textButton = document.createTextNode("x");
              buttonClose.appendChild(textButton);

              spanType = document.createElement("span");
              spanType.className = "label label-default";
               textType = document.createTextNode(items[i][1]);
              spanType.appendChild(textType);

              span = document.createElement("span");
              span.className = "label label-primary";
              text = document.createTextNode(items[i][2]);
              span.appendChild(text);

              div = document.createElement("div");
              div.id = items[i][0]+items[i][1];
              div.setAttribute("style","width: 300px; height: 200px;");

              divAlert = document.createElement("div");
              divAlert.className = "alert alert-warning";
              divAlert.id = "alert"+items[i][0];


              text = document.createTextNode("This tank is low, be careful !");
              divAlert.appendChild(text);


              content.appendChild(buttonClose);
              content.appendChild(spanType);
              content.appendChild(span);
              content.appendChild(div);
              content.appendChild(divAlert);
              element.appendChild(content);

              grid.add_widget(element,1,1,3,4,true);
              initiateChart(div.getAttribute('id'), items[i][1],items[i][3], items[i][4]);

              myElem.push([items[i][1],element, items[i][0]]);

              k++;

            }
          }
          for(i=0;i<myElem.length;i++){
            forOnClick(myElem[i][1],myElem[i][2]);
          }
          //hide the aler
          for(k=0;k<items.length;k++){
              $('#alert'+items[k][0]).hide();
            }



          displayAll(1);
          initiatePagination();
          
            getLastValues();

              }
         });
 
});

/**
* attach an event onClick
*Launch the pageDetail() function with the id in parameter
*
*
* @see pageDetail(id) The function which is launch in the onClick on the element ie when you click on an element
* @method forOnClick
* @param {} elem the element
* @param {} id the id of the container, param to the function pageDetail
           */
function forOnClick(elem,id){

  elem.onclick=function(){
    pageDetail(id);
  }
}

/**
 * This function allows the redirection to the details page with the user's id in.
 * @method pageDetail
 * @param {} id the id of the container which is transmetted by the URL
 *@see forOnClick This function is launch by onClick, ie when you click on an element
 */
function pageDetail(id){
  var ID = ''+id+'&';
  var monID = ID.substring(ID.indexOf('k'), ID.indexOf('&'));
  if($('#')){

  }
document.location.href="../vue/pageDetail.php?id="+monID+"";
}
  //for the selection of elements by type
/**
 * This method permetted to display all the elements of the type
 * @method displayContainers
 * @param {} type
 */
function displayContainers(type){
  grid.remove_all();
  tabId =[];
  var b = false;

  for(i=0; i<myElem.length; i++){
    //if the element's type is the type of the checkpoint
    if(myElem[i][0]==type){

      b = false;
      for(j=0; j<tabId.length; j++){

        if(myElem[i][2] == tabId[j]){
          b = true;

          break;
        }
      }

      if(b == false){

        grid.add_widget(myElem[i][1]);
        tabId.push(myElem[i][2]);

      }
    }
  }
}

/**
 * this function is launch when you select or deselect 'All'
 * @method displayContainersAll
 * @param {} cb Boolean - The result of "Is the box checked?"
 */
function displayContainersAll(cb){
  //change cb to a boolean
  checkB = cb.checked;
  //store the checkB boolean in bAll. In the  function which display the elements
  //with the two-dimensional array. We will check if "All" is checked (bAll == true)
  //before the display and if yes, we will display all the elements.
  bAll = checkB;

  //istanciate the two-dimensional array we evoke above
  createTabC(bTabInstanciate);
  //with this boolean, we will know if the table is already instantiated.
  bTabInstanciate = true;

  //if "All" is checked
  if(checkB == true){
    //we display all the elements
    displayAll(1);
  }
  // if "All" is not checked
  else{
    //we display the elements with the type checked at True
    //in the two-dimensional array "tabCheckB"
    displayElements(tabCheckB);
  }

}


        
/**
 * This method is launch when the user click on a element type in the Checkbox.
 *It launch methods for diplay the good elements
 * @method displayContainersCheckbox
 * @param {} type Type of the container
 * @param {} cb Boolean - The result of "Is the box checked?"
 */
function displayContainersCheckbox(type, cb){
  //change cb to a boolean
  checkB = cb.checked;
  //istanciate the two-dimensional array we evoke above
  createTabC(bTabInstanciate);
  bTabInstanciate = true;
  
  //add to tabCheck the change
  //We browse the two-dimensional array "tabCheckB" we evoke above
    for(i=0;i<tabCheckB.length;i++){
      //if the type of the table is the same type of the checkBox
      if(type==tabCheckB[i][0]){
          //We put the check about this type to the actual check of the checkbox.
          tabCheckB[i][1] = checkB;
      }
    }
  //laucnh the function which display the elements with the array "tabCheckB"
  displayElements(tabCheckB);
 
}


/**
 * function to create the table of type with the checked false by default
 * @method createTabC
 * @param {} b a boolean to know if the table tabCheckB is already initialise
 */
function createTabC(b){
  var bool = false;

  if(b==false){
    for(j=0;j<myElem.length;j++){
    //add to tabCheck the change
    if(tabCheckB.length > 0){
      bool = false;
      for(i=0;i<tabCheckB.length;i++){
        if(myElem[j][0]==tabCheckB[i][0]){

        bool = true;
        break;
        }
      }
      if(bool == false){
        tabCheckB.push([myElem[j][0],false]);
      }
    }
    else{
      tabCheckB.push([myElem[0][0],false]);
    }
  }

  }
}

/**
 * This method display all the elements depending on the checkbox
 * @method displayElements
 * @param {} tabCheck The two-dimensional array containing all the types and
 *on the same line of these types if they are checked
 */
function displayElements(tabCheck){

  //is the checkBox "All" checked?
  if(bAll==true){
    //display all the elements
    displayAll(1);
  }
  else{
     // remove all the elements in the grid
    grid.remove_all();
    //initialise the tab which contain the elements added in the grid
    tabId =[];
    var bC = false;
    var bI = false;
    //browse all elements
    for(i=0; i<myElem.length; i++){
      bC = false;
      //Is the type of Element is set to true ?
      for(j=0;j<tabCheck.length;j++){
        if(myElem[i][0]==tabCheck[j][0] && tabCheck[j][1]==true){
          bC = true;
          break;
        }
      }

      //Is the element already display on the Grid ?
      bI = false;
      for(j=0; j<tabId.length; j++){
        //if the element is already display on the grid
        if(myElem[i][2] == tabId[j]){
          bI = true;
          break;
        }
      }

      //if all conditions are fulfilled we can add the element to the grid
      //If the element's type is checked at true in the two-dimensional array
      if(bC == true && bI == false){
        grid.add_widget(myElem[i][1]);
        tabId.push(myElem[i][2]);
      }
    }
  }
}

/**
  * Display all the documents
  * @method displayAll
  * @param {} page
  */
 function displayAll(page){
    grid.remove_all();
    tabId =[];
    var bI = false;
    nb = 0;
    bonus=0;
    start = 0;
    //browse all elements

      for(j=0; j<myElem.length && start < (page-1)*12; j++){
        if(j>0){
          if(myElem[j][2]==myElem[j-1][2]){
            bonus++;
          }
          else{
            start++;
          }
        }
        else{
          start++;
        }
        
      }
      for(i=start+bonus; i<myElem.length && nb<12; i++){
        //Is the element already display on the Grid ?
        bI = false;
        for(j=0; j<tabId.length; j++){

          if(myElem[i][2] == tabId[j]){
            bI = true;
            break;
          }
        }

        //if all conditions are fulfilled we can add the element to the grid
        if(bI == false){
          grid.add_widget(myElem[i][1]);
          tabId.push(myElem[i][2]);
          nb++;
        }
      }
      getLastValues();
}

/**
 * This function add an onClick for the functionnality pagination
 * @method addOnClickPagination
 * @param {} id
 */
function addOnClickPagination(id){
    /**
     * Description
     * @method onclick
     */
    document.getElementById('link'+id).onclick=function(){
      displayAll(id);
    
  }
}

/**
 * Initiate the pagination
 *How many pages, which element in them...
 * @method initiatePagination
 */
function initiatePagination(){
  var page = document.getElementById("pagination");
  

  while((k/12)>nb_page){
    nb_page++;
  }

  

  for(i=1; i<nb_page+1;i++){
    list = document.createElement('li');
        

    link= document.createElement('a');
    link.id ="link"+i;
    linkText = document.createTextNode(i);
    link.appendChild(linkText);

    list.appendChild(link);


    page.appendChild(list);
  }

  for(i=1; i<nb_page+1;i++){
    addOnClickPagination(i);
  }
}

/**
 * This method get the last values of the active container.
 * @method getLastValues
 */
function getLastValues(){
  var containersLastValues = [];
  $.ajax({
      type: "POST",
      url: '../model/sqlQueries.php',
      data: 'myFunction='+'getLastValues',
      /**
       * If ajax succes,, this function is launch
       * This function use the JSON file and store it in the table containerLastValue
       * @method success
       * @param {} result the JSON file of the last Values
       */
      success: function(result){
        res = JSON.parse(result);
        res.forEach(function(d){
          for(i=0;i<tabId.length;i++){
            if(d.id_container==tabId[i]){
              containersLastValues.push([d.id_container,d.content_type_container,d.value,d.date]);
            }
          }
          });
          
            for(i=0; i<containersLastValues.length; i++){
              id = containersLastValues[i][0]+containersLastValues[i][1];
              var intvalue = Math.floor( containersLastValues[i][2] );
              
              

              $('#'+id).highcharts().series[0].points[0].update(intvalue);  

              for(j=0;j<items.length;j++){
                if(items[j][0]+items[j][1]==containersLastValues[i][0]+containersLastValues[i][1]){
                  if(i<(containersLastValues.length-1) && containersLastValues[i][0]==containersLastValues[i+1][0]){
                    if(items[j][0]==items[j+1][0]){
                      var intvalue2 = Math.floor( containersLastValues[i+1][2] );
                      var alertvalue = items[j][4];
                      var alertvalue2 = items[j+1][4];

                      if(intvalue<=alertvalue || intvalue2<=alertvalue2){
                        $('#alert'+items[j][0]).show();
                      }
                      else{
                        $('#alert'+items[j][0]).hide();
                      }
                    }
                    else{
                      var intvalue2 = Math.floor( containersLastValues[i+1][2] );
                      var alertvalue = items[j][4];
                      var alertvalue2 = items[j-1][4];

                      if(intvalue<=alertvalue || intvalue2<=alertvalue2){
                        $('#alert'+items[j-1][0]).show();
                      }
                      else{
                        $('#alert'+items[j-1][0]).hide();
                      }
                    }
                  }
                  else if(containersLastValues[i][0]==containersLastValues[i-1][0]){

                  }
                  else{
                    var alertvalue = items[j][4];
                    if(intvalue<=alertvalue || intvalue2<=alertvalue2){
                        $('#alert'+items[j][0]).show();
                      }
                      else{
                        $('#alert'+items[j][0]).hide();
                      }
                  }
                }
              }
                
              
            }
          }

  });
  setTimeout(getLastValues,10000);
}
   
        /**
         * Initiate the Charts of last values with highchart
         * @method initiateChart
         * @param {} id_div id of the div which contain the graph.
         * @param {} type Type of the container.
         * @param {} max_value Maximum value that can hold the container.
         * @param {} alert_value If the container reached this value, there is an alert
         */
        function initiateChart(id_div,type,max_value,alert_value) {

    $('#'+id_div).highcharts({
        exporting: { enabled: false },
        credits: {
      enabled: false
  },
        title: {
    text: '',
    style: {
        display: 'none'
    }
},
subtitle: {
    text: '',
    style: {
        display: 'none'
    }
},
        chart: {
            type: 'gauge',
            enabled:false,
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '100%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },

        // the value axis
        yAxis: {
            min: 0,
            max: max_value,

            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Liters'
            },
            plotBands: [{
                from: 0,
                to: alert_value,
                color: '#DF5353' // red
                
            }, {
                from: alert_value,
                to: max_value,
                color: '#55BF3B' // green
            }]
        },

        series: [{
            name: type,
            data: [0],
            tooltip: {
                valueSuffix: 'Liters'
            }
        }]

    });
  }; //end of function initiatechart (One value)

  /**
   * Initiate the chart when there is a double type
   * @method initiateDoubleChart
   * @param {} id_div1 id of the first division which contain the left part of the graph.
   * @param {} type1 Type of the first container.
   * @param {} max_value1 Maximum value that can hold the first container.
   * @param {} alert_value1 If the first container reached this value, there is an alert.
   * @param {} id_div2 id of the second division which contain the left part of the graph.
   * @param {} type2 Type of the second container.
   * @param {} max_value2 Maximum value that can hold the second container
   * @param {} alert_value2 If the second container reached this value, there is an alert.
   */
  function initiateDoubleChart(id_div1,type1,max_value1,alert_value1,id_div2,type2,max_value2,alert_value2) {

    gaugeOptions = {

        chart: {
            type: 'solidgauge'
        },

        title: null,

        pane: {
            center: ['50%', '85%'],
            size: '140%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },

        tooltip: {
            enabled: false
        },

        // the value axis
        yAxis: {
            stops: [
                [alert_value1/max_value1, '#DF5353'], // red
                [(alert_value1/max_value1), '#55BF3B'] // green
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    // The speed gauge
    $('#'+id_div1).highcharts(Highcharts.merge(gaugeOptions, {
        exporting: { enabled: false },
        credits: {
      enabled: false
  },
subtitle: {
    text: '',
    style: {
        display: 'none'
    }
},
        yAxis: {
            min: 0,
            max: max_value1,
            title: {
                text: type1
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: type1,
            data: [30],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">Liters</span></div>'
            },
            tooltip: {
                valueSuffix: ' Liters'
            }
        }]

    }));

    // The RPM gauge
    $('#'+id_div2).highcharts(Highcharts.merge(gaugeOptions, {
        exporting: { enabled: false },
        credits: {
      enabled: false
  },
subtitle: {
    text: '',
    style: {
        display: 'none'
    }
},
        yAxis: {
            min: 0,
            max: max_value2,
            title: {
                text: type2
            }
        },

        series: [{
            name: type2,
            data: [1],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:20px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                       '<span style="font-size:12px;color:silver">Liters</span></div>'
            },
            tooltip: {
                valueSuffix: 'Liters'
            }
        }]

    }));
  };
    