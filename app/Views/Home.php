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
                <a href="/public/home/word/<?php echo $Word->word ?>"
                    class="w3-btn w3-blue btn-word w3-round"
                    style="margin-bottom: 0.2em;">
                    <?php echo $Word->word ?>
                </a>
                <br>
            <?php endforeach; ?>
        </div>
    </div>
<!-- / w3-container -->
</div>