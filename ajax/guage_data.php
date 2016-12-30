<?php

    if (isset($_GET['node']) && isset($_GET['building']) && isset($_GET['country']) && isset($_GET['city']) && isset($_GET['location']) && isset($_GET['sensor'])) {
        session_start();
        include('../db/database.php');
        $conn = new connection();
       
        $mpm = $conn->num_rows($conn->select("message_log", "ID", "Date>'".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s",time()))-60)."'"));
        $mph = $conn->num_rows($conn->select("message_log", "ID", "Date>'".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s",time()))-60*60)."'"));
        $reading_record = $conn->fetch_assoc($conn->select("message_log", "Message, Date", "1 ORDER BY Date DESC LIMIT 1"));
        $reading = $reading_record['Message'];
        $latency = 40;
        $date = $reading_record['Date'];
        echo json_encode(array($mpm, $mph, $reading, $latency, $date));
    } else {
        echo "ERROR";
    }

?>