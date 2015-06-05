#!/usr/bin/env php
<?php

$pipes = array();    //an indexed array of file pointers that correspond
                     //to PHP's end of any pipes that are created
$process = null;     //resource (rep. child proc.) to be closed using proc_close() when done with it
$output = '';
$ret = -1;

/**
 * Start process
 *
 * @param string $cmd Command to execute
 * @param bool $wantinputfd Whether or not input fd (pipe) is required
 * @retun void
 */
function processStart($cmd, $wantinputfd = false)
{
    global $process, $pipes;

    $descriptorspec = array(
            0 => ($wantinputfd) ? array('pipe', 'r') : STDIN, // pipe/fd from which child will read
            1 => STDOUT,
            2 => array('pipe', 'w'), // pipe to which child will write any errors
            3 => array('pipe', 'w')  // pipe to which child will write any output
    );
    $cwd = null;  //The initial working dir for the command. This must
                  //be an absolute directory path, or NULL if you want
                  //to use the default value (the working dir of the current PHP process)
    $env = array('env_varname' => 'something');
                   //An array with the environment variables for the command
                   //that will be run, or NULL to use the same environment as the current PHP process

    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env);
}


/**
 * Stop process
 *
 * @return void
 */
function processStop()
{
    global $output, $pipes, $process, $ret;

    if (isset($pipes[0]) {
        fclose($pipes[0]);
        usleep(2000); //Why is this before fclose?
    }

    $output = '';
    while ($_ = fgets($pipes[3])) {
        $output .= $_;
    }

    $errors = '';
    while ($_ = fgets($pipes[2])) {
        fwrite(STDERR, $_);
        $errors++;
    }

    if ($errors) {
        fwrite(STDERR, "dialog output the above errors, giving up!\n");
        exit(1);
    }

    fclose($pipes[2]);
    fclose($pipes[3]);

    do {
        usleep(2000);
        $status = proc_get_status($process);
    } while ($status['running']);

    proc_close($process);
    $ret = $status['exitcode'];
}

// Test for yesno dialog box
processStart("dialog --backtitle 'dialog test' --title 'Little test' --output-fd 3 --yesno 'yesno dialog box' 0 70");
processStop();
echo "Exit code is $ret\n";

// Test for gauge dialog box
processStart("dialog --backtitle 'dialog test' --title 'Little test' --output-fd 3 --gauge  'Gauge dialog box' 0 70 0", true);
sleep(1);
fwrite($pipes[0], "XXX\n0\nFirst step\nXXX\n20\n");
sleep(1);
fwrite($pipes[0], "XXX\n20\nSecond step\nXXX\n50\n");
sleep(1);
fwrite($pipes[0], "XXX\n50\nThird step\nXXX\n80\n");
sleep(1);
fwrite($pipes[0], "XXX\n80\nFourth step\nXXX\n100\n");
sleep(1);
processStop();
echo "Exit code is $ret\n";

// Test for input dialog box
processStart("dialog --backtitle 'dialog test' --title 'Little test' --output-fd 3 --inputbox 'input dialog box' 0 70");
processStop();
echo "Output is $output\n";
echo "Exit code is $ret\n";

// Test for errors output
processStart("dialog --backtitle 'dialog test' --title 'Little test' --output-fd 3 --dummy 'my input box' 0 70");
processStop();

exit(0);