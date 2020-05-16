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
                <?php echo $WordObj->Mean; ?>
        </div>
        <!-- Read Result Panel -->
        <div class="ReadResultPanel w3-xlarge w3-animate-zoom w3-card-4
                w3-padding-small w3-green"
             style="display:none;">
             <i class="fa fa-check-circle"></i>
             Read Complete <i class="fa fa-plus"></i>30 EXP
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
        <!-- progress -->
    <div class="ProgressBar w3-border-top w3-border-bottom w3-border-indigo
            w3-display-bottomleft"
         style="width: calc(100% - 16px); margin: 0 8px 8px 8px !important; ">
        <div class="ProgressBarPercent w3-container w3-indigo w3-center w3-medium" 
        style="width:60%">
            <div class="ProgressBarPercentText" style="padding: 0.2em 0 0.2em 0;">
                60%
            </div>
        </div>
    </div>

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
                console.log(data);
            }
        });
    };
    async function AnimationWordMean(){
        var index=1;
        var TimeBeat = 50;
        for(index=1;index <= <?php echo $TotalMeanLetters ?>;index++){
            await Sleep(TimeBeat);
            $(".select"+index).addClass("w3-light-blue");
        }
        // show complete panel
        await Sleep(100);
        $(".ReadResultPanel").show();
        
        // ajax run no affect by Sleep()
        GetData('/public/Word/AJAXReadComplete');

        // next word
        await Sleep(500);  // for panel above show
        $(".NextWordPanel").show();

        await Sleep(500);  // for panel above show
        $(".Loading").show(); // for wait if Ajax still running

        await Sleep(500);
        location.href = "/public/Word/View/<?php echo rawurlencode($NextWord) ?>";

    }
    $(document).ready(function(){
        // select word mean animation
        AnimationWordMean();

        /// progres bar, will rewrite with ES6
        // $(".ProgressBarPercent").css("width",PercentTemp+"%");
        // $(".ProgressBarPercentText").text(PercentTemp+"%");
       
     });
</script>