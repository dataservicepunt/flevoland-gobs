<?php
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Notificatie versturen";
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
              <legend>Notificatie versturen</legend>
              <p>Vul onderstaand formulier in om een notificatie te versturen in het kader van de beschikbaarheid van bruggen en sluizen.</p>
              <p>
                <label for="notificatie">Vul de notificatie in die u wilt versturen:</label><br>
                <textarea id="notificatie" name="notificatie" placeholder="Notificatie"></textarea>
              </p>
              <p>Selecteer de bruggen en sluizen waarop deze notificatie betrekking heeft:</p>
<?php
  include("../../private/tabs.php");
?>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $cdnRoot; ?>/img/gobs/Telefoon@2x.png">
                <input type="text" id="token" name="token" placeholder="Token">
              </p>
              <p><button>Notificatie versturen</button></p>
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
        var apiUrl = "http://apis.dataservicepunt.nl/notificaties/";
        $.post(apiUrl, notificatie, function (response) {
          console.log(response);
          if (response.rs.errors) {
            alert(response.rs.errors[0].description);
          } else {
            alert("notificatie verstuurd naar " + response.rs.recipients.totalCount + " telefoonnummer(s)");
          }
        }, "json");
      });
    </script>
  </body>
</html>
