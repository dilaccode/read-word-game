<div class="w3-container w3-center ">
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
            <?php foreach ($LowSeeWords as $Word): ?>
                <a href="/public/home/Word/<?php echo $Word->Word ?>"
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