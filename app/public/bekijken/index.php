<?php
  include("../../private/config.php");
  include("../../private/load.php");
?>
<!doctype html>
<html lang="en">
  <?php
    $title = "Bekijken verzonden berichten SMS-Dienst";
    include("../../private/head.php");
  ?>
  <body>

    <header>
      <div class="wrapper">
        <?php echo $logoHtml; ?>
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; margin: auto; padding: 10px;">
          <p>Bron: <a href="https://sms.flevowegen.nl/api/notificaties/">https://sms.flevowegen.nl/api/notificaties/</a></p>

<?php
  include("../../private/notificaties.php");
?>

        </div>
      </div>
    </main>

  </body>
</html>
