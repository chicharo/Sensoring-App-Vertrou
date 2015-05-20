<?php
/**
*@author Olivier Peurichard & Etienne Marois
*/
/**
*Take the id of the container 
*/
    session_start();

$idContainer=$_SESSION['idContainer'];

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
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

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
                            <a id="refresh" href="./tablesDetail.php" >Refresh</a>
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
                            <h2>Menu</h2>
                            <hr></hr>
                            <ul class = "nav nav-sidebar">
                                <li>
                                    <a href="./pageDetail.php?id=<?php echo $idContainer ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                                </li>
                                <li  class = "active">
                                    <a href="tablesDetail.php"><i class="fa fa-fw fa-table"></i> Tables</a>
                                </li>
                                </ul>
                        <hr style="height: 2px; color: #000000; background-color: #000000; width: 50%; border: none;"> 
                    <h4>Menu</h4>
                    <div id="details">
                        
                    </div>
                    <hr style="height: 2px; color: #000000; background-color: #000000; width: 50%; border: none;"> 
                    
                    <div id="map-container"></div>
                </div>
                </div>
        <div id="page-content-wrapper">
            <a href="#menu-toggle" class="btn btn-primary" id="menu-toggle">Toggle Menu</a>
                    	<!--Division which contain the graph -->
                 <hr></hr>
				<div class="table-responsive col-xs-10 col-md-10 col-md-offset-1 ">
                    <table class="display table" width ="100%" id="myTable">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Values</th>
                      </tr>
                    </thead>
                    <tbody id="myBody">
                    <tr>
                       <td><div id="resDate"> </div></td>
                       <td><div id="resType"></div></td>
                       <td><div id="resValue"> </div></td>
                    </tr>
                    </tbody>
                    </table>
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
    <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="../control/initiateGrid.js"></script>
<script src="../control/tableDetail.js"></script>
<script type="text/javascript" language="javascript" src="../control/jquery.dataTables.js"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    </footer>
</html>