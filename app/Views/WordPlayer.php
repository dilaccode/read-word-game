<!-- some needed js for this page -->
<script type="text/javascript" src="/assets/js/WordPlayer.js"></script>
<script>
    var StartWordId = <?php echo $StartWordId; ?>;
</script>
<!-- end -->

<div class="w3-center">
    <!-- Word container -->
    <div class="Word-container">
        <!-- top bar  -->
        <div>     
            <!-- home button -->
            <a href="/" class="w3-large w3-indigo w3-btn  btn-Word w3-display-topleft"
            style="margin: 8px 0 0 8px;padding: 4px 8px !important;">
                <i class="fa fa-arrow-left"></i>
            </a>
            <!-- views -->
            <div class="View w3-large w3-padding-small w3-text-indigo w3-display-topright"
                 style="margin: 8px 8px 0 0;"> 
                <i class="fa fa-eye"></i><span class="ViewText">...</span>
            </div>
            <!-- Mean Label -->
            <!-- <div class="w3-medium w3-indigo" 
                style="position:fixed; top: 70px; padding: 0.25em;">
                MEAN
            </div> -->
        </div>
       
        <!-- Word -->       
        <div class='Word w3-jumbo w3-text-blue upper'
             style="font-weight:bold; text-align: center;
                    vertical-align: middle; line-height: 80px;">
            ...
        </div>
       
        <!-- Mean (definition) -->
        <div class='Mean upper w3-left-align'
             style="font-size: 35px; padding: 0.33em;">
             <!-- temp div, will remoe by JS -->
             <div class="w3-center">
                ...
             </div>
        </div>
        <!-- Read Complete Panel -->
        <div class="ReadCompletePanel w3-large w3-animate-zoom w3-card-4 w3-green"
             style="display: none;">
             <i class="fa fa-check-circle"></i>
             Read Complete <i class="fa fa-plus"></i><span class="AmountExp">XXX</span> EXP
            <!-- progress exp -->
            <div class="ProgressBar w3-border w3-border-pale-yellow w3-white" 
                 style="width: 100%;margin: 6px 0 2px 0 !important; font-weight: bold;">
                <div class="ProgressBarPercent w3-yellow w3-center w3-medium"
                     style="width:0%;height: 20px;">
                    X % or Empty
                </div>
            </div>
            <div class="ProgressBarText w3-medium" style="font-weight: bold;">
                XXX/YYYY
            </div>
        </div>
        <!-- Next Word -->
        <div class="NextWordPanel w3-large w3-animate-opacity w3-card-4 w3-indigo"
             style="display:none;">
            Next Word 
            <i class="fa fa-arrow-right"></i>
            <span class="NextWordText w3-xlarge upper">AAAA</span>
        </div>
        
        <!-- ajax loading-->
        <div class="LoadingWait w3-text-indigo" style="display:none;">
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


<?php echo $ViewLevelUp ?>