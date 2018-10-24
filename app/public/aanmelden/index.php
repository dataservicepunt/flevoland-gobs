<?php
  $root = "https://raw.githubusercontent.com/dataservicepunt/flevoland/master";
  $dataRoot = "https://raw.githubusercontent.com/dataservicepunt/flevoland/blob/master";
  $dataRoot = "http://localhost:4000";
  $provinciale_wegen = json_decode(file_get_contents("{$dataRoot}/data/provinciale_wegen/provinciale_wegen.geojson"), true);
  $bruggen_en_sluizen = json_decode(file_get_contents("{$dataRoot}/data/bruggen_en_sluizen/bruggen_en_sluizen.geojson"), true);
  $navHtml = file_get_contents("https://www.dataservicepunt.nl/flevoland/partial_nav.html");
  $footerHtml = file_get_contents("https://www.dataservicepunt.nl/flevoland/partial_footer.html");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.dataservicepunt.nl/flevoland/css/style.css">
    <title>Aanmelden</title>
  </head>
  <body>

    <?php echo $navHtml; ?>

    <header>
      <div class="wrapper">
        <img src="<?php echo $root; ?>/img/Logo.png" alt="Provincie Flevoland">
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; margin: auto;">
          <form method="POST">
            <fieldset>
              <legend>Aanmelden</legend>
              <p>Vul onderstaand formulier in om u aan te melden voor notificaties over de beschikbaarheid van bruggen en sluizen.</p>
              <p>Ik wil SMS ontvangen als er iets aan de hand is met</p>
              <div style="display:flex">
                <style>
                  .tab-button {
                    flex: 1;
                    color: #005FAA;
                    text-align: center;
                    padding: 0 1em;
                    background: #005FAA05;
                    cursor: pointer;
                  }
                  .tab-button.active {
                    background: #005FAA1A;
                  }
                  .tab-button:not(:last-child) {
                    border-right: 1px solid #005FAA;
                  }
                  .tab-button:active {
                    background: #0060AD10;
                  }
                  .tab-button p {
                    line-height: 0;
                  }
                  button {
                    background: #005FAA;
                    color: #FFF;
                    width: 100%;
                    border: 0;
                    font-size: 28px;
                    line-height: 1.8em;
                  }
                </style>
                <div class="tab-button active" data-corresponding-tab-id="wegen">
                  <img src="<?php echo $root; ?>/img/gobs/Wegen@2x.png">
                  <p>wegen</p>
                </div>
                <div class="tab-button" data-corresponding-tab-id="bruggen">
                  <img src="<?php echo $root; ?>/img/gobs/Bruggen@2x.png">
                  <p>bruggen</p>
                </div>
                <div class="tab-button" data-corresponding-tab-id="sluizen">
                  <img src="<?php echo $root; ?>/img/gobs/Sluizen@2x.png">
                  <p>sluizen</p>
                </div>
              </div>
              <div class="tabs">
                <div data-tab-id="wegen">
                  <p>
  <?php foreach ($provinciale_wegen["features"] as $feature) { ?>
                    <label>
                      <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["N_WEG"]; ?>">
                      <?php echo $feature["properties"]["NAAM"]; ?> (<?php echo $feature["properties"]["N_WEG"]; ?>)
                    </label>
                    <br>
  <?php } ?>
                  </p>
                </div>
                <div data-tab-id="bruggen" style="display: none">
                  <p>
<?php foreach ($bruggen_en_sluizen["features"] as $feature) { ?>
                    <label>
                      <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["nummer"]; ?>">
                      <?php echo $feature["properties"]["naam"]; ?>
                    </label>
                    <br>
<?php } ?>
                  </p>
                </div>
                <div data-tab-id="sluizen" style="display: none">
                  <p>
<?php foreach ($bruggen_en_sluizen["features"] as $feature) { ?>
                    <label>
                      <input type="checkbox" name="objecten[]" value="<?php echo $feature["properties"]["nummer"]; ?>">
                      <?php echo $feature["properties"]["naam"]; ?>
                    </label>
                    <br>
<?php } ?>
                  </p>
                </div>
              </div>
              <p>
                <label for="telefoonnummer">Ik wil een SMS ontvangen op dit nummer:</label><br>
                <img style="width: 50px" src="<?php echo $root; ?>/img/gobs/Telefoon@2x.png">
                <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer">
              </p>
              <p><button>VERSTUUR</button></p>
            </fieldset>
          </form>
        </div>
      </div>
    </main>

    <?php echo $footerHtml; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
      $("[data-corresponding-tab-id]").click(function (e) {
        $("[data-corresponding-tab-id]").removeClass("active");
        $(e.currentTarget).addClass("active");
        var tabId = $(e.currentTarget).data("corresponding-tab-id");
        $("[data-tab-id]").hide();
        $("[data-tab-id="+tabId+"]").show();
      });
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
        var apiUrl = "http://apis.dataservicepunt.nl/aanmeldingen/";
        $.post(apiUrl, aanmelding, function (response) {
          console.log(response);
          alert("aanmelding geslaagd");
        }, "json");
      });
    </script>
  </body>
</html>
