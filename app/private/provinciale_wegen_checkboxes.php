<?php
  $wegen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_wegen.json"), true);
  foreach ($wegen as $id => $weg) {
    $wegen[$id]["id"] = $id;
  }
  usort($wegen, function ($a, $b) {
    return $b["naam"] < $a["naam"];
  });
  foreach ($wegen as $weg) {
    if (!empty($weg["communicatie_naam"])) {
?>
    <label>
      <input type="checkbox" name="objecten[]" value="<?php echo $weg["id"]; ?>">
      <?php
        echo $weg["communicatie_naam"];
        if (!empty($includeStats) && !empty($stats["objecten"][$weg["id"]])) {
          echo " ({$stats["objecten"][$weg["id"]]})";
        }
      ?>
    </label>
    <br>
<?php
    } // if
  } // foreach
