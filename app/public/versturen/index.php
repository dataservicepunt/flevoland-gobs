<?php
  $includeStats = true;
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Notificatie versturen";
    include("../../private/head.php");
  ?>
  <body>

    <div class="overlay" style="display: none; width: 100%; height: 100%; position: fixed; background-color: black; opacity: 0.9"></div>

    <header>
      <div class="wrapper">
        <?php echo $logoHtml; ?>
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
                <div>Aantal karakters: <span class="count">0</span></div>
                <script>
                    $("textarea").keyup(function () {
                         $(".count").html(this.value.length);
                         //console.log(Math.ceil(this.value.length / 160));
                    });
                </script>
                <span style="font-size: 10px">bulkopties:
                  <a href="#" onclick="event.preventDefault(); $('input[type=checkbox]').prop('checked', true)">alle objecten selecteren</a>,
                  <a href="#" onclick="event.preventDefault(); $('input[type=checkbox]').prop('checked', false)">objectselectie wissen</a>
                </span>
              </p>
              <p>Selecteer de bruggen en sluizen waarop deze notificatie betrekking heeft:</p>
<?php
  include("../../private/tabs_checkboxes.php");
?>
              <p style="background: #eee; text-align: center;">
                <img style="vertical-align: top; width: 50px; margin: 0; margin-top: 0.4em" src="<?php echo $config["appRoot"]; ?>/assets/Slot@2x.png">
                <input type="text" id="username" name="username" placeholder="Gebruikersnaam">
                <input type="password" id="password" name="password" placeholder="Wachtwoord">
              </p>
              <p><button>NOTIFICATIES VERSTUREN</button></p>
            </fieldset>
          </form>
        </div>
      </div>
    </main>

    <script>
      $("form").submit(function (e) {
        e.preventDefault();
        $(".overlay").show();
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
          //console.log(response);
          if (response.rs.errors) {
            alert(response.rs.errors[0].description);
          } else {
            alert("notificatie verstuurd naar " + response.rs.recipients.totalCount + " telefoonnummer(s)");
          }
          $(".overlay").hide();
        }, "json")
        .fail(function (response) {
          //console.log(response);
          alert(response.responseJSON.error);
          $(".overlay").hide();
        });
      });
    </script>
  </body>
</html>
