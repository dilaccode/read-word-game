<div class="w3-center">
    <!-- Word container -->
    <div class="Word-container">
        <!-- top bar  -->
        <div>     
            <!-- home button -->
            <a href="/public" class="w3-large w3-indigo w3-btn  btn-Word w3-display-topleft"
            style="margin: 8px 0 0 8px;padding: 4px 8px !important;">
                <i class="fa fa-arrow-left"></i>
            </a>
            <!-- views -->
            <div class="w3-large w3-padding-small w3-text-indigo w3-display-topright"
                 style="margin: 8px 8px 0 0;"> 
                <i class="fa fa-eye"></i><?php echo $WordObj->View ?>
            </div>
            <!-- Mean Label -->
            <div class="w3-medium w3-indigo" 
                style="position:fixed; top: 70px; padding: 0.25em;">
                MEAN
            </div>
        </div>
       
        <!-- Word -->       
        <div class='<?php echo $ClassWordSize.' '.$ClassWordColor ?> upper'
             style="font-weight:bold; text-align: center;
                    vertical-align: middle; line-height: 80px;">
            <?php echo $WordObj->Word ?>
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
        <!-- Mean (definition) -->
        <div class='Mean w3-xxlarge upper w3-left-align'>
            <div style="padding: 0.33em;">
                <?php echo $WordObj->Mean; ?>
            </div>
        </div>

        <!-- Mean (definition) links -->
        <div class="Mean-links w3-padding-small">
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
                    <?php $Link = "/public/Word/View/$Parent"
                        ."?$UrlGETDataListWordsViewed" // GET
                        ."&PercentCurrent=$PercentCurrent" // GET
                        // for anti random again
                        ."&$UrlGETDataListWordMeansInit"; 
                    ?>
                    <a  href="<?php echo $Link ?>"
                        class="w3-btn w3-blue w3-round-large"
                        style="margin-bottom: 0.3em;">
                            <?php echo $Parent ?>
                            <i class="fa fa-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <?php $ShowIndex = 1; ?>
                    <?php foreach ($WordObj->ArrayWordMeansStatus as $WordMeanStatus): ?>
                        <?php 
                            $Parent = $WordObj->Word;
                            $Link = "#";
                            $ClassStatus = "btn-Word-viewed"; // case no Mean (definition)
                            $ClassShowAnimation = "";
                            if(!$WordMeanStatus->IsViewed) {
                                $ClassStatus = "w3-green";
                                $ClassShowAnimation = "showBtn$ShowIndex";
                                $ShowIndex++;
                                $Link =  "/public/Word/View/$WordMeanStatus->Word/$Parent"
                                ."?$UrlGETDataListWordsViewed"
                                // update new Percent for pass to child page
                                ."&PercentCurrent=$PercentNew"
                                // for anti random again
                                ."&$UrlGETDataListWordMeansInit";                         
                        ?>
                                <a  href="<?php echo $Link ?>"
                                class="<?php echo $ClassShowAnimation ?> w3-btn btn-Word <?php echo $ClassStatus ?>
                                w3-round"
                                style="margin-bottom: 0.2em; ">
                                    <?php echo $WordMeanStatus->Word ?>
                                </a>
                        <?php
                            }else{
                        ?>
                                <div class="" 
                                     style="display: inline-block;  padding: 8px 4px; margin-bottom: 0.2em;">
                                    <?php echo $WordMeanStatus->Word ?><i class='fa fa-check w3-text-green'></i>
                                </div>
                        <?php
                            }
                        ?>    
                        
                    <?php endforeach; ?>    
                <?php endif; ?>
            </div>
        </div>

       

    </div> 
    <!-- /.Word container -->

    <div style="padding-top:1em"
         class="">
                            
    </div>

    <!-- fotter -->
        <!-- progress -->
    <div class="ProgressBar w3-border-top w3-border-bottom w3-border-indigo
            w3-display-bottomleft"
         style="width: calc(100% - 16px); margin: 0 8px 8px 8px !important; ">
        <div class="ProgressBarPercent w3-container w3-indigo w3-center w3-medium" 
        style="width:<?php echo $PercentCurrent?>%">
            <div class="ProgressBarPercentText" style="padding: 0.2em 0 0.2em 0;">
                <?php echo $PercentCurrent?>%
            </div>
        </div>
    </div>

<!-- / w3-container -->
</div>

<!-- Page script -->
<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    async function AnimationWordMean(){
        var index=1;
        var TimeBeat = 50;
        for(index=1;index <= <?php echo $TotalMeanLetters ?>;index++){
            await sleep(TimeBeat);
            $(".select"+index).addClass("w3-light-blue");
        }
    }
    $(document).ready(function(){
        // select word mean animation
        AnimationWordMean();
        // var index=1;
        // for(index=1;index <= <?php echo $TotalMeanLetters ?>;index++){
        //     await sleep(2000);
        //     $(".select"+index).fadeOut();
        // }
        /// progres bar
        TimeBeat = 10; // miliseconds
        <?php if(!$IsChildPage): ?>
            // animation percent progress bar
            PercentTemp = <?php echo $PercentCurrent ?>;
            setInterval(function(){
                if(PercentTemp <= <?php echo $PercentNew ?>){
                    $(".ProgressBarPercent").css("width",PercentTemp+"%");
                    $(".ProgressBarPercentText").text(PercentTemp+"%");
                    PercentTemp+=1;
                }
            }, TimeBeat);
            // show success View after run progress bar 100%
            <?php if($IsLearnSucess): ?>
                Timeout = <?php echo $PercentNew - $PercentCurrent ?> * TimeBeat;
                DelayShowSuccessView = 200; // miliseconds
                setTimeout(function(){ 
                    $(".Mean").hide();
                    $(".Mean-links").hide();
                    $(".learn-success").fadeIn();
                }, Timeout + DelayShowSuccessView);
                console.log(Timeout);
            <?Php endif; ?>
        <?Php endif; ?>
     });
</script>