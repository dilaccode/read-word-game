<?php
/**
 * USE Javascript
 *  
 * ShowLevelUp(Level);
 *  
 */
?>

<!-- LEVEL UP -->
<style>
    .LevelUpText{
        font-size: 40px;
    }
</style>
<script>
    var IsLevelUpPopupShow = false;
    function ShowLevelUp(Level){
        IsLevelUpPopupShow = true;
        // remove level part (for 2nd)
        var ArrayLevelPart = $('div[class*="LevelPart"]');
        var Index = 0;
        for(Index = 1; Index < ArrayLevelPart.length; Index ++){
            ArrayLevelPart[Index].remove();
        }
        // set level
        LevelStr = Level+"";
        var Index = 0;
        $(".LevelPart0").text(LevelStr[0]);
        var DivLevelPart = $(".LevelPart0");
        for(Index = 1; Index < LevelStr.length; Index++){
            DivLevelPart.after("<div class=\"LevelPart" 
                                + Index + " w3-tag w3-xxxlarge w3-green\">X</div>");
            $(".LevelPart" + Index).text(LevelStr[Index]);
            DivLevelPart = $(".LevelPart" + Index);
        }
        // show
        $(".LevelUp").fadeIn();
    }

    $(document).ready(function(){
        // close button
        $(".LevelUpCloseButton").click(function(){
            $(".LevelUp").fadeOut();
            IsLevelUpPopupShow = false;
        });

    });
</script>
<div class="LevelUp w3-display-middle w3-border w3-border-yellow w3-center" 
     style="width: 100%; height: 100%; background: white; 
            border-width: 8px !important;
            display: none;">
    <div class="LevelUpContent "
         style="width: 100%; margin-top: 33%;">
        <div class="LevelUpText w3-tag  w3-yellow">L</div>
        <div class="LevelUpText w3-tag  w3-yellow">E</div>
        <div class="LevelUpText w3-tag  w3-yellow">V</div>
        <div class="LevelUpText w3-tag  w3-yellow">E</div>
        <div class="LevelUpText w3-tag  w3-yellow"
             style="margin-right: 16px;">L</div>
        <div class="LevelUpText w3-tag  w3-yellow">U</div>
        <div class="LevelUpText w3-tag  w3-yellow">P</div>

        <div class="Spacing" style="margin-top: 16px;"></div>  

        <div class="w3-tag w3-xxxlarge w3-green">
            <i class="fa fa-angle-double-up"></i>
        </div>
        <div class="LevelPart0 w3-tag w3-xxxlarge w3-green">9</div>
        <div class="w3-tag w3-xxxlarge w3-green">
            <i class="fa fa-angle-double-up"></i>
        </div>
        
        <blockquote class=""
                    style="margin: 25px 15px 0 15px !important; padding: 10px;">
           <span class="w3-large" style="font-style: italic;">"Read much make you professional."</span>
           <br>
           <span class="w3-medium">Professor Tom</span>
        </blockquote>  

        <a class="LevelUpCloseButton w3-btn w3-indigo w3-xlarge" href="#" style="
            margin-top: 25px;">Next ❯</a>
    </div>
</div>