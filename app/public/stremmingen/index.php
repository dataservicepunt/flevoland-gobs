<?php
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Stremmingen";
    include("../../private/head.php");
  ?>
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
          <form method="POST">
            <fieldset>
              <legend>Stremmingen</legend>
              <p>Geen in onderstaand overzicht de actuele status van stremmingen bruggen en sluizen aan.</p>
<?php
  include("../../private/tabs_stremmingen.php");
?>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $cdnRoot; ?>/img/gobs/Slot@2x.png">
                <input type="text" id="username" name="username" placeholder="Gebruikersnaam">
                <input type="password" id="password" name="password" placeholder="Wachtwoord">
              </p>
              <p><button>STREMMINGSSTATUS PUBLICEREN</button></p>
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
        var apiUrl = "<?php echo $config["apiRoot"]; ?>/notificaties/";
        $.post(apiUrl, notificatie, function (response) {
          console.log(response);
          if (response.rs.errors) {
            alert(response.rs.errors[0].description);
          } else {
            alert("notificatie verstuurd naar " + response.rs.recipients.totalCount + " telefoonnummer(s)");
          }
        }, "json")
         .fail(function (response) {
           console.log(response);
           alert(response.responseJSON.error);
        });
      });
    </script>
  </body>
</html>
