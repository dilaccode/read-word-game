<?php 
  /// How to Config
  array(
    'Title' => "YourTitle",
    'Message'=>"YourMessage",
    'NextActionText'=>"NextActionText",
    'NextActionLink'=>"Http",
  );
?>
<div  class="w3-modal w3-center" style="display: block;">
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <header class="w3-container w3-indigo"> 
      <!-- <a href="#"
      class="w3-button w3-large w3-red w3-display-topright">×</a> -->
      <h2><?php echo $Title ?></h2>
    </header>
    <div class="w3-container w3-padding-16 w3-xlarge">
      <?php echo $Message ?>
    </div>
    <footer class="w3-container w3-indigo w3-display-container w3-center w3-padding">
        <a href="<?php echo $NextActionLink ?>"
        class="w3-button w3-blue w3-round w3-xlarge">
          <?php echo $NextActionText ?>
        </a>
    </footer>
  </div>
</div>