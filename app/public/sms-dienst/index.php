<?php
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "SMS-Dienst";
    include("../../private/head.php");
  ?>
  <body>

    <?php echo $navHtml; ?>

    <header>
      <div class="wrapper">
        <img src="<?php echo $cdnRoot; ?>/img/Logo.png" alt="Provincie Flevoland">
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; padding: 1rem; margin: auto;">
          <h1>SMS-dienst van de provincie Flevoland</h1>
          <p>SMS-berichten ontvangen over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis waar u regelmatig gebruik van maakt.</p>
          <h2>Aanmelden</h2>
          <p>Om aan te melden voor de SMS-dienst van de provincie Flevoland vult u <a href="../aanmelden">het online aanmeldformulier</a> in.</p>
          <h2>Kosten</h2>
          <p>Er zijn geen kosten verbonden aan de SMS-dienst van de provincie Flevoland.</p>
          <h2>Opslag van gegevens</h2>
          <p>De SMS-dienst van de provincie Flevoland gebruikt uw telefoonnummer alleen voor het versturen van SMS-berichten over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis waar u regelmatig gebruik van maakt.</p>
          <h2>Afmelden</h2>
          <p>Om af te melden van de SMS-dienst van de provincie Flevoland vult u <a href="../afmelden">het online afmeldformulier</a> in.</p>
        </div>
      </div>
    </main>

    <?php echo $footerHtml; ?>

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
        if (aanmelding["toestemming"] !== "on") {
          alert("Vink eerst het vinkje 'Ik meld me aan voor de SMS-dienst van de provincie Flevoland' aan.");
        } else {
          var apiUrl = "<?php echo $config["apiRoot"]; ?>/aanmeldingen/";
          $.post(apiUrl, aanmelding, function (response) {
            console.log(response);
            alert("aanmelding geslaagd");
          }, "json")
           .fail(function (response) {
            console.log(response);
            alert(response.responseJSON.error);
          });
        }
      });
    </script>
  </body>
</html>
