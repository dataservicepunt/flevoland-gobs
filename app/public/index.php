<?php
  $apps = json_decode(file_get_contents("http://www.dataservicepunt.nl/flevoland/apps/?temp"), true);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.dataservicepunt.nl/flevoland/css/style.css">
    <title>App store</title>
  </head>
  <body>
    <nav>
      <div class="wrapper">
        <a href="https://www.dataservicepunt.nl/flevoland/">Data Servicepunt Flevoland</a> |
        <a href="https://www.dataservicepunt.nl/flevoland/data/index.json">Dataportaal</a> |
        <a href="http://apps.dataservicepunt.nl/">App store</a> |
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
          <h1>App store</h1>
<?php foreach ($apps["apps"] as $app) { ?>
          <div class="app" style="border: 1px solid black; margin: 10px 0; padding: 10px">
            <h2 style="max-width: 20em"><?php echo $app["naam"]; ?></h2>
            <p>contact: <?php echo $app["contact"]; ?></p>
            <p><a href="<?php echo $app["uri"]; ?>"><?php echo $app["uri"]; ?></a></p>
          </div>
<?php } ?>
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
