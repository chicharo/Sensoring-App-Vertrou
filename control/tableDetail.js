$(document).ready(function(){

initiateTable();
initiateDetail();
init_map();



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

    function initiateDetail(){

    $.ajax({

      dataType: "json",
      url: '../model/getDetail.php',

      success: function(result){
        var text;
        result.forEach(function(d){
          text = document.createTextNode(d.details);
        });

        div = document.getElementById('details');
        div.appendChild(text);
      }
    });
        

    }

    function init_map() {
  var longitude;
  var latitude; 
  $.ajax({
      dataType: "json",
      url: '../model/getLoc.php',
      /**
       * If the ajax success, we launch this method
       * This function use the JSON file of localisation of container and store this localisation in two variables for the longitude and latitude
       * @method success
       * @param {} result
       */
      success: function(result){
        
        result.forEach(function(d){
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


    });