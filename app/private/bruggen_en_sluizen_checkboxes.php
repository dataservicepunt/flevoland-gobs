<?php
  foreach ($bruggen_en_sluizen["features"] as $feature) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["nummer"]; ?>">
      <?php echo $feature["properties"]["naam"]; ?>
    </label>
    <br>
<?php
  }
