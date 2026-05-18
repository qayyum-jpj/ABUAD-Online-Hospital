<?php
if(isset($_POST['saveMeetLink'])) {
    $patientId   = (int)$_POST['patient_id'];
    $doctorId    = (int)$_POST['doctor_id'];
    $doctorEmail = trim(mysqli_real_escape_string($conn, $_POST['doctor_email']));
    $meetDate    = trim(mysqli_real_escape_string($conn, $_POST['meet_date']));
    $meetTime    = trim(mysqli_real_escape_string($conn, $_POST['meet_time']));

    if($doctorId <= 0) {
        $emsg = "Please select a doctor.";
    } elseif(empty($doctorEmail) || !filter_var($doctorEmail, FILTER_VALIDATE_EMAIL)) {
        $emsg = "Please enter a valid doctor email.";
    } elseif(empty($meetDate)) {
        $emsg = "Please select a date.";
    } elseif(empty($meetTime)) {
        $emsg = "Please select a time.";
    } else {
        // Auto-generate unique WebRTC room ID
        $roomId  = bin2hex(random_bytes(8));
        $baseUrl = 'http://localhost/my/ABUAD-Online-Hospital/src/admin/view/room.php';
        $meetUrl = $baseUrl . '?room=' . $roomId;

        // Get patient name
        $patRow   = dbSelect('users', 'fName, lName', "id=$patientId");
        $pat      = mysqli_fetch_array($patRow);
        $patName  = htmlspecialchars($pat['fName'] . ' ' . $pat['lName']);

        // Get doctor name
        $docRow   = dbSelect('users', 'fName, lName', "id=$doctorId");
        $doc      = mysqli_fetch_array($docRow);
        $docName  = 'Dr. ' . $doc['fName'] . ' ' . $doc['lName'];

        $formattedDate = date('l, F j, Y', strtotime($meetDate));
        $formattedTime = date('h:i A', strtotime($meetTime));

        // Save to database
        $data = [
            'meet_url'  => $meetUrl,
            'doctor_id' => $doctorId,
            'meet_date' => $meetDate,
            'meet_time' => $meetTime,
        ];

        $existing = dbSelect('meet_links', 'id', "patient_id=$patientId");
        if($existing && mysqli_num_rows($existing) > 0) {
            $row = mysqli_fetch_array($existing);
            dbUpdate('meet_links', $data, "id=" . $row['id']);
        } else {
            dbInsert('meet_links', array_merge($data, [
                'patient_id' => $patientId,
                'admin_id'   => $uId,
            ]));
        }

        // Send email to doctor
        $subject = "Meeting Scheduled — ABUAD Online Hospital";
        $body    = "Dear $docName,\r\n\r\n"
                 . "You have a telemedicine session scheduled with patient $patName.\r\n\r\n"
                 . "Date : $formattedDate\r\n"
                 . "Time : $formattedTime\r\n\r\n"
                 . "Meeting Link (WebRTC — anyone with the link can join):\r\n"
                 . "$meetUrl\r\n\r\n"
                 . "Please join the meeting on time.\r\n\r\n"
                 . "Regards,\r\nABUAD Online Hospital Admin";

        $headers = "From: noreply@abuadoh.org\r\nContent-Type: text/plain; charset=UTF-8";

        mail($doctorEmail, $subject, $body, $headers);

        $smsg = "Meeting scheduled! Link sent to $docName at $doctorEmail.";
    }
}
