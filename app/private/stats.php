<style>
.label {
  padding: 4px;
  border-radius: 2px;
}
.label.--yellow {
  background: #FBB907;
}
.label.--green {
  background: #65B32E;
  color: white;
}
</style>
<?php
  $rs = json_decode(file_get_contents("https://sms.flevowegen.nl/api/aanmeldingen/"), true);
  $logs = array_reverse($rs["logs"]);
  foreach ($logs as $log) {
?>
  <div>
    <p style="font-size: 12px"><?php echo $log["datetime"]; ?></p>
    <p>Nummer eindigend op <span class="label --yellow"><?php echo $log["telefoonnummer"]; ?></span> aangemeld voor of gewijzigd naar <span class="label --green"><?php echo $log["objecten"]; ?></span> object(en)</p>
    <hr>
  </div>
<?php
  } // foreach
