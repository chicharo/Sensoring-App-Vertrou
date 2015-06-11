<?php

//---The HTML Page----------------------------------------------------------------------------------------------------
session_start();
if(isset($_SESSION['id_user'])){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Dashboard Template for Bootstrap</title>

        <script src="../control/displayContainers.js"></script>

        <script src="bootstrap/js/jquery-1.10.2.js"></script> 
        <script src="bootstrap/js/bootstrap.js"></script> 
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link href="gridstack.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
        <link href="simple-sidebar.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            <a id="refresh" href="dashboard.php" >Refresh</a>
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


        <div id="wrapper">
            <div id="sidebar-wrapper">
                <div class="sidebar-nav">
                    <h2>Menu</h2>
                    <hr></hr>
                    
                    <hr></hr>
                    
                        <label class="control-label" for="exampleInputFile">Pick what you want</label>
                        
                        <div class="checkbox">
                            
                        <?php
                $id_owner = $_SESSION['id_user'];
                            include("../model/sqlQueries.php");
                            $container_type = sqlContainers($id_owner);
                            
                            if(isset($container_type) AND $container_type !=null){
                                ?>
                                <label class="control-label">
                                    <!-- It is the checkbox element, when you change by a click the state of this,
                                    it launch the function displayContainersAll in the JavaScript file -->
                                    <input type="checkbox" checked="checked" onChange="displayContainersAll(this)">
                                    All
                                </label>
                                <?php
                                
                                for($e = 0; $e<count($container_type); $e++){
                                    $varContainer = $container_type[$e];
                                    //$idOfType = constructDivContainers($varContainer, $id_owner);
                                ?>
                                    <label class="control-label">
                                        <input type="checkbox" onChange="displayContainersCheckbox('<?php echo $varContainer ?>', this)">
                                        <?php echo $container_type[$e] ?>
                                    </label>
                                <?php
                                }
                            }
                            else{
                                echo 'You don\'t have containers';
                            }
                            ?>
                            
                        </div>
                   
                </div>
             </div>
            <div id="page-content-wrapper">
                <a href="#menu-toggle" class="btn btn-primary" id="menu-toggle">Toggle Menu</a>
                <div class="col-lg-12">
                    <h1>Tanks List</h1>
                    
                    <div class="container-fluid">
                        <div class="row">

                            <div class="grid-stack" data-gs-width="4"></div>
                            <ul class="pagination" id="pagination"></ul>
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
    <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="../control/initiateGrid.js"></script>
<script src ="../control/getContainerList.js"></script>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>




    </footer>
</html>

        <?php
//end of HTML page-----------------------------------------------------------------------------------------
}
else{
    echo 'You have to be connected for this page.';
    ?>
        <head>

        <title>Return to index</title>

        <meta http-equiv="refresh" content="3; URL=../vue/index.html">
        </head>
        <?php
}
?>
