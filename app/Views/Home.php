<!-- development mode alert -->
<?php if (IS_DEVELOPMENT_MODE): ?>
    <div class='w3-xlarge w3-orange w3-center w3-padding-8'
         style="margin-bottom: 1em; padding-top: 1em;">
        <i class="fa fa-warning"></i>
        DEVELOPMENT MODE
        <div class="w3-large w3-text-red">
            <i class="fa fa-arrow-right"></i>
            SLOW YOUR SITE
        </div>
        <div class="w3-large w3-text-black"
             style="padding: 1em;">
            <i class="fa fa-arrow-right"></i>
            Turn off in /App/Config/Constants.php
            <br>
            IS_DEVELOPMENT_MODE = FALSE
        </div>
    </div>
<?php endif; ?>
<!-- end development mode alert -->

<!--HOME-->
<div class=" w3-center ">
    <!--title-->
    <div class='w3-xxlarge w3-blue upper'>
        Read Word
    </div>
    <!-- recommend words -->
    <div class="w3-padding-32">
        <button class="PlayButton w3-btn w3-green w3-round-large w3-xlarge">
            <i class="fa fa-play"></i>
            PLAY
        </button>
    </div>

    <!-- fotter -->
    <div class="w3-left-align w3-text-indigo w3-large"
         style="padding-top: 0.5em; padding-left: 0.5em;">
        <?php echo "Level: $User->Level" ?>
    </div>

    <!-- / w3-container -->
</div>