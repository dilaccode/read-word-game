<div class="w3-container w3-center ">
    <!-- Word container -->
    <div class="Word-container w3-border-top 
    w3-border-left w3-border-right w3-border-indigo">
        <!-- top bar  -->
        <div>           
            <!-- views -->
            <div class="w3-large w3-padding-small 
                        w3-right-align w3-text-indigo"> 
                <i class="fa fa-eye"></i> <?php echo $WordObj->View ?>
            </div>
        </div>
       
        <!-- Word -->       
        <div class='<?php echo $ClassWordSize.' '.$ClassWordColor ?> upper'>
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
        <div class='Mean w3-xlarge upper w3-left-align'>
            <div class="w3-medium w3-indigo" 
            style="margin-right: 0.5em; margin-top: 0.5em;
                    float: left; padding: 0.25em;">
                Mean
            </div>
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
                                style="margin-bottom: 0.2em; visibility:hidden;">
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

        <!-- progress -->
        <div class="ProgressBar w3-border-top w3-border-bottom w3-border-indigo">
            <div class="ProgressBarPercent w3-container w3-indigo w3-center w3-medium" 
            style="width:<?php echo $PercentCurrent?>%">
                <div class="ProgressBarPercentText" style="padding: 0.2em 0 0.2em 0;">
                    <?php echo $PercentCurrent?>%
                </div>
            </div>
        </div>

    </div> 
    <!-- /.Word container -->

    <div style="padding-top:1em"
         class="w3-border-left w3-border-right w3-border-indigo ">
                            
    </div>

    <!-- fotter -->
    <div class="w3-border-left w3-border-right w3-border-indigo
                w3-left-align"
         style="padding-top: 0.5em; padding-left: 0.5em;">
        <a href="/public" class="w3-large w3-indigo w3-btn w3-round btn-Word">
            <i class="fa fa-arrow-left"></i> HOME
        </a>
    </div>

<!-- / w3-container -->
</div>

<!-- Page script -->
<script>
     $(document).ready(function(){
        /// animation show mark and show word means
        // $(".showBtn1").css("visibility","hidden");
        setTimeout(function(){ 
            $(".show1").addClass("w3-border w3-border-green w3-round");
        }, 500);
        setTimeout(function(){ 
            $(".showBtn1").css("visibility","visible");
        }, 700);

        // $(".showBtn2").css("visibility","hidden");
        setTimeout(function(){ 
            $(".show2").addClass("w3-border w3-border-green w3-round");
        }, 1500);
        setTimeout(function(){ 
            $(".showBtn2").css("visibility","visible");
        }, 1700);

        // $(".showBtn3").css("visibility","hidden");
        setTimeout(function(){ 
            $(".show3").addClass("w3-border w3-border-green w3-round");
        }, 2000);
        setTimeout(function(){ 
            $(".showBtn3").css("visibility","visible");
        }, 2200);

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