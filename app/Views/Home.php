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
    <div class="" style="margin-top: 40px;">
        <div class="w3-left-align" style="
             margin-left: -40px;
             display: inline-block;">
            <div class="TitleText w3-tag  w3-yellow">R</div>
            <div class="TitleText w3-tag  w3-yellow">E</div>
            <div class="TitleText w3-tag  w3-yellow">A</div>
            <div class="TitleText w3-tag  w3-yellow">D</div>
        </div>
        <div class="EndLine"></div>
        <div class="w3-left-align" style="
             margin-top: 10px;
             margin-left: 40px;
             display: inline-block;
             ">
            <div class="TitleText w3-tag  w3-yellow">W</div>
            <div class="TitleText w3-tag  w3-yellow">O</div>
            <div class="TitleText w3-tag  w3-yellow">R</div>
            <div class="TitleText w3-tag  w3-yellow">D</div>
        </div>
    </div>
    <!-- Play Button -->
    <div style="margin-top: 40px;">
        <img class="PlayButton" src="/assets/images/PlayButton.png"/>
    </div>

    <!-- fotter -->
    <div class="w3-left-align w3-text-indigo w3-large"
         style="padding-top: 0.5em; padding-left: 0.5em;">
        <?php echo "Level: $User->Level" ?>
    </div>

    <!-- / w3-container -->
</div>