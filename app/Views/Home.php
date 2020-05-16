<!-- development mode alert -->
    <?php if(IS_DEVELOPMENT_MODE):?>
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

<div class=" w3-center ">
    <div class='w3-xxlarge w3-indigo upper'>
        Learn Word
    </div>
    <!-- recommend words -->
    <div class="w3-border w3-border-indigo w3-padding-small w3-left-align">
        <div class="w3-xlarge ">
            Start with some words:<br>
            <span class="w3-large w3-center">
                <i class="fa fa-arrow-down w3-text-blue"></i>
                Click on words below
                <i class="fa fa-arrow-down w3-text-blue"></i>
            </span>
        </div>
        <div class="w3-xxlarge upper w3-text-blue"
             style ="margin-left: 0.15em;">
            <?php foreach ($ListWords as $Word): ?>
                <a href="/public/Word/View/<?php echo $Word->Word ?>"
                    class="w3-btn w3-blue btn-Word w3-round"
                    style="margin-bottom: 0.2em;">
                    <?php echo $Word->Word ?>
                </a>
                <br>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- fotter -->
    <div class="w3-border-left w3-border-right w3-border-indigo
                w3-left-align w3-text-indigo w3-large"
         style="padding-top: 0.5em; padding-left: 0.5em;">
       Your have <?php echo number_format($TotalExp) ?> EXP
    </div>

<!-- / w3-container -->
</div>