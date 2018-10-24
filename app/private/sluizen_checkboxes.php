<?php
  foreach ($bruggen_en_sluizen["features"] as $feature) {
    if (array_key_exists($feature["properties"]["nummer"], $mapping["sluizen"])) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["nummer"]; ?>">
      <?php echo $mapping["sluizen"][$feature["properties"]["nummer"]]; ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
