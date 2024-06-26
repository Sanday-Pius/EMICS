<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }


        /* Style for the form container */
.form-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style for form headings */
.form-container h2 {
    text-align: center;
    color: #333;
}

/* Style for form labels */
.form-container label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

/* Style for form inputs */
.form-container input[type="text"],
.form-container input[type="date"],
.form-container input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box; /* Ensures padding and border are included in the width */
}

/* Style for submit button */
.form-container input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-container input[type="submit"]:hover {
    background-color: #0056b3;
}



</style>
</head>
<body>
    <?php

session_start();

// Include the file containing database connection details
include("../connection.php");

// Check if user is logged in
if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("location: ../login.php");
    exit; // Stop further execution
}

$useremail = $_SESSION["user"];

// Fetch user details from the database
$sqlmain = "SELECT * FROM patient WHERE pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();

// Check if user details were fetched successfully
if ($result->num_rows == 0) {
    // Handle error: user details not found
    header("location: ../login.php");
    exit; // Stop further execution
}

$userfetch = $result->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

// Close the database connection
// $stmt->close();
// $database->close();

// Remaining HTML and PHP code...

 ?>
 <div class="container">
        <div class="menu">
             <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                        <td class="menu-btn menu-icon-home " >
                            <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                        </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="schedule.php" method="post" class="header-search">

                                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" >&nbsp;&nbsp;
                                        
                                        <?php
                                            echo '<datalist id="doctors">';
                                            $list11 = $database->query("select DISTINCT * from  doctor;");
                                            $list12 = $database->query("select DISTINCT * from  schedule GROUP BY title;");
                                            
                                                                           


                                            for ($y=0;$y<$list11->num_rows;$y++){
                                                $row00=$list11->fetch_assoc();
                                                $d=$row00["docname"];
                                               
                                                echo "<option value='$d'><br/>";
                                               
                                            };


                                            for ($y=0;$y<$list12->num_rows;$y++){
                                                $row00=$list12->fetch_assoc();
                                                $d=$row00["title"];
                                               
                                                echo "<option value='$d'><br/>";
                                                                                         };

                                        echo ' </datalist>';
            ?>
                                        
                                
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                                $today = date('Y-m-d');
                                echo $today;

                                

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);font-weight:400;">Scheduled Sessions / Booking / <b>Review Booking</b></p>
                        
                    </td>
                    
                </tr>
                
                
                
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                            
                        <tbody>
                        
                            <?php
                            
                            if(isset($_GET["id"])) {
                                $id = $_GET["id"];
                               
                                
                                // Prepare the SQL statement with a placeholder for the id
                                $sqlmain = "SELECT * FROM schedule INNER JOIN doctor ON schedule.docid = doctor.docid WHERE schedule.scheduleid = ? ORDER BY schedule.scheduledate DESC;";
                            
                                // Prepare the statement
                                $stmt = $database->prepare($sqlmain);

                                // Bind the id parameter to the statement
                                $stmt->bind_param("s", $id);
                            
                                // Execute the statement
                                $stmt->execute();
                            
                                // Get the result set
                                $result = $stmt->get_result();
                                // Check if there are rows in the result set
                                if ($result->num_rows > 0) {
                                    // Fetch the row from the result set
                                    $row = $result->fetch_assoc();
                                    // var_dump($row);
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $docname = $row["docname"];
                                    $docemail = $row["docemail"];
                                    $scheduledate = $row["scheduledate"];
                                    $scheduletime = $row["scheduletime"];
                                    $sql2 = "SELECT * FROM appointment WHERE scheduleid = $id";
                                    $result12 = $database->query($sql2);
                                    
                                    $apponum = ($result12->num_rows) + 1;
                                   ?>
                                    <div class="form-container">

                                        <form action="booking-complete.php" method="post">
                                        <input type="hidden" name="scheduleid" value="<?= $scheduleid ?>">
                                        <input type="hidden" name="apponum" value="<?= $apponum ?>">
                                        <label for="pid">Patient ID:</label>
                                        <input type="text" id="pid" disabled name="pid" value="<?= $userid ?>" readonly><br>
                                        <label for="app_date">Appointment Date:</label>
                                        <input type="date" id="app_date" name="app_date" value="<?= $today ?>"><br>
                                        <input type="submit" name="booknow" value="Book Appointment">
                                        </form>
                                    </div>
                                    
                            <?php
                                    // Output HTML using the fetched data
                                } else {
                                    // Handle the case where no rows are found
                                    echo "No data found for the provided ID.";
                                }
                            
                                // Close the statement
                                $stmt->close();
                            } else {
                                // Handle the case where the ID parameter is not set
                                echo "No ID parameter provided in the URL.";
                            }                         
                              ?>
                              </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    
    
   
    </div>

</body>
</html>