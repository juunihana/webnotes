<?php
$dbh = pg_connect("host=localhost dbname=webnotes user=postgres password=postgres") or die("Cannot connect to database" . pg_last_error());

//Get notes list
$notes_list = pg_query($dbh, "SELECT * FROM notes");

//New note
if(!isset($_GET['id']) && isset($_POST['note-submit'])) {
  pg_query($dbh, "INSERT INTO notes(id, title, content) VALUES(DEFAULT, '" . $_POST['note-title'] . "', '" . $_POST['note-content'] . "')");
}

//Get note with ID
$note_current = '';
if(isset($_GET['id'])) {
  $note_current = pg_fetch_assoc(pg_query($dbh, "SELECT * FROM notes WHERE id=".$_GET['id']));
  //Update note
  if(isset($_POST['note-submit'])) {
    pg_query($dbh, "UPDATE notes SET title='" . $_POST['note-title'] . "', content='" . $_POST['note-content'] . "' WHERE id=" . $_GET['id'] . ")");
  }
}

pg_close($dbh);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Title</title>

<link href="style.css" rel="stylesheet" />
</head>
<body>
  <div class="webnotes-container">
    <div class="webnotes-panel padding-5 margin-5">
      <div class="webnotes-menu">
      <?php
      if(isset($notes_list)) {
        while($note = pg_fetch_assoc($notes_list)) {
          ?><div class="webnote-menu-elem"><a href="/?id=<?=$note['id']?>"><?=$note['title']?></a></div>
        <?php  }
      }
      ?>
    </div>
    </div>
    <div class="webnotes-panel padding-5 margin-5">
      <form action="/" method="POST">
        <div class="webnotes-panel webnotes-toolbar">
          <button class="webnotes-panel webnotes-button padding-5" type="submit" name="note-submit">Save</button>
        </div>
        <input class="webnotes-panel webnotes-editor margin-bottom-5 padding-5" type="text" name="note-title" placeholder="Title"
        value="<?=isset($_GET['id']) ? $note_current['title'] : ''?>" />
        <textarea class="webnotes-panel webnotes-editor webnotes-editor-content padding-5" rows="10" name="note-content" resize="none"><?=isset($_GET['id']) ? $note_current['content'] : ''?></textarea>
      </form>
    </div>
  </div>
</body>
</html>
