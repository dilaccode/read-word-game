<!-- development mode alert -->
<?php if (IS_DEVELOPMENT_MODE): ?>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
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
