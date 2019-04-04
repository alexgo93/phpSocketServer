<?php

namespace SocketServer\Run;

function runSocket()
{
    error_reporting(E_ALL);
    set_time_limit(0);
    ob_implicit_flush();

    $socket = stream_socket_server("tcp://127.0.0.1:4545", $errno, $errstr);

    if (!$socket) {
        die("$errstr ($errno)\n");
    }

    echo "Waiting for connection \n";

    while ($connect = stream_socket_accept($socket, -1)) {
        fwrite($connect, "Write a string of brackets for check it's balance \n");
        $userString = fread($connect, 1024);
        isBalanced($userString) ? fwrite($connect, "Balanced \n") : fwrite($connect, "Not balanced \n");

        fclose($connect);
        fclose($socket);
    }
}
