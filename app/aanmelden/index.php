<?php
  $bruggen_en_sluizen = json_decode(file_get_contents("https://www.dataservicepunt.nl/flevoland/data/bruggen_en_sluizen/bruggen_en_sluizen.geojson"), true);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Aanmelden</title>

    <style>
      .container {
        max-width: 32em !important;
      }
    </style>
  </head>
  <body>

    <div class="container">

      <form method="POST">
        <fieldset>
          <legend>Aanmelden</legend>

          <p>Vul onderstaand formulier in om u aan te melden voor notificaties over de beschikbaarheid van bruggen en sluizen.</p>

          <p>
            <label for="telefoonnummer">Voer het telefoonnummer in waarop u notificaties wenst te ontvangen:</label><br>
            <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer">
          </p>
          <p>Selecteer de bruggen en sluizen waarover u notificaties wenst te ontvangen:</p>
          <p>
<?php foreach ($bruggen_en_sluizen["features"] as $feature) { ?>
            <label>
              <input type="checkbox" name="objecten[]" value="<?=$feature["properties"]["nummer"]?>">
              <?=$feature["properties"]["naam"]?>
            </label>
            <br>
<? } ?>
          </p>

          <p><button>Selectie opslaan</button></p>
        </fieldset>
      </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
      $("form").submit(function (e) {
        e.preventDefault();
        var formData = $(e.target).serializeArray(),
            aanmelding = {};
        $(formData).each(function (i, field) {
          if (field.name.substr(field.name.length - 2) === "[]") {
            field.name = field.name.substr(0, field.name.length - 2);
            if (!aanmelding[field.name]) {
              aanmelding[field.name] = [];
            }
            aanmelding[field.name].push(field.value);
          } else {
            aanmelding[field.name] = field.value;
          }
        });
        $.post("/api/aanmeldingen/", aanmelding, function (response) {
          console.log(response);
        }, "json");
      });
    </script>
  </body>
</html>
