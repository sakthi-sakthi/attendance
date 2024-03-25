<?php
include 'Includes/dbcon.php';

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

                    .footer {
                        margin-top: 20px;
                        color: #777;
                        font-size: 14px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1 style="color: #2c3e50; font-size: 28px; margin-bottom: 10px;">' . $subject . '</h1>
                    <p style="color: #34495e; font-size: 16px;">Happy Birthday, ' . $row['firstName'] . ' ' . $row['lastName'] . '!</p>
                    <p class="birthday-wish" style="background-color: #3498db; color: #fff; padding: 10px; border-radius: 5px; margin-top: 20px; display: inline-block; text-decoration: none;">Send Birthday Wish</p>
                    <p style="color: #555; font-size: 16px;">If you didn\'t request this, please ignore this email.</p>
                    <p class="footer" style="margin-top: 20px; color: #777; font-size: 14px;">Best regards,<br>CAAZ Information Security</p>
                </div>
            </body>
            </html>
        ';

        $api_key = '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';
        $url = 'https://api.sendinblue.com/v3/smtp/email';

        $data = [
            'to' => [['email' => $to]],
            'subject' => $subject,
            'htmlContent' => $message
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
        }

        curl_close($ch);

        echo 'Email sent successfully!';
    }
} else {
    echo 'No birthday students found.';
}
?>