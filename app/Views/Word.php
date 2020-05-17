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
        <div class='<?php echo $ClassWordSize ?> w3-text-blue upper'
             style="font-weight:bold; text-align: center;
                    vertical-align: middle; line-height: 80px;">
            <?php echo $WordObj->Word ?>
        </div>
       
        <!-- Mean (definition) -->
        <div class='Mean upper w3-left-align'
             style="<?php echo $CssMeanFontSize ?>; padding: 0.33em;">
                setup from JS...
        </div>
        <!-- Read Result Panel -->
        <div class="ReadResultPanel w3-xlarge w3-animate-zoom w3-card-4 w3-green"
             style="display: none; padding: 10px;">
             <i class="fa fa-check-circle"></i>
             Read Complete <i class="fa fa-plus"></i><?php echo strlen($WordObj->Mean) ?> EXP
            <!-- progress exp -->
            <div class="ProgressBar w3-border w3-border-pale-yellow w3-white" 
                 style="width: 100%;margin: 6px 0 2px 0 !important; font-weight: bold;">
                <div class="ProgressBarPercent w3-yellow w3-center w3-medium"
                     style="width:<?php echo $User->CurrentPercent ?>%;height: 20px;">
                    <?php echo (int)$User->CurrentPercent > 15 ? "$User->CurrentPercent%" : "" ?>
                </div>
            </div>
            <div class="ProgressBarText w3-medium" style="font-weight: bold;">
                <?php echo "$User->CurrentExp/$User->ThisLevelTotalExp"?>
            </div>
        </div>
        <!-- Next Word -->
        <div class="NextWordPanel w3-xlarge w3-animate-opacity w3-card-4
                w3-padding-small w3-blue"
             style="display:none; margin-top: 8px;">
             Next Word 
             <i class="fa fa-arrow-right"></i>
             <span class="w3-xxlarge upper"><?php echo $NextWord ?></span>
        </div>
        
        <!-- ajax update result -->
        <div class="Loading w3-large" style="padding: 4px; display:none;">
            <i class="w3-spin fa fa-spinner"></i>
        </div>

    </div> 
    <!-- /.Word container -->

    <div style="padding-top:1em"
         class="">
                            
    </div>

    <!-- fotter -->

<!-- / w3-container -->
</div>

<!-- Page script -->
<script>
    function Sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    function GetData(AjaxUrl) { 
        return $.ajax({
            url: AjaxUrl,
            type: 'GET',
            success : function(data) {
                // console.log(data);
                IsAjaxReadComplete = true;
            }
        });
    };
    
    var IsShowNextPanel = false;
    var IsAjaxReadComplete = false;
    async function ProgramRun(){ 
        IsShowNextPanel = false;
        IsAjaxReadComplete = false;
        // Animation Word Mean
            // setup
        <?php $WordMeanForJS = str_replace("\"","\\\"",$WordObj->Mean);?>
        var WordMean ="<?php echo $WordMeanForJS ?>";
        var WordMeanHtml = "";
        var Index = 0;
        for(Index = 0; Index < WordMean.length; Index++){
            WordMeanHtml += "<span class='select" + Index + "'>" 
                           + WordMean[Index] + "</span>";
        }
        $(".Mean").html(WordMeanHtml);
            // run
        var Index = 0;
        var TimeBeat = 50;
        for(Index = 0; Index < WordMean.length; Index++){
            await Sleep(TimeBeat);
            $(".select"+Index).addClass("w3-light-blue");
        }
        
        //[run first] ajax run no affect by Sleep()
        GetData("<?php echo "/public/Word/AjaxReadComplete/$User->Id/$WordObj->Id"?>");

        // show complete panel
        await Sleep(100);
        $(".ReadResultPanel").show();
        await Sleep(600);  // for panel above show
            // progres bar, will rewrite with ES6
        ThisLevelTotalExp = <?php echo $User->ThisLevelTotalExp ?>;
        var PercentPartFive = 0;
        var TotalPercent = <?php echo $User->NewPercent ?> - <?php echo $User->CurrentPercent ?>;
        var TotalTimeSleepProgressBar = 200; // ms, balance here
        var SleepBeatTime = TotalTimeSleepProgressBar / TotalPercent;
        for(PercentPartFive = <?php echo $User->CurrentPercent ?>; 
            PercentPartFive <= <?php echo $User->NewPercent ?>;
            PercentPartFive+=0.2)
        {
            await Sleep(SleepBeatTime);
            var PercentUI = PercentPartFive > 100 ? 100 : PercentPartFive; // fix overflow >100%       
             $(".ProgressBarPercent").css("width", PercentUI + "%");
            if(PercentUI >=15)
                $(".ProgressBarPercent").text(parseFloat(PercentUI).toFixed(1) + "%");
            
            CurrentExpTemp = Math.round(PercentUI * ThisLevelTotalExp / 100);
            $(".ProgressBarText").text(CurrentExpTemp+"/"+ThisLevelTotalExp);
        }

        // next word
        $(".NextWordPanel").show();
        await Sleep(600);  // for panel above show        
        IsShowNextPanel =true;

        await Sleep(500); // wait some before show next word

        $(".Loading").show(); // for wait if Ajax still running

        // wait show banner complete and submit data done
        var IsWait = true;
        while(IsWait){
            IsWait = !IsShowNextPanel || !IsAjaxReadComplete;
            await Sleep(100);
        }

        // next
        location.href = "/public/Word/View/<?php echo rawurlencode($NextWord) ?>";

    }
    $(document).ready(function(){
        // 
        ProgramRun();
     });
</script>