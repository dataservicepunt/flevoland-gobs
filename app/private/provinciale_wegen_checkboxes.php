<?php
  $wegen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_wegen.json"), true);
  foreach ($wegen as $id => $weg) {
    if (!empty($weg["communicatie_naam"])) {
?>
  <label>
    <input type="checkbox" name="objecten[]" value="provinciale_weg_<?php echo $id; ?>">
    <?php echo $weg["communicatie_naam"]; ?>
  </label>
  <br>
<?php
    } // if
  } // foreach
