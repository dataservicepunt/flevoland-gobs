<?php
  include("../private/config.php");
  include("../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "SMS-Dienst";
    include("../private/head.php");
  ?>
  <body>

    <header>
      <div class="wrapper">
        <?php echo $logoHtml; ?>
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; padding: 1rem; margin: auto;">
          <h1 class="spaced">Snel en persoonlijk geïnformeerd worden over stremmingen?</h1>
          <p class="spaced">De provincie Flevoland werkt voortdurend aan de kwaliteit van (vaar)wegen. Gecombineerd met eventuele ongelukken en incidenten kan het voorkomen dat de (vaar)wegen tijdelijk niet gebruikt kunnen worden. Voor gebruikers die veel een bepaalde route gebruiken hebben we een persoonlijke berichtendienst ontwikkeld.</p>
          <h2 class="spaced">Aanmelden</h2>
          <p class="spaced">Wilt u een SMS-bericht ontvangen over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis waar u regelmatig gebruik van maakt? Vul dan <a href="aanmelden">het online aanmeldformulier</a> in.</p>
          <h2 class="spaced">Kosten</h2>
          <p class="spaced">Er zijn geen kosten verbonden aan deze dienst.</p>
          <h2 class="spaced">Opslag van gegevens</h2>
          <p class="spaced">Deze dienst gebruikt uw telefoonnummer alleen voor het versturen van SMS-berichten over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis waar u regelmatig gebruik van maakt. Uw telefoonnummer wordt niet gedeeld of op andere wijze gebruikt.</p>
          <h2 class="spaced">Instellingen wijzigen of afmelden</h2>
          <p class="spaced">Bent u aangemeld en wilt u wijzigen welke SMS-berichten u ontvangt? Vul dan <a href="aanmelden">het online aanmeldformulier</a> opnieuw in voor uw telefoonnummer. Uw oude instellingen worden dan gewijzigd.</p>
          <p class="spaced">Wilt u geen SMS-berichten meer ontvangen? Vul dan <a href="afmelden">het online afmeldformulier</a> in.</p>
        </div>
      </div>
    </main>

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
