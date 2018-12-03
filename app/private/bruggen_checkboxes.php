<?php
  $bruggen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_bruggen.json"), true);
  usort($bruggen, function ($a, $b) {
    return $b["communicatie_naam"] < $a["communicatie_naam"];
  });
  foreach ($bruggen as $id => $brug) {
    if (!empty($brug["communicatie_naam"])) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $id; ?>">
      <?php
        echo $brug["communicatie_naam"];
        if (!empty($includeStats) && !empty($stats["objecten"][$id])) {
          echo " ({$stats["objecten"][$id]})";
        }
      ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
