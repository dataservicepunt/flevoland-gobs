<?php
  $bruggen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_bruggen.json"), true);
  foreach ($bruggen as $id => &$brug) {
    $brug["id"] = $id;
  }
  usort($bruggen, function ($a, $b) {
    return $b["communicatie_naam"] < $a["communicatie_naam"];
  });
  foreach ($bruggen as $brug) {
    if (!empty($brug["communicatie_naam"])) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $brug["id"]; ?>">
      <?php
        echo $brug["communicatie_naam"];
        if (!empty($includeStats) && !empty($stats["objecten"][$brug["id"]])) {
          echo " ({$stats["objecten"][$brug["id"]]})";
        }
      ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
