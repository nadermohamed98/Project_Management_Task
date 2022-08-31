<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700">
    <link rel="stylesheet" href="../assets/Layout/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="../assets/Layout/css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../assets/Layout/css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="../assets/Layout/css/nouislider.min.css" />
    <link rel="stylesheet" href="../assets/Layout/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/Layout/css/style.css" />
    <link rel="stylesheet" href="../assets/Layout/css/backend1.css" />

</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="../Dashboard/home.php"><i class="fa fa-home"></i> Project Manegment</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="dropdown <?php if(in_array(str_replace("Project manegment task/projects/","",$_SERVER['PHP_SELF']),["/projects.php","/EditProject.php","/DetailsProject.php","/AddNewProject.php"])){echo 'active';}else{echo '';} ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-list"></i> Projects
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../Dev_projects/onProccess.php"><i class="fa fa-spinner"></i> On Process</a></li>
                        <li><a href="../Dev_projects/done.php"><i class="fa fa-check"></i> Done</a></li>
                    </ul>
                </li>
                <li class="dropdown <?php if(in_array(str_replace("Project manegment task/tasks/","",$_SERVER['PHP_SELF']),["/AddNewTask.php","/EditTask.php","/DetailsTask.php","/tasks.php","/EditAssignedTask.php"])){echo 'active';}else{echo '';} ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-list"></i> Tasks
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../Dev_tasks/onProccess.php"><i class="fa fa-spinner"></i> On Process</a></li>
                        <li><a href="../Dev_tasks/done.php"><i class="fa fa-check"></i> Done</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i> <?php echo $Logged_name ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../auth/Logout.php"><i class="fa fa-lock"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <script src="../assets/Layout/js/jquery.min.js"></script>
    <script src="../assets/Layout/js/bootstrap.min.js"></script>
    <script src="../assets/Layout/js/slick.min.js"></script>
    <script src="../assets/Layout/js/nouislider.min.js"></script>
    <script src="../assets/Layout/js/jquery.zoom.min.js"></script>
    <script src="../assets/Layout/js/main.js"></script>
    <script src="../assets/Layout/js/backend.js"></script>
    
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[0].style.display = "";
                    tr[i].style.display = "";
                } else {
                    tr[0].style.display = "";
                    tr[i].style.display = "none";
                }
            }
        }
    } 
</script>
</body>

</html>