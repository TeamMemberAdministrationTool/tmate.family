<?php 
    include("../../../functions.php");
    $window = $_REQUEST["window"];
    $id = $_REQUEST["id"];
?>
<h1>Familienmitglieder auswählen</h1>

<script>
    function selectFamilyId(id, names) {
        $("#family-select-id").val(id);
        $("#family-select-names").html(names);
        closeWindow(<?php echo($window); ?>);
    }
</script>

<?php
    if ($database->connected){
?>
<button class='btn' onclick='selectFamilyId(0, "niemand ausgewählt");'>niemanden auswählen</button>
<table>
    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th></th>
        <th></th>
    </tr>
<?php

        $json = file_get_contents("../config.json");
        $data = json_decode($json, TRUE);
        $cols = $data["database"]["members"];

        $vorname = $cols["vorname"];
        $nachname = $cols["nachname"];

        $query = "SELECT id,$vorname,$nachname,familie FROM members WHERE id <> $id";

        $output = $database->query($query);

        $families = array();
        $rows = array();

        foreach ($output as $row) {
            $mid = $row["id"];
            $family = $row["familie"];
            $firstname = $row[$vorname];
            $name = $row[$nachname];

            if ($family) {
                if (!in_array($family, $families)) {
                    $families[] = $family;
                    $rows[$family] = [$mid, $firstname, $name, $family];
                } else {
                    $rows[$family][4] += 1;
                }

            } else {
                $rows["s".$mid] = [$mid, $firstname, $name];
            }
        }
        
        foreach ($rows as $row) {
            $plus = "";
            $family = $row[3];
            if ($row[4]) {
                $plus = "und ".$row[4]." weitere";
            }
            echo("<tr>");
                echo("<td>".$row[1]."</td>");
                echo("<td>".$row[2]."</td>");
                echo("<td>$plus</td>");
                echo("<td>");
                    if (!$family) {
                        $family = "new-".$row[0];
                    }
                    echo("<button class='btn' id='btn-family-select-id-$family' onclick='selectFamilyId(\"$family\",\"".$row[1]." ".$row[2]." ".$plus."\")'>Auswählen</button>");
                echo("</td>");
            echo("</tr>");
        }
        echo("</table>");
    } else {
        echo("<i>Es muss eine gültige Verbindung zur Datenbank existieren.</i>");
    }


?>