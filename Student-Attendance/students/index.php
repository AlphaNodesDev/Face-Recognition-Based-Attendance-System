<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


$query_attendance = "SELECT COUNT(*) AS total_hours, SUM(CASE WHEN status = '1' THEN 1 ELSE 0 END) AS present_hours FROM tblattendance WHERE admissionNo = '$_SESSION[admissionNumber]'";
$result_attendance = $conn->query($query_attendance);
$row_attendance = $result_attendance->fetch_assoc();


$total_hours = $row_attendance['total_hours'];
$present_hours = $row_attendance['present_hours'];
$attendance_percentage = ($total_hours > 0) ? (($present_hours / $total_hours) * 100) : 0;


if ($attendance_percentage > 100) {
    $attendance_percentage = 100;
} elseif ($attendance_percentage < 0) {
    $attendance_percentage = 0;
}


$dasharray_value = $attendance_percentage . ", 100";

$query_student = "SELECT * FROM tblstudents
INNER JOIN tblclass ON tblclass.Id = tblstudents.classid
INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
WHERE tblstudents.Id = '$_SESSION[userId]'";
$rs_student = $conn->query($query_student);


if ($rs_student && $rs_student->num_rows > 0) {
    $rrw_student = $rs_student->fetch_assoc();

    
    $query_subjects = "SELECT id, subjectname FROM tblsubjects";
    $result_subjects = $conn->query($query_subjects);

    
    $subjects = array();

    
    if ($result_subjects->num_rows > 0) {
        
        while ($row_subject = $result_subjects->fetch_assoc()) {
            $subject_name = $row_subject['subjectname'];
            $subjects[$subject_name] = $row_subject;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>Dashboard</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        
        <?php include "Includes/sidebar.php";?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                
                <?php include "Includes/topbar.php";?>
                
                
                <?php if (isset($rrw_student)) : ?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Students Dashboard
                            (<?php echo $rrw_student['className'].' - '.$rrw_student['classArmName'];?>)</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="flex-wrapper">
                    <div class="single-chart">
                        <svg viewBox="0 0 36 36" class="circular-chart green">
                            <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle" stroke-dasharray="<?php echo $dasharray_value; ?>" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <text x="18" y="20.35" class="percentage"><?php echo $attendance_percentage; ?>%</text>
                        </svg>
                    </div>


                </div>
                
                <div class="cards">
                    <div class="card-single">
                        <div>
                            <h1><?php echo $total_hours ?></h1>
                            <span>Total hours</span>
                        </div>
                        <div>
                            <span class="class las la-users"></span>
                        </div>
                    </div>

                    <div class="card-single">
                        <div>
                            <h1><?php echo $present_hours ?></h1>
                            <span>Present hours</span>
                        </div>
                        <div>
                            <span class="class las la-clipboard"></span>
                        </div>
                    </div>


                </div>
                <div class="recent-grid">
                    <div class="projects">
                        <div class="card">
                            <div class="card-header">
                                <h3>My Attendance</h3>
                            </div>
                            <div class="card-body">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Subject</td>
                                            <td>Attendance (%)</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                    
                    foreach ($subjects as $subject_name => $subject_data) {
                        
                        $query_attendance_subject = "SELECT COUNT(*) AS total_hours, 
                                                        SUM(CASE WHEN status = '1' THEN 1 ELSE 0 END) AS present_hours 
                                                FROM tblattendance 
                                                WHERE admissionNo = '$_SESSION[admissionNumber]' 
                                                AND subject = '$subject_name'";
                        $result_attendance_subject = $conn->query($query_attendance_subject);
                        $row_attendance_subject = $result_attendance_subject->fetch_assoc();

                        
                        $total_hours_subject = $row_attendance_subject['total_hours'];
                        $present_hours_subject = $row_attendance_subject['present_hours'];
                        $attendance_percentage_subject = ($total_hours_subject > 0) ? (($present_hours_subject / $total_hours_subject) * 100) : 0;

                        
                        if ($attendance_percentage_subject > 100) {
                            $attendance_percentage_subject = 100;
                        } elseif ($attendance_percentage_subject < 0) {
                            $attendance_percentage_subject = 0;
                        }

                        
                        ?>
                                        <tr>
                                            <td><?php echo $subject_name; ?></td>
                                            <td><?php echo $attendance_percentage_subject . '%'; ?></td>
                                        </tr>
                                        <?php 
                    }
                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <?php include 'includes/footer.php';?>
                    
                </div>
            </div>

            
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="js/ruang-admin.min.js"></script>
            <script src="../vendor/chart.js/Chart.min.js"></script>
            <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>