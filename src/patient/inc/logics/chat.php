<?php

// Auto-delete chat messages older than 24 hours
mysqli_query($conn, "DELETE FROM chat_messages WHERE sent_at < NOW() - INTERVAL 24 HOUR");

$errs = [];
