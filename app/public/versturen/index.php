<?php
  $bruggen_en_sluizen = json_decode(file_get_contents("https://www.dataservicepunt.nl/flevoland/data/bruggen_en_sluizen/bruggen_en_sluizen.geojson"), true);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.dataservicepunt.nl/flevoland/css/style.css">
    <title>Notificatie versturen</title>
    <style>
      textarea {
        width: 100%;
        min-height: 100px
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="wrapper">
        <a href="https://www.dataservicepunt.nl/flevoland/">Data&nbsp;Servicepunt&nbsp;Flevoland</a> |
        <a href="https://www.dataservicepunt.nl/flevoland/data/index.json">Dataportaal</a> |
        <a href="http://apps.dataservicepunt.nl/">App&nbsp;store</a> |
        <a href="mailto:flevoland@dataservicepunt.nl">flevoland@dataservicepunt.nl</a>
      </div>
    </nav>

    <header>
      <div class="wrapper">
        <img src="https://www.dataservicepunt.nl/flevoland/img/Logo.png" alt="Provincie Flevoland">
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; padding: 1rem; margin: auto;">
          <form method="POST">
            <fieldset>
              <legend>Notificatie versturen</legend>
              <p>Vul onderstaand formulier in om een notificatie te versturen in het kader van de beschikbaarheid van bruggen en sluizen.</p>
              <p>
                <label for="notificatie">Vul de notificatie in die u wilt versturen:</label><br>
                <textarea id="notificatie" name="notificatie" placeholder="Notificatie"></textarea>
              </p>
              <p>Selecteer de bruggen en sluizen waarop deze notificatie betrekking heeft:</p>
              <p>
<?php foreach ($bruggen_en_sluizen["features"] as $feature) { ?>
                <label>
                  <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["nummer"]; ?>">
                  <?php echo $feature["properties"]["naam"]; ?>
                </label>
                <br>
<?php } ?>
              </p>
              <p><button>Notificatie versturen</button></p>
            </fieldset>
          </form>
        </div>
      </div>
    </main>

    <footer>
      <div class="wrapper">
        <div style="display: flex">
          <div style="width: 150px">
            <img src="https://www.dataservicepunt.nl/flevoland/img/Logo-provincie-Flevoland.png?width=61&amp;height=83" alt="Logo Provincie Flevoland">
          </div>
          <div style="flex: auto">
            <h2>Meer informatie en contact</h2>
            <p><a href="mailto:flevoland@dataservicepunt.nl">flevoland@dataservicepunt.nl</a></p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
      $("form").submit(function (e) {
        e.preventDefault();
        var formData = $(e.target).serializeArray(),
            notificatie = {};
        $(formData).each(function (i, field) {
          if (field.name.substr(field.name.length - 2) === "[]") {
            field.name = field.name.substr(0, field.name.length - 2);
            if (!notificatie[field.name]) {
              notificatie[field.name] = [];
            }
            notificatie[field.name].push(field.value);
          } else {
            notificatie[field.name] = field.value;
          }
        });
        var apiUrl = "http://apis.dataservicepunt.nl/notificaties/";
        $.post(apiUrl, notificatie, function (response) {
          console.log(response);
          if (response.rs.errors) {
            alert(response.rs.errors[0].description);
          } else {
            alert("notificatie verstuurd naar " + response.rs.recipients.totalCount + " telefoonnummer(s)");
          }
        }, "json");
      });
    </script>
  </body>
</html>
