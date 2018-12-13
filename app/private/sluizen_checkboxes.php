<?php
  $sluizen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_sluizen.json"), true);
  foreach ($sluizen as $id => $sluis) {
    $sluizen[$id]["id"] = $id;
  }
  usort($sluizen, function ($a, $b) {
    return $b["communicatie_naam"] < $a["communicatie_naam"];
  });
  foreach ($sluizen as $sluis) {
    if (!empty($sluis["communicatie_naam"])) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $sluis["id"]; ?>">
      <?php
        echo $sluis["communicatie_naam"];
        if (!empty($includeStats) && !empty($stats["objecten"][$sluis["id"]])) {
          echo " ({$stats["objecten"][$sluis["id"]]})";
        }
      ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
