<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_POST['send_emails'])) {
    $query = "SELECT * FROM tblstudents WHERE DATE_FORMAT(dateOfBirth, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $to = $row['mail'];
            $subject = 'Birthday Wishes';
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

            .birthday-wish {
                background-color: #3498db;
                color: #fff;
                padding: 10px;
                border-radius: 5px;
                margin-top: 20px;
                display: inline-block;
                text-decoration: none;
            }

            .birthday-image {
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
            <p>Happy Birthday, ' . $row['firstName'] . ' ' . $row['lastName'] . ' 👋!</p>
            <p>Wishing you a day filled with laughter, love, and all the things that make you smile.</p>
            <a href="https://marketplace.canva.com/EAFaLHMu28k/2/0/1600w/canva-blue-vivid-happy-birthday-greeting-card-GxtAr-E9cTk.jpg" class="download-link" download="birthday_file.pdf">Download Your Birthday Gift</a>
            <img src="https://www.funimada.com/assets/images/cards/big/bday-643.gif" alt="Birthday Greetings" class="birthday-image">
            <p class="quote">"Aging is not lost youth but a new stage of opportunity and strength." - Betty Friedan</p>
            <p class="additional-message">May this year bring you new opportunities, wonderful experiences, and endless joy.</p>
            <p class="footer">Best regards,<br>CAAZ Information Security</p>
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
        echo 'No birthday students found.';
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
    <?php include 'includes/title.php'; ?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">



    <script>
        function classArmDropdown(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
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
                        <h1 class="h3 mb-0 text-gray-800">Today's Birthday Students</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Today's Birthday Students</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="table-responsive p-3">
                                            <form method="post" action="" onsubmit="return confirmSendEmails();">
                                                <button type="submit" name="send_emails" class="btn btn-primary btn-sm"
                                                    style="margin-left:90rem;"><i class="fa fa-envelope">&nbsp;
                                                        Birthday</i></button>
                                            </form>
                                            <table class="table align-items-center table-flush table-hover"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" id="selectAll" />
                                                        </th>
                                                        <th>#</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Date of Birth</th>
                                                        <th>Email Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Admission No</th>
                                                        <th>Class</th>
                                                        <th>WhatsApp</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                                                    $query = "SELECT tblstudents.Id, tblclass.className, tblclassarms.classArmName, tblclassarms.Id AS classArmId,
                                                    tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.dateOfBirth,
                                                    tblstudents.mail, tblstudents.admissionNumber, tblstudents.phoneNumber, tblstudents.dateCreated
                                                    FROM tblstudents
                                                    INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                                                    INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                                                    WHERE DATE_FORMAT(tblstudents.dateOfBirth, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')";

                                                    $rs = $conn->query($query);
                                                    $num = $rs->num_rows;
                                                    $sn = 0;
                                                    $status = "";
                                                    if ($num > 0) {
                                                        while ($rows = $rs->fetch_assoc()) {
                                                            $sn = $sn + 1;
                                                            $cleanPhoneNumber = urlencode(preg_replace('/[^0-9]/', '', $rows['phoneNumber']));
                                                            $countryCode = '+91';
                                                            $birthdayWish = rawurlencode("Happy Birthday, {$rows['firstName']}! 🎉🎂 Wishing you a fantastic day filled with joy and celebrations. 🥳");
                                                            $whatsappLink = 'https://wa.me/' . $countryCode . $cleanPhoneNumber . '?text=' . $birthdayWish;
                                                            echo "
                                                                <tr>
                                                                    <td><input type='checkbox' class='select-checkbox' name='selected_students[]' value='{$rows['Id']}' /></td>
                                                                    <td>{$sn}</td>
                                                                    <td>{$rows['firstName']}</td>
                                                                    <td>{$rows['lastName']}</td>
                                                                    <td>{$rows['dateOfBirth']}</td>
                                                                    <td>{$rows['mail']}</td>
                                                                    <td>{$rows['phoneNumber']}</td>
                                                                    <td>{$rows['admissionNumber']}</td>
                                                                    <td>{$rows['className']}</td>
                                                                    <td><a href='{$whatsappLink}' style='font-size:30px; color:#25D366;' target='_blank' title='Send WhatsApp Birthday Wishes'><i class='fab fa-whatsapp'></i></a></td>
                                                                </tr>";
                                                        }

                                                    } else {
                                                        echo
                                                            "<div class='alert alert-danger' role='alert'>
                                                                No Record Found!
                                                            </div>";
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
            function toggleCheckboxes() {
                var checkboxes = document.getElementsByClassName('select-checkbox');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = document.getElementById('selectAll').checked;
                }
            }

            document.getElementById('selectAll').addEventListener('click', toggleCheckboxes);

            function confirmSendEmails() {
                var selectedCheckboxes = document.querySelectorAll('input[name="selected_students[]"]:checked');
                if (selectedCheckboxes.length > 0) {
                    return confirm("Are you sure you want to send birthday emails to the selected students?");
                } else {
                    alert("Please select at least one student.");
                    return false;
                }
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