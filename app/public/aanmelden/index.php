<?php
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Aanmelden SMS-Dienst";
    include("../../private/head.php");
  ?>
  <body>

    <?php echo $navHtml; ?>

    <header>
      <div class="wrapper">
        <?php echo $logoHtml; ?>
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; margin: auto;">
          <form method="POST">
            <fieldset>
              <!--
                <legend>Aanmelden</legend>
              -->
              <h1 class="spaced">Snel en persoonlijk geïnformeerd worden over stremmingen?</h1>
              <p class="spaced">De provincie Flevoland werkt voortdurend aan de kwaliteit van (vaar)wegen. Gecombineerd met eventuele ongelukken en incidenten kan het voorkomen dat de (vaar)wegen tijdelijk niet gebruikt kunnen worden. Voor gebruikers die veel een bepaalde route gebruiken hebben we een persoonlijke berichtendienst ontwikkeld.</p>
              <p class="spaced">Wilt u een SMS-bericht ontvangen over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis waar u regelmatig gebruik van maakt? Vul dan onderstaand formulier in.</p>
              <p class="spaced">Ik wil graag persoonlijk geïnformeerd worden en een SMS ontvangen als er iets aan de hand is met:</p>
<?php include("../../private/tabs_checkboxes.php"); ?>
              <p class="spaced">
                <label for="telefoonnummer">Ik wil een SMS ontvangen op dit nummer:</label><br>
              </p>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $cdnRoot; ?>/img/gobs/Telefoon@2x.png">
                <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer" value="06 - ">
              </p>
              <p class="spaced">
                <label>
                  <input type="checkbox" name="toestemming"> Ik meld me aan voor de <a href="/">SMS-dienst van de provincie Flevoland</a>
                </label>
              </p>
              <p><button>AANMELDEN</button></p>
            </fieldset>
          </form>
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
