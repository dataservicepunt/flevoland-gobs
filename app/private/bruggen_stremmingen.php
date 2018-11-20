<?php
  $bruggen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_bruggen.json"), true);
  foreach ($bruggen as $id => $brug) {
    if (!empty($brug["communicatie_naam"])) {
?>
    <label>
      <!-- <input type="checkbox" class="switch" name="objecten[]" value="<?php echo $id; ?>"> -->
      <img class="switch" src="../assets/switch_geen_stremming.png" style="width: 60px;">
      <?php echo $brug["communicatie_naam"]; ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
