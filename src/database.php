<?php
// Connects to your Database

mysql_connect(getenv('DATABASE_HOST'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD') or die(mysql_error());
mysql_select_db("language_system") or die(mysql_error());
?>