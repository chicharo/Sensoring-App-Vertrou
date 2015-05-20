<?php
/**
*@author Olivier Peurichard & Etienne Marois
*/
/**
*Take the id of the container 
*/
    session_start();

        $idContainer = null;
        $idContainer = $_GET['id'];
        $_SESSION['idContainer']=$idContainer;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Details</title>

        <script src="../control/displayContainers.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=false"></script>

        <script src="bootstrap/js/jquery-1.10.2.js"></script> 
        <script src="bootstrap/js/bootstrap.js"></script> 
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link href="gridstack.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
        <link href="simple-sidebar.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

        <style>
            #map-container{
                height : 200px;
                width: 150px;
            }
            .liquidFillGaugeText { font-family: Helvetica; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li>
                            <a id="refresh" href="./pageDetail.php?id=<?php echo $idContainer ?>" >Refresh</a>
                        </li>
                        <li>
                            <a href="#">Settings</a>
                        </li>
                        <li>
                            <a href="#">Profile</a>
                        </li>
                        <li>
                            <a href="../model/logout.php">Logout</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
               <div id="wrapper">
                    <div id="sidebar-wrapper">
                        <div class="sidebar-nav">
                           
                            <hr></hr>
                            <ul class = "nav nav-sidebar">
                                <li class = "active">
                                    <a href="./pageDetail.php?id=<?php echo $idContainer ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                                </li>
                                <li>
                                    <a href="tablesDetail.php"><i class="fa fa-fw fa-table"></i> Tables</a>
                                </li>
                                </ul>
                        <hr style="height: 2px; color: #000000; background-color: #000000; width: 50%; border: none;"> 
                    <h4>Details</h4>
                    <div id="details">
                        
                    </div>
                    <hr style="height: 2px; color: #000000; background-color: #000000; width: 50%; border: none;"> 
                     <div id="map-container"></div>
                    
                   
                </div>
                 </div>
                 <div id="page-content-wrapper">
                    <a href="#menu-toggle" class="glyphicon glyphicon-th-list" id="menu-toggle"></a>
               <hr>
                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-10">
                    <div class="container-fluid">
                    	<!--Division which contain the graph -->
                    	<div id="contChart"  width ='100%' style="height:600px ; min-width: 310px;margin: 0 auto">

                    	</div>
    				</div>
                    
                    <input type="radio" name="mychart" class="mychart" id= "radio1" value="line" checked>Line</inuput>
                    <input type="radio" name="mychart" class="mychart" id= "radio2" value="column"  >Column</inuput>
                </div>
                <div class=" col-xs-12 col-md-12 col-lg-2">
                    <div class="container-fluid">
                        <svg id="fillgauge" height="50%"></svg>
                     </div>
                
                </div>   
                 

                </div>
				
         </div>
    </div>
</div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        
    </body>

    <footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>


        <script src="assets/js/jquery.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="../control/gridstack.js"></script>
        <script type="text/javascript" src="bootstrap/js/parseAjax.js"></script>
    <script type="text/javascript" src="bootstrap/js/popup.js"></script>
    
<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="../control/initiateGrid.js"></script>
<script src="../control/myCharts.js"></script>
<script type="text/javascript" language="javascript" src="../control/jquery.dataTables.js"></script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
<script src="../control/liquidFillGauge.js" language="JavaScript"></script>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    

    </footer>
</html>