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

    <header>
      <div class="wrapper">
        <?php echo $logoHtml; ?>
      </div>
    </header>

    <main>
      <div class="wrapper" style="padding-top: 8rem">
        <div class="content" style="max-width: 40rem; background: white; margin: auto;">
          <p>Bron: <a href="https://sms.flevowegen.nl/api/notificaties/">https://sms.flevowegen.nl/api/notificaties/</a></p>

<?php
  include("../../private/notificaties.php");
?>

        </div>
      </div>
    </main>

  </body>
</html>
