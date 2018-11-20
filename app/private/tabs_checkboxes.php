<div style="display:flex">
  <div class="tab-button active" data-corresponding-tab-id="wegen">
    <img src="<?php echo $cdnRoot; ?>/img/gobs/Wegen@2x.png">
    <p>wegen</p>
  </div>
  <div class="tab-button" data-corresponding-tab-id="bruggen">
    <img src="<?php echo $cdnRoot; ?>/img/gobs/Bruggen@2x.png">
    <p>bruggen</p>
  </div>
  <div class="tab-button" data-corresponding-tab-id="sluizen">
    <img src="<?php echo $cdnRoot; ?>/img/gobs/Sluizen@2x.png">
    <p>sluizen</p>
  </div>
</div>
<div class="tabs">
  <div data-tab-id="wegen">
    <p class="spaced">
<?php include("../../private/provinciale_wegen_checkboxes.php"); ?>
    </p>
  </div>
  <div data-tab-id="bruggen" style="display: none">
    <p class="spaced">
      <p class="spaced">
<?php include("../../private/bruggen_checkboxes.php"); ?>
    </p>
  </div>
  <div data-tab-id="sluizen" style="display: none">
    <p class="spaced">
<?php include("../../private/sluizen_checkboxes.php"); ?>
    </p>
  </div>
</div>
<script>
  $("[data-corresponding-tab-id]").click(function (e) {
    $("[data-corresponding-tab-id]").removeClass("active");
    $(e.currentTarget).addClass("active");
    var tabId = $(e.currentTarget).data("corresponding-tab-id");
    $("[data-tab-id]").hide();
    $("[data-tab-id="+tabId+"]").show();
  });
</script>
