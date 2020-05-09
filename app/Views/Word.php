<div class="w3-container w3-center ">
    <!-- word container -->
    <div class="word-container w3-border-top 
    w3-border-left w3-border-right w3-border-blue">
        <!-- views -->
        <div class="w3-large w3-padding-small w3-right-align"> 
            <i class="fa fa-eye"></i> <?php echo $wordObj->count ?>
        </div>
        <!-- word -->       
        <div class='<?php echo $classWordSize.' '.$classWordColor ?> upper'>
            <?php echo $wordObj->word ?>
        </div>
        <!-- mean (definition) -->
        <div class='mean w3-xlarge upper'>
            <?php echo $wordObj->mean; ?>
        </div>
    </div> 
    <!-- /.word container -->
    <!-- <div style="margin-top:1em;"></div> -->
    <!-- recommend words -->
    <div class="w3-padding-small w3-border-green  w3-border-left 
    w3-border-right w3-border-bottom">
        <div class="w3-large w3-padding-small">
            <?php if ($IsChildPage): ?>
                <i class="fa fa-arrow-left w3-text-blue"></i>
                Back
            <?php else: ?>
                <i class="fa fa-arrow-down w3-text-green"></i>
                Read More
                <i class="fa fa-arrow-down w3-text-green"></i>
            <?php endif; ?>
        </div>
        <div class="w3-xlarge upper">
            <?php if ($IsChildPage): ?>
                <a  href="/public/home/word/<?php echo $Parent ?>"
                    class="w3-btn w3-blue w3-round-large"
                    style="margin-bottom: 0.3em;">
                        <?php echo $Parent ?>
                </a>
            <?php else: ?>
                <?php foreach ($wordObj->meanArrayStatus as $WordMean): ?>
                    <?php
                        $ClassStatus = $WordMean->isExist ? "w3-green" : "w3-gray";
                        $Parent = $wordObj->word;
                        $link = $WordMean->isExist ? 
                        "/public/home/word/$WordMean->word/$Parent" : "#";
                    ?>
                    <a  href="<?php echo $link ?>"
                    class="w3-btn btn-word <?php echo $ClassStatus ?>
                     w3-round"
                    style="margin-bottom: 0.2em;">
                        <?php echo $WordMean->word ?>
                    </a>
                <?php endforeach; ?>    
            <?php endif; ?>
        </div>
    </div>
    <!-- level -->
    <div class="w3-border-left w3-border-right w3-border-green w3-large w3-left-align w3-padding-small">
        Your level: <?php echo $Stats->level ?>.<br>
        Highest word saw: <?php echo $Stats->highest ?>.
    </div>
    <!-- home -->
    <div class="w3-border-left w3-border-right w3-border-green">
        <a href="/public" class="w3-large w3-text-green">HOME</a>
    </div>
    <div style="margin-top:1em;"></div>
<!-- / w3-container -->
</div>