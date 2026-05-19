<?php
if(isset($_POST['saveMeetLink'])) {
    $patientId       = (int)$_POST['patient_id'];
    $doctorId        = (int)$_POST['doctor_id'];
    $doctorEmail     = trim(mysqli_real_escape_string($conn, $_POST['doctor_email']));
    $meetDate        = trim(mysqli_real_escape_string($conn, $_POST['meet_date']));
    $meetTime        = trim(mysqli_real_escape_string($conn, $_POST['meet_time']));
    $symptomsSummary = trim(mysqli_real_escape_string($conn, $_POST['symptoms_summary']));
    $triageLevel     = trim(mysqli_real_escape_string($conn, $_POST['triage_level']));

    if($doctorId <= 0) {
        $emsg = "Please select a doctor.";
    } elseif(empty($doctorEmail) || !filter_var($doctorEmail, FILTER_VALIDATE_EMAIL)) {
        $emsg = "Please enter a valid doctor email.";
    } elseif(empty($meetDate)) {
        $emsg = "Please select a date.";
    } elseif(empty($meetTime)) {
        $emsg = "Please select a time.";
    } elseif(empty($symptomsSummary)) {
        $emsg = "Please enter a symptoms summary.";
    } else {
        // Auto-generate unique WebRTC room ID
        $roomId  = bin2hex(random_bytes(8));
        $baseUrl = 'http://localhost/my/ABUAD-Online-Hospital/src/admin/view/room.php';
        $meetUrl = $baseUrl . '?room=' . $roomId;

        // Get patient name
        $patRow  = dbSelect('users', 'fName, lName', "id=$patientId");
        $pat     = mysqli_fetch_array($patRow);
        $patName = htmlspecialchars($pat['fName'] . ' ' . $pat['lName']);

        // Get doctor name
        $docRow  = dbSelect('users', 'fName, lName', "id=$doctorId");
        $doc     = mysqli_fetch_array($docRow);
        $docName = 'Dr. ' . $doc['fName'] . ' ' . $doc['lName'];

        $formattedDate = date('l, F j, Y', strtotime($meetDate));
        $formattedTime = date('h:i A', strtotime($meetTime));

        // 1. Save/update meet_links
        $meetData = [
            'meet_url'  => $meetUrl,
            'doctor_id' => $doctorId,
            'meet_date' => $meetDate,
            'meet_time' => $meetTime,
        ];
        $existing = dbSelect('meet_links', 'id', "patient_id=$patientId");
        if($existing && mysqli_num_rows($existing) > 0) {
            $row = mysqli_fetch_array($existing);
            dbUpdate('meet_links', $meetData, "id=" . $row['id']);
        } else {
            dbInsert('meet_links', array_merge($meetData, [
                'patient_id' => $patientId,
                'admin_id'   => $uId,
            ]));
        }

        // 2. Get or create a doctor_schedule entry for this date/time
        $scheduleCheck = dbSelect('doctor_schedules', 'id', "doctor_id=$doctorId AND available_date='$meetDate' AND start_time='$meetTime'");
        if($scheduleCheck && mysqli_num_rows($scheduleCheck) > 0) {
            $scheduleId = (int)mysqli_fetch_array($scheduleCheck)['id'];
        } else {
            dbInsert('doctor_schedules', [
                'doctor_id'      => $doctorId,
                'available_date' => $meetDate,
                'start_time'     => $meetTime,
                'end_time'       => $meetTime,
                'is_booked'      => 1,
            ]);
            $scheduleId = (int)mysqli_insert_id($conn);
        }

        // 3. Create appointment record
        $apptCheck = dbSelect('appointments', 'id', "patient_id=$patientId AND doctor_id=$doctorId AND schedule_id=$scheduleId");
        if(!$apptCheck || mysqli_num_rows($apptCheck) == 0) {
            dbInsert('appointments', [
                'patient_id'       => $patientId,
                'doctor_id'        => $doctorId,
                'schedule_id'      => $scheduleId,
                'symptoms_summary' => $symptomsSummary,
                'triage_level'     => $triageLevel,
                'meeting_link'     => $meetUrl,
                'status'           => 'Accepted',
            ]);
        } else {
            $apptRow = mysqli_fetch_array($apptCheck);
            dbUpdate('appointments', [
                'symptoms_summary' => $symptomsSummary,
                'triage_level'     => $triageLevel,
                'meeting_link'     => $meetUrl,
                'status'           => 'Accepted',
            ], "id=" . $apptRow['id']);
        }

        // 4. Send email to doctor
        $subject = "Meeting Scheduled — ABUAD Online Hospital";
        $body    = "Dear $docName,\r\n\r\n"
                 . "You have a telemedicine session scheduled with patient $patName.\r\n\r\n"
                 . "Date    : $formattedDate\r\n"
                 . "Time    : $formattedTime\r\n"
                 . "Symptoms: $symptomsSummary\r\n"
                 . "Triage  : $triageLevel\r\n\r\n"
                 . "Meeting Link (WebRTC):\r\n$meetUrl\r\n\r\n"
                 . "Please join the meeting on time.\r\n\r\n"
                 . "Regards,\r\nABUAD Online Hospital Admin";

        $headers = "From: noreply@abuadoh.org\r\nContent-Type: text/plain; charset=UTF-8";
        mail($doctorEmail, $subject, $body, $headers);

        $smsg = "Meeting scheduled and appointment created! Link sent to $docName at $doctorEmail.";
    }
}
