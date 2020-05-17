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
        <div class="ReadResultPanel w3-xlarge w3-animate-zoom w3-card-4
                w3-padding-small w3-green"
             style="display:none;">
             <i class="fa fa-check-circle"></i>
             Read Complete <i class="fa fa-plus"></i><?php echo strlen($WordObj->Mean) ?> EXP
             <!-- progress exp -->
              <!-- progress -->
            <div class="ProgressBar w3-border w3-border-pale-yellow w3-white" style="width: 100%; margin: 4px 0 4px 0 !important; ">
                <div class="ProgressBarPercent w3-container w3-yellow w3-center w3-medium" style="width:60%">
                    <div class="ProgressBarPercentText" style="">
                        60%
                    </div>
                </div>
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
        <!-- progress -->
    <!-- <div class="ProgressBar w3-border-top w3-border-bottom w3-border-indigo
            w3-display-bottomleft"
         style="width: calc(100% - 16px); margin: 0 8px 8px 8px !important; ">
        <div class="ProgressBarPercent w3-container w3-indigo w3-center w3-medium" 
        style="width:60%">
            <div class="ProgressBarPercentText" style="padding: 0.2em 0 0.2em 0;">
                60%
            </div>
        </div>
    </div> -->

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
        GetData('/public/Word/AjaxReadComplete/'+<?php echo $WordObj->Id ?>);

        // show complete panel
        await Sleep(100);
        $(".ReadResultPanel").show();
            // progres bar, will rewrite with ES6
            // $(".ProgressBarPercent").css("width",PercentTemp+"%");
            // $(".ProgressBarPercentText").text(PercentTemp+"%");

        // next word
        await Sleep(500);  // for panel above show
        $(".NextWordPanel").show();
        await Sleep(500);  // for panel above show        
        IsShowNextPanel =true;

        await Sleep(1000); // wait more

        $(".Loading").show(); // for wait if Ajax still running

        // wait show banner complete and submit data done
        var IsWait = true;
        while(IsWait){
            console.log(IsShowNextPanel+"-"+IsAjaxReadComplete);
            IsWait = !IsShowNextPanel || !IsAjaxReadComplete;
            await Sleep(100);
        }

        // next
        // location.href = "/public/Word/View/<?php echo rawurlencode($NextWord) ?>";

    }
    $(document).ready(function(){
        // 
        ProgramRun();
     });
</script>