<?php
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Afmelden";
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
              <p class="spaced">U wilt geen SMS-berichten meer ontvangen over geplande werkzaamheden, actuele stremmingen en overlast op een weg, brug of sluis. Vul onderstaand formulier in.</p>
              <p class="spaced">
                <label for="telefoonnummer">Ik wil geen SMS meer ontvangen op dit nummer:</label><br>
              </p>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $cdnRoot; ?>/img/gobs/Telefoon@2x.png">
                <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer" value="06 - ">
              </p>
              <p><button>AFMELDEN</button></p>
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
            afmelding = {};
        $(formData).each(function (i, field) {
          if (field.name.substr(field.name.length - 2) === "[]") {
            field.name = field.name.substr(0, field.name.length - 2);
            if (!afmelding[field.name]) {
              afmelding[field.name] = [];
            }
            afmelding[field.name].push(field.value);
          } else {
            afmelding[field.name] = field.value;
          }
        });
        var apiUrl = "<?php echo $config["apiRoot"]; ?>/aanmeldingen/";
        $.post(apiUrl, afmelding, function (response) {
          console.log(response);
          alert("afmelding geslaagd");
        }, "json")
         .fail(function (response) {
          console.log(response);
          alert(response.responseJSON.error);
        });
      });
    </script>
  </body>
</html>
