<?php
$handle = printer_open();
printer_write($handle, "Texte à imprimer");
printer_close($handle);
?>