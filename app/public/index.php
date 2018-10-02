<?php
  $appsUri = "http://www.dataservicepunt.nl/flevoland/apps/?temp";
  $apps = json_decode(file_get_contents($appsUri), true);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://www.dataservicepunt.nl/flevoland/css/style.css">
    <title>Apps</title>
  </head>
  <body>
    <nav>
      <div class="wrapper">
        <a href="https://www.dataservicepunt.nl/flevoland/">Data&nbsp;Servicepunt&nbsp;Flevoland</a> |
        <a href="http://apis.dataservicepunt.nl/">Data&nbsp;marts</a> |
        <a href="http://apis.dataservicepunt.nl/">Data&nbsp;services&nbsp;(API's)</a> |
        <a href="http://apps.dataservicepunt.nl/">Apps</a> |
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
          <h1>Apps</h1>
<?php foreach ($apps["apps"] as $app) { ?>
          <div class="app">
            <h2 style="max-width: 20em"><a href="<?php echo $app["uri"]; ?>"><?php echo $app["naam"]; ?></a></h2>
            <p>contact: <?php echo $app["contact"]; ?></p>
          </div>
<?php } ?>
        <h1>Meta data</h1>
        <a href="<?php echo $appsUri; ?>">Apps meta data in json formaat</a>
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
  </body>
</html>
