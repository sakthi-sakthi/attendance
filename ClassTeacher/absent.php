<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_POST['send_emails'])) {
    $query = "SELECT ts.*
          FROM tblstudents ts
          JOIN tblattendance ta ON ts.admissionNumber = ta.admissionNo
          WHERE DATE_FORMAT(ts.dateOfBirth, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')
          AND ta.status = 0";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $to = $row['mail'];
            $subject = 'Absent Announcement';
            $message = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $subject . '</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #ecf0f1;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #2c3e50;
                font-size: 28px;
                margin-bottom: 10px;
            }

            p {
                color: #34495e;
                font-size: 16px;
                line-height: 1.6;
            }

            .absence-notice {
                background-color: #e74c3c;
                color: #fff;
                padding: 10px;
                border-radius: 5px;
                margin-top: 20px;
                display: inline-block;
                text-decoration: none;
            }

            .absence-image {
                margin-top: 20px;
                max-width: 100%;
                height: auto;
            }

            .quote {
                font-style: italic;
                color: #7f8c8d;
                margin-top: 10px;
            }

            .additional-message {
                margin-top: 20px;
                color: #555;
                font-size: 16px;
            }

            .footer {
                margin-top: 20px;
                color: #777;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>' . $subject . '</h1>
            <p>Dear ' . $row['firstName'] . ' ' . $row['lastName'] . ',</p>
            <p>We hope this message finds you well. Unfortunately, you were absent from class today.</p>
            <a href="https://www.avc.edu/sites/default/files/administration/hr/forms/Absence%20Notice_Leave%20Request_CLSF.pdf" class="absence-notice" download="absence_note.pdf">Download Absence Notice</a>
            <img src="https://c8.alamy.com/comp/2CCG33A/absent-sign-or-stamp-on-white-background-vector-illustration-2CCG33A.jpg" alt="Absent Notice" class="absence-image">
            <p class="quote">"Education is the most powerful weapon which you can use to change the world." - Nelson Mandela</p>
            <p class="additional-message">If you have any concerns or questions regarding your absence, please contact us at [Contact Information].</p>
            <p class="footer">Best regards,<br>Your School/Institution Name</p>
        </div>
    </body>
    </html>
';

            $api_key = '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';
            $url = 'https://api.sendinblue.com/v3/smtp/email';

            $data = [
                'to' => [['email' => $to]],
                'subject' => $subject,
                'htmlContent' => $message,
                'sender' => ['email' => 'sakthiganapathi@dbcyelagiri.edu.in']
            ];


            $headers = [
                'Content-Type: application/json',
                'api-key: ' . $api_key,
                'Reply-To: sakthiganapathis97@gmail.com '
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            } else {

            }

            curl_close($ch);
        }
    } else {
        echo 'No Absent students found.';
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
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php"; ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php"; ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">View Absent Details</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Absent Details</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">View Absent Details</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Select Date<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="date" class="form-control" name="dateTaken"
                                                    id="exampleInputFirstName" placeholder="Class Arm Name">
                                            </div>
                                        </div>
                                        <button type="submit" name="view" class="btn btn-primary">View
                                            Absent</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <form method="post" action="" onsubmit="return confirmSendEmails();">
                                                <button type="submit" name="send_emails" class="btn btn-primary btn-sm"
                                                    style="margin-left:90rem;">Send
                                                    Absent Emails</button>
                                            </form>
                                            <table class="table align-items-center table-flush table-hover"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Other Name</th>
                                                        <th>Admission No</th>
                                                        <th>Class</th>
                                                        <th>Class Sections</th>
                                                        <th>Session</th>
                                                        <th>Term</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php

                                                    if (isset($_POST['view'])) {
                                                        $dateTaken = $_POST['dateTaken'];

                                                        $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
                                                        tblclassarms.classArmName, tblsessionterm.sessionName, tblterm.termName,
                                                        tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
                                                        FROM tblattendance
                                                        INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                                                        INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                                                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                                                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                                                        INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                                                        WHERE tblattendance.dateTimeTaken = '$dateTaken' 
                                                        AND tblattendance.classId = '$_SESSION[classId]' 
                                                        AND tblattendance.classArmId = '$_SESSION[classArmId]' 
                                                        AND tblattendance.status = '0'"; // Filter for absent students
                                                    
                                                        $rs = $conn->query($query);
                                                        $num = $rs->num_rows;
                                                        $sn = 0;
                                                        $status = "";

                                                        if ($num > 0) {
                                                            while ($rows = $rs->fetch_assoc()) {
                                                                $sn = $sn + 1;
                                                                echo "
                                                                    <tr>
                                                                        <td>" . $sn . "</td>
                                                                        <td>" . $rows['firstName'] . "</td>
                                                                        <td>" . $rows['lastName'] . "</td>
                                                                        <td>" . $rows['otherName'] . "</td>
                                                                        <td>" . $rows['admissionNumber'] . "</td>
                                                                        <td>" . $rows['className'] . "</td>
                                                                        <td>" . $rows['classArmName'] . "</td>
                                                                        <td>" . $rows['sessionName'] . "</td>
                                                                        <td>" . $rows['termName'] . "</td>
                                                                        <td style='background-color:#FF0000'>Absent</td>
                                                                        <td>" . $rows['dateTimeTaken'] . "</td>
                                                                    </tr>";
                                                            }
                                                        } else {
                                                            echo "<div class='alert alert-danger' role='alert'>No Absent Students Found!</div>";
                                                        }
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Row-->

                        <!-- Documentation Link -->
                        <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
            </div>
          </div> -->

                    </div>
                    <!---Container Fluid-->
                </div>
                <!-- Footer -->
                <?php include "Includes/footer.php"; ?>
                <!-- Footer -->
            </div>
        </div>

        <!-- Scroll to top -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/ruang-admin.min.js"></script>
        <!-- Page level plugins -->
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script>
            function confirmSendEmails() {
                return confirm("Are you sure you want to send absent emails?");
            }
        </script>

        <!-- Page level custom scripts -->
        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable(); // ID From dataTable 
                $('#dataTableHover').DataTable(); // ID From dataTable with Hover
            });
        </script>
</body>

</html>