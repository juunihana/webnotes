<?php
$dbh = pg_connect("host=localhost dbname=webnotes user=postgres") or die("Cannot connect to database" . pg_last_error());
pg_query("INSERT INTO notes(id, note_content) VALUES(DEFAULT, '" . $_POST['note-content'] . "')");
pg_close($dbh);
?>
