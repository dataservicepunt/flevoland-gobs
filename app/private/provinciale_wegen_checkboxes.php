<?php
  $wegen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_wegen.json"), true);
  foreach ($wegen as $id => $weg) {
    $wegen[$id]["id"] = $id;
  }
  usort($wegen, function ($a, $b) {
    return $b["naam"] < $a["naam"];
  });
  $wegen = array_filter($wegen, function ($weg) {
    return !empty($weg["communicatie_naam"]);
  });

  $wegen_NOP = array_filter($wegen, function ($weg) {
    return $weg["regio"] === "NOP";
  });

  $wegen_F = array_filter($wegen, function ($weg) {
    return $weg["regio"] === "OF" || $weg["regio"] === "ZF";
  });

  echo "<h2 style='margin: 20px 0'>Flevopolders</h2>";

  foreach ($wegen_F as $weg) {
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
  } // foreach

  echo "<h2 style='margin: 20px 0'>Noordoostpolder en Urk</h2>";

  foreach ($wegen_NOP as $weg) {
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
  } // foreach
