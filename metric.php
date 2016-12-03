<?php
$command = "/usr/bin/my-metric ".$_GET['n']." ".$_GET['v']." ".$_GET['t'];
system($command);
