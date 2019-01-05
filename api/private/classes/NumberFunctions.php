<?php

class NumberFunctions {

  public function formatNumber($telefoonnummer) {
    $telefoonnummer = preg_replace("/[^0-9]/", "", $telefoonnummer);
    $telefoonnummer = preg_replace(["/^00316/", "/^06/", "/^316/"], "+316", $telefoonnummer);
    return $telefoonnummer;
  }

  public function validNumberFormat($telefoonnummer) {
    if (strpos($telefoonnummer, "+316") !== 0) {
      return false;
    }
    if (strlen($telefoonnummer) !== 12) {
      return false;
    }
    return true;
  }

}
