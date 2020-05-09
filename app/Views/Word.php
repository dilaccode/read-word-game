<div class="w3-container w3-center ">
    <!-- word container -->
    <div class="word-container w3-border-top 
    w3-border-left w3-border-right w3-border-indigo">
        <!-- top bar  -->
        <div>
            <!-- progress -->
            <div class="w3-border-bottom w3-border-indigo">
                <div class="w3-container w3-indigo w3-center w3-small" 
                style="width:<?php echo $Percent?>%">
                    <?php echo $Percent?>%
                </div>
            </div>
             <!-- views -->
            <div class="w3-large w3-padding-small 
                        w3-right-align w3-text-indigo"> 
                <i class="fa fa-eye"></i> <?php echo $wordObj->count ?>
            </div>
        </div>
       
        <!-- word -->       
        <div class='<?php echo $classWordSize.' '.$classWordColor ?> upper'>
            <?php echo $wordObj->word ?>
        </div>
        <!-- learn success -->
        <div class="learn-success w3-xxlarge w3-text-green"
            style="display:none;">  <!-- hide first -->
            <i class="fa fa-check-circle w3-jumbo"></i>
            <br>
            LEARN SUCCESS
            <br>
            <span class="w3-text-blue">
                <i class="fa fa-plus"></i><?php echo $Exp; ?> EXP
            </span>
            <br>
            <a  href="/public"
                        class="w3-btn w3-blue w3-round-large"
                        style="margin: 1em;">
                NEXT
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <!-- mean (definition) -->
        <div class='mean w3-xlarge upper w3-left-align'>
            <div class="w3-medium w3-indigo" 
            style="margin-right: 0.5em; margin-top: 0.5em;
                    float: left; padding: 0.25em;">
                mean
            </div>
            <div style="padding: 0.33em;">
                <?php echo $wordObj->mean; ?>
            </div>
        </div>

        <!-- mean (definition) links -->
        <div class="mean-links w3-padding-small">
            <div class="w3-large w3-padding-small">
                <?php if ($IsChildPage): ?>
                    <!-- <i class="fa fa-arrow-left w3-text-blue"></i> -->
                    <span class="w3-text-indigo">NEXT</span>
                <?php else: ?>
                    <i class="fa fa-arrow-down w3-text-green"></i>
                    <span class="w3-text-green">CLICK, READ ALL GREEN BUTTON</span>
                    <i class="fa fa-arrow-down w3-text-green"></i>
                <?php endif; ?>
            </div>
            <div class="w3-xlarge upper">
                <?php if ($IsChildPage): ?>
                    <?php $link = "/public/home/word/$Parent"
                        ."?StrChildViewed=$StrChildViewedNew"; // GET
                    ?>
                    <a  href="<?php echo $link ?>"
                        class="w3-btn w3-blue w3-round-large"
                        style="margin-bottom: 0.3em;">
                            <?php echo $Parent ?>
                            <i class="fa fa-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <?php foreach ($wordObj->meanArrayStatus as $WordMean): ?>
                        <?php
                            $Parent = $wordObj->word;
                            $link = "#";
                            $ClassStatus = "btn-word-viewed"; // case no mean (definition)
                            if($WordMean->isExist) {
                                $ClassStatus = "w3-green";
                                $link =  "/public/home/word/$WordMean->word/$Parent"
                                ."?StrChildViewed=$StrChildViewedNew"
                                ."&Percent=$Percent"; // GET
                            }
                            if($WordMean->IsViewed) {
                                $ClassStatus = "btn-word-viewed";
                                $link = "#";
                            }
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

    </div> 
    <!-- /.word container -->

    <div style="padding-top:1em"
         class="w3-border-left w3-border-right w3-border-indigo ">
                            
    </div>

    <!-- fotter -->
    <div class="w3-border-left w3-border-right w3-border-top w3-border-indigo
                w3-left-align"
         style="padding-top: 0.5em; padding-left: 0.5em;">
        <a href="/public" class="w3-large w3-indigo w3-btn w3-round btn-word">
            <i class="fa fa-arrow-left"></i> HOME
        </a>
    </div>

<!-- / w3-container -->
</div>

<!-- Page script -->
<script>
     $(document).ready(function(){
        <?php if($IsLearnSucess): ?>
            $(".mean").hide();
            $(".mean-links").hide();
            $(".learn-success").fadeIn();
        <?Php endif; ?> 
     });
</script>