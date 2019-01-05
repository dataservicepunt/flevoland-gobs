<?php

class Sender {

  private $_apiUrl;
  private $_originator;
  private $_accessToken;

  public function __construct($apiUrl, $originator) {
    $this->_apiUrl = $apiUrl;
    $this->_originator = $originator;
  }

  /**
   * Sets the access token for the SMS api.
   */
  public function setAccessToken($accessToken) {
    $this->_accessToken = $accessToken;
  }

  /**
   * Sends a batch of messages.
   */
  private function _sendBatch($apiUrl, $accessToken, $originator, $smsText, $telefoonnummers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: AccessKey {$accessToken}",
      "Accept: applications/json"
    ]);
    $postfields = [
      "originator" => $originator,
      "body" => $smsText,
      "recipients" => $telefoonnummers
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $rs = json_decode(curl_exec($ch));
    curl_close ($ch);
    return $rs;
  }

  /**
   * Sends SMS message.
   */
  public function send($telefoonnummers, $smsText) {
    $rs = [];
    for ($i = 0; $i < sizeof($telefoonnummers); $i += 50) { //FIXME hardcoded
      $slice = array_slice($telefoonnummers, $i, 50);
      $rs[] = $this->_sendBatch(
        $this->_apiUrl,
        $this->_accessToken,
        $this->_originator,
        $smsText,
        $slice
      );
    }
    return $rs;
  }

}
