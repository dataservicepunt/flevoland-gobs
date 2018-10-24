<?php
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Aanmelden";
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
        <div class="content" style="max-width: 40rem; background: white; margin: auto;">
          <form method="POST">
            <fieldset>
              <!--
                <legend>Aanmelden</legend>
              -->
              <p class="spaced">Vul onderstaand formulier in om u aan te melden voor notificaties over de beschikbaarheid van bruggen en sluizen.</p>
              <p class="spaced">Ik wil SMS ontvangen als er iets aan de hand is met</p>
<?php include("../../private/tabs.php"); ?>
              <p class="spaced">
                <label for="telefoonnummer">Ik wil een SMS ontvangen op dit nummer:</label><br>
              </p>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $cdnRoot; ?>/img/gobs/Telefoon@2x.png">
                <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer" value="06-">
              </p>
              <p><button>VERSTUUR</button></p>
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
        var apiUrl = "http://apis.dataservicepunt.nl/aanmeldingen/";
        $.post(apiUrl, aanmelding, function (response) {
          console.log(response);
          alert("aanmelding geslaagd");
        }, "json");
      });
    </script>
  </body>
</html>
