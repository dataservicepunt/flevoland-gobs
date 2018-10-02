<?php
  $dataUri = "http://www.dataservicepunt.nl/flevoland/data/?temp";
  $data = json_decode(file_get_contents($dataUri), true);
  $navHtml = file_get_contents("https://www.dataservicepunt.nl/flevoland/partial_nav.html");
  $footerHtml = file_get_contents("https://www.dataservicepunt.nl/flevoland/partial_footer.html");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://www.dataservicepunt.nl/flevoland/css/style.css">
    <title>Data marts en data services (API's)</title>
  </head>
  <body>

    <?php echo $navHtml; ?>

    <header>
      <div class="wrapper">
        <img src="https://www.dataservicepunt.nl/flevoland/img/Logo.png" alt="Provincie Flevoland">
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; padding: 1rem; margin: auto;">
          <h1>Data marts</h1>
<?php foreach ($data["datamarts"] as $datamart) { ?>
          <div class="datamart">
            <h2 style="max-width: 20em"><a href="<?php echo $datamart["uri"]; ?>"><?php echo $datamart["naam"]; ?></a></h2>
            <p>contact: <?php echo $datamart["contact"]; ?></p>
          </div>
<?php } ?>
          <h1>Data services (API's)</h1>
<?php foreach ($data["dataservices"] as $dataservices) { ?>
          <div class="dataservice">
            <h2 style="max-width: 20em"><a href="<?php echo $dataservices["uri"]; ?>"><?php echo $dataservices["naam"]; ?></a></h2>
            <p>documentatie: <a href="<?php echo $dataservices["documentatie"]; ?>">swagger</a></p>
            <p>contact: <?php echo $dataservices["contact"]; ?></p>
          </div>
<?php } ?>
          <h1>Meta data</h1>
          <a href="<?php echo $dataUri; ?>">Data marts en data services (API's) meta data in json formaat</a>
        </div>
      </div>
    </main>

    <?php echo $footerHtml; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
