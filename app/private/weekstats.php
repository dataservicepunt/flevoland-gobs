<style>
.label {
  padding: 4px;
  border-radius: 2px;
  color: #333;
  font-weight: 100;
  font-size: 12px;
  margin: 10px 10px 10px 0;
  display: block;
}
.label.--yellow {
  background: #FBB907;
}
.label.--green {
  background: #65B32E;
  color: white;
}
.label.--red {
  background: #dc3545;
  color: white;
}
h2 {
  margin-top: 40px;
}
</style>
<?php
  $rs = json_decode(file_get_contents("https://sms.flevowegen.nl/api/aanmeldingen/"), true);

  $wegen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_wegen.json"), true);
  $sluizen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_sluizen.json"), true);
  $bruggen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_bruggen.json"), true);

  function printObjectLabel($object_id) {
    global $wegen, $sluizen, $bruggen;
    if (!empty($wegen[$object_id]))
      $object = $wegen[$object_id]["communicatie_naam"];
    else if (!empty($sluizen[$object_id]))
      $object = $sluizen[$object_id]["communicatie_naam"];
    else if (!empty($bruggen[$object_id]))
      $object = $bruggen[$object_id]["communicatie_naam"];
    else
      $object = "onbekend";
    ?>
      <span class="label <?php echo $object === "onbekend" ? "--red" : "--yellow"; ?>">
        <?php echo $object; ?>
      </span>
    <?php
  }

  $logs = array_reverse($rs["week_by_week"]);

  $buckets = [];

  foreach ($logs as $log) {
    $date = new DateTime($log["datetime"]);
    $jaar = $date->format("Y");
    $week = $date->format("W");
    $buckets[$jaar][$week][$log["object"]][$log["mutation"]]++;
  }

  foreach ($buckets as $jaar => $weken) {
    foreach ($weken as $week => $objecten) {
      echo "<h2>{$jaar} week {$week}</h2>";
      foreach ($objecten as $object => $mut) {
        printObjectLabel($object);
        if ($mut["aanmelding"]) {
          echo "+{$mut["aanmelding"]}<br>";
        }
        if ($mut["afmelding"]) {
          echo "-{$mut["afmelding"]}<br>";
        }
      }
    }
  }
