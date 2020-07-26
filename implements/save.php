<?php
    $fmid = str_replace("new-", "", $data[$name]);
    if (strpos($data[$name], "new") !== FALSE) {
        $query2 = "SELECT MAX(familie) as max FROM members";
        foreach($database->query($query2) as $row2) {
            $newId = $row2["max"] + 1;
        }
        $data[$name] = $newId;
        $query = "UPDATE members SET familie = $newId WHERE id = $fmid";
        $saved = $database->call($query);
        if ($saved) echo("Familie erstellt!<br>");
    }

?>