<?php
  foreach ($provinciale_wegen["features"] as $feature) {
    if (!empty(trim($feature["properties"]["N_WEG"]))) {
?>
  <label>
    <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["N_WEG"]; ?>">
    <?php echo $feature["properties"]["NAAM"]; ?> (<?php echo $feature["properties"]["N_WEG"]; ?>)
  </label>
  <br>
<?php
    } // if
  } // foreach
