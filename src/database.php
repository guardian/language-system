<?php
// Connects to your Database
mysql_connect("localhost", "ls", "test") or die(mysql_error());
mysql_select_db("language_system") or die(mysql_error());
?>