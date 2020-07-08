<?php
$dbh = pg_connect("host=localhost dbname=webnotes user=postgres") or die("Cannot connect to database" . pg_last_error());
$result = pg_query("SELECT * FROM notes");
pg_close($dbh);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Title</title>
</head>
<body>
    <?php
    while($row = pg_fetch_assoc($result)) {
        ?>
        <div><?=$row['note_content']?></div>
        <?php
    }
    ?>
</body>
</html>
