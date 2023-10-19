<!--
    Name/ID: Viet Hoang Pham 104506968, Humayra Jahan 104757245
    Humayra Jahan is responsible for making SQL query statements of manage page 
    Assignment 2
-->
<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset = "utf-8" >
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <meta name = "description" content = "This is management page of HPM" >
    <meta name = "keywords" content = "Management page" >
    <!-- Developer of this page is Viet Hoang Pham, Humayra Jahan -->
    <meta name = "author" content = "Viet Hoang Pham, Humayra Jahan" >
    <title>HPM: Management</title>
    <!-- This css file styles manager website -->
    <link rel = "stylesheet" href = "styles/ManagerStyle.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel = "shortcut icon" href = "images/favicon.png">
</head>
<body id = "MainBackground">
    <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
            // Remove all session variables
            session_unset();

            // Destroy the session
            session_destroy(); 
            // The users have to login again when logout 
        }

        if(!isset($_SESSION["authenticated"])){
            header("Location: login.php"); // Redirect to the login page if not authenticated.
            exit;
        }
        if(isset($_SESSION["firstName"]) && isset($_SESSION["lastName"])){
            $currentName = $_SESSION["firstName"] . " " . $_SESSION["lastName"];
        } else {
            $currentName = "Unknown";
        }

        $sql_query = "";
        $sql_table = "eoi";
        $currentID = 'unactive';
        $currentApplicants = 'unactive';
        $currentAge = 'unactive';
        $currentJob = 'unactive';
        $currentAddress = 'unactive';
        $currentStatus = 'unactive';
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $sql_query = "SELECT * FROM $sql_table";
            $currentID = 'activeASC';
            $_SESSION["currentSort"] = "sortID";
            $_SESSION["sortOrder"] = "ASC";
        } else {
            if (isset($_POST["sortID"])) {
                // Sort by ID, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) && $_SESSION["currentSort"] == "sortID" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY EOInumber DESC";
                    $currentID = 'activeDESC';
                    $_SESSION["currentSort"] = "sortID";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY EOInumber ASC";
                    $currentID = 'activeASC';
                    $_SESSION["currentSort"] = "sortID";
                    $_SESSION["sortOrder"] = "ASC";
                }
            } elseif (isset($_POST["sortName"])) {
                // Sort by Applicants' Name, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) && $_SESSION["currentSort"] == "sortName" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY FirstName DESC";
                    $currentApplicants = 'activeDESC';
                    $_SESSION["currentSort"] = "sortName";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY FirstName ASC";
                    $currentApplicants = 'activeASC';
                    $_SESSION["currentSort"] = "sortName";
                    $_SESSION["sortOrder"] = "ASC";
                }
            } elseif (isset($_POST["sortAge"])) {
                // Sort by Age, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) && $_SESSION["currentSort"] == "sortAge" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY DateOfBirth DESC";
                    $currentAge = 'activeDESC';
                    $_SESSION["currentSort"] = "sortAge";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY DateOfBirth ASC";
                    $currentAge = 'activeASC';
                    $_SESSION["currentSort"] = "sortAge";
                    $_SESSION["sortOrder"] = "ASC";
                }
            } elseif (isset($_POST["sortJob"])) {
                // Sort by Preferred Job, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) &&$_SESSION["currentSort"] == "sortJob" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY JobRefNum DESC";
                    $currentJob = 'activeDESC';
                    $_SESSION["currentSort"] = "sortJob";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY JobRefNum ASC";
                    $currentJob = 'activeASC';
                    $_SESSION["currentSort"] = "sortJob";
                    $_SESSION["sortOrder"] = "ASC";
                }
            } elseif (isset($_POST["sortAdd"])) {
                // Sort by Address, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) && $_SESSION["currentSort"] == "sortAdd" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY SuburbOrTown, State, PostCode DESC";
                    $currentAddress = 'activeDESC';
                    $_SESSION["currentSort"] = "sortAdd";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY SuburbOrTown, State, PostCode ASC";
                    $currentAddress = 'activeASC';
                    $_SESSION["currentSort"] = "sortAdd";
                    $_SESSION["sortOrder"] = "ASC";
                }
            } elseif (isset($_POST["sortStatus"])) {
                // Sort by Status, toggle ascending and descending order
                if(isset($_SESSION["currentSort"]) && $_SESSION["currentSort"] == "sortStatus" && $_SESSION["sortOrder"] == "ASC"){
                    $sql_query = "SELECT * FROM $sql_table ORDER BY Status DESC";
                    $currentStatus = 'activeDESC';
                    $_SESSION["currentSort"] = "sortStatus";
                    $_SESSION["sortOrder"] = "DESC";
                } else {
                    $sql_query = "SELECT * FROM $sql_table ORDER BY Status ASC";
                    $currentStatus = 'activeASC';
                    $_SESSION["currentSort"] = "sortStatus";
                    $_SESSION["sortOrder"] = "ASC";
                }
            }
            // Add similar conditions for other sorting options
        }
    ?>

    <!--Developer: Viet Hoang Pham. This is Manager Navigation Menu and Header code. You should add this at the start of <body> element-->
    <?php include_once 'managermenuandheader.inc';?>
    <!--End of Navigation Menu Code.-->
    
    <main>
        <form method = "POST" action = "manage.php" id = "mainform">
            <div id = "serverquery">
                <div id = "deleteJobReference">
                    <label for = "delete">Job Reference</label>
                    <select id = "delete" name = "JobRefNum">
                        <option value = "null">Choose</option>
                        <option value = "00001">00001</option>
                        <option value = "00010">00010</option>
                        <option value = "00011">00011</option>
                        <option value = "00100">00100</option>
                        <option value = "00101">00101</option>
                    </select>
                    <button type = "submit" name = "deleteJobRefNum">Remove Records</button>
                </div>
                <div id = "searchQuery">
                    <label for = "search">Field</label>
                    <select id = "search" name = "JobRefNum">
                        <option value = "all">All</option>
                        <option value = "jobrefnum">Job Reference</option>
                        <option value = "firstname">First Name</option>
                        <option value = "lastname">Last Name</option>
                        <option value = "fullname">Full Name</option>
                        <option value = "status">Status</option>
                    </select>
                    <label for = "searchquery">Search</label>
                    <input type = "text" id = "searchquery" name = "searchquery" placeholder = "Search...">
                    <button type = "submit" name = "search">Search</button>
                </div>
            </div>
            <table>
                <tr id = "tableheader">
                    <?php 
                    echo "<th><button type = 'submit' name = 'sortID' id = $currentID>ID <i class = 'fa fa-sort'></i></button></th>
                    <th><button type = 'submit' name = 'sortName' id = $currentApplicants>Applicants <i class = 'fa fa-sort'></i></button></th>
                    <th><button type = 'submit' name = 'sortAge' id = $currentAge>Age <i class = 'fa fa-sort'></i></button></th>
                    <th><button type = 'submit' name = 'sortJob' id = $currentJob>Preferred Job <i class = 'fa fa-sort'></i></button></th>
                    <th><button type = 'submit' name = 'sortAdd' id = $currentAddress>Address <i class = 'fa fa-sort'></i></button></th>
                    <th><button type = 'submit' name = 'sortStatus' id = $currentStatus>Status <i class = 'fa fa-sort'></i></button></th>
                    <th>More/Edit</th>"
                    ?>
                    <th>Delete</th>
                </tr>
                    <?php
                        require_once("settings.php");
                        try{
                            // Attempt to connect to the database
                            $conn = mysqli_connect($host, $user, $pwd, $sql_db);
            
                            if (!$conn){
                                // Throw Exception if connection fail
                                throw new Exception('Database connection error: ' . mysqli_connect_error());
                            }

                            $result = mysqli_query($conn, $sql_query);
                            if (!$result) {
                                // Redirect to an error page if there is a connection problem
                                throw new Exception('Table query error: ' . mysqli_connect_error());
                            } 

                            while ($row = mysqli_fetch_assoc($result)) {
                                $EOInumber = $row['EOInumber'];

                                $fullName = $row['FirstName'] . " " . $row['LastName'];
                                $gender = $row['Gender'];
                                if ($gender == "male") $genderSign = " <i class = 'fa fa-mars'></i>";
                                elseif ($gender == "female") $genderSign = " <i class = 'fa fa-venus'></i>";
                                else $genderSign = " <i class = 'fa fa-question-circle'></i>";

                                // This block of code is convert the format of phone number to the format of "0123 456 789" consistently
                                $originalPhoneNumber = $row['PhoneNumber'];
                                $unformattedPhoneNumber = str_replace(' ', '', $originalPhoneNumber);
                                $phoneNumber = substr($unformattedPhoneNumber, 0, 4) . ' ' . substr($unformattedPhoneNumber, 4, 3) . ' ' . substr($unformattedPhoneNumber, 7);
                                $contactInfo = $row['Email'] . " - " . $phoneNumber;
                                
                                $dob = $row['DateOfBirth'];
                                $age = date_diff(date_create($dob), date_create('now'))->y;
                                
                                $reference = $row['JobRefNum'];
                                $jobTitle = "";

                                $sql_query2 = "SELECT * FROM jobs";
                                $result2 = mysqli_query($conn, $sql_query2);
                                $referenceNumbers = [];
                                $jobTitles = [];
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $ref = $row2['JobRefNum'];
                                    $jobtitle = $row2['JobTitle'];
                                    array_push($referenceNumbers, $ref);
                                    array_push($jobTitles, $jobtitle);
                                }
                        
                                for ($i = 0; $i < count($referenceNumbers); $i ++){
                                    if ($reference == $referenceNumbers[$i]){
                                        $jobTitle = $jobTitles[$i];
                                    }
                                }
                                if ($jobTitle == ""){
                                    $jobTitle = "No job in table";
                                }

                                $streetAddress = $row['StreetAddress'];
                                $addressInfo = $row['SuburbOrTown'] . ", " . $row['State'] . ", " . $row['PostCode'];

                                $status = $row['Status'];
                                if ($status == "New") $statusColor = 'statusNew';
                                elseif ($status == "Current") $statusColor = 'statusCurrent';
                                else $statusColor = 'statusFinal';
                                echo"<tr>
                                        <td class = 'mainTextName'> #$EOInumber </td>
                                        <td>
                                            <p class = 'mainTextName'>$fullName $genderSign</p>
                                            <p class = 'subText'>$contactInfo</p>
                                        </td>
                                        <td>$age</td>
                                        <td>
                                            <p class = 'mainText'>$jobTitle</p>
                                            <p class = 'subText'>$reference</p>
                                        </td>
                                        <td>
                                            <p class = 'mainText'>$streetAddress</p>
                                            <p class = 'subText'>$addressInfo</p>
                                        </td>
                                        <td><span class = $statusColor>$status</span></td>
                                        <td class = 'editContainer'><a href = 'edit.php?id=$EOInumber'><span class = 'editButton'><i class = 'fa fa-edit'></i></span><p>'</p></a></td>
                                        <td class = 'deleteContainer'><a href = 'delete.php?id=$EOInumber'><span class = 'deleteButton'><i class = 'fa fa-trash'></i></span><p>'</p></a></td>
                                    </tr>";
                            }
                            mysqli_close($conn);
                        }catch(Exception $e) {
                            // Redirect to an error page if there is a connection problem
                            header ("location: errorPageForConnection.html");
                        }
                    ?>
            </table>
            <!-- Pagination of the manage page -->
            <div id = "pagination">
                <a href = "">First</a>
                <a href = "">Previous</a>
                <a href = "" id = "currentPage">1</a>
                <a href = "">2</a>
                <a href = "">3</a>
                <a href = "">4</a>
                <a href = "">...</a>
                <a href = "">Next</a>
                <a href = "">Last</a>
            </div>
        </form>
    </main>
</body>
