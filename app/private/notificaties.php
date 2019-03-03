<?php
  $rs = json_decode(file_get_contents("https://sms.flevowegen.nl/api/notificaties/"), true);
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
      <span class="object-label" style="
        background: #FBB907;
        color: #333;
        font-weight: 100;
        font-size: 12px;
        padding: 4px;
        border-radius: 2px"
      ><?php echo $object; ?></span>
    <?php
  }

  rsort($rs["notifications"]);
  foreach ($rs["notifications"] as $notificatie) {
?>
    <div class="notificatie">
      <p><?php echo $notificatie["datetime"]; ?></p>
      <p>
<?php
  foreach ($notificatie["objecten"] as $object) {
    printObjectLabel($object);
  }
?>
      </p>
      <p><?php echo $notificatie["smsText"]; ?></p>
      <hr>
    </div>
<?php
  } // foreach
