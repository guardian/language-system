<?php
// Connects to the database
$database = mysqli_connect(getenv('DATABASE_HOST'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'), "language_system");
?>