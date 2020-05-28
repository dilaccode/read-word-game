<?php
/**
 * USE Javascript
 *  
 * ShowLevelUp(Level);
 *  
 */
?>

<!-- LEVEL UP -->

<script>
    var IsLevelUpPopupShow = false;
    async function ShowLevelUp(Level) {
        IsLevelUpPopupShow = true;
        // remove level part (for 2nd)
        var ArrayLevelPart = $('div[class*="LevelPart"]');
        var Index = 0;
        for (Index = 1; Index < ArrayLevelPart.length; Index++) {
            ArrayLevelPart[Index].remove();
        }
        // set level
        LevelStr = Level + "";
        var Index = 0;
        $(".LevelPart0").text(LevelStr[0]);
        var DivLevelPart = $(".LevelPart0");
        for (Index = 1; Index < LevelStr.length; Index++) {
            DivLevelPart.after("<div class=\"LevelPart"
                    + Index + " LevelPartGroup LevelUpText2nd w3-tag w3-green\">X</div>");
            $(".LevelPart" + Index).text(LevelStr[Index]);
            DivLevelPart = $(".LevelPart" + Index);
        }
        // show
        $(".LevelUp").fadeIn();
        // Shake animation
        var ArrayShake = $(".ShakeGroup");
        var ArrayAnimation = [];
        ArrayShake.each(function () {
            ArrayAnimation.push($(this));
        });
        for (let Index = 0; Index < ArrayAnimation.length; Index++) {
            ArrayAnimation[Index].addClass("Shake");
            await Sleep(100);
        }
    }

    $(document).ready(function () {
        // close button
        $(".LevelUpCloseButton").click(function () {
            $(".LevelUp").fadeOut();
            IsLevelUpPopupShow = false;
        });

    });
</script>
<div class="LevelUp w3-display-middle w3-center" 
     style="display: none;">
    <div class="LevelUpContent LevelUpContentByDevice">
        <div class="LevelUpText w3-tag  w3-yellow">L</div>
        <div class="LevelUpText w3-tag  w3-yellow">E</div>
        <div class="LevelUpText w3-tag  w3-yellow">V</div>
        <div class="LevelUpText w3-tag  w3-yellow">E</div>
        <div class="LevelUpText w3-tag  w3-yellow"
             style="margin-right: 16px;">L</div>
        <div class="LevelUpText w3-tag  w3-yellow">U</div>
        <div class="LevelUpText w3-tag  w3-yellow">P</div>

        <div class="Spacing" style="margin-top: 16px;"></div>  

        <div class="ShakeGroup LevelUpText2nd w3-tag w3-green">
            <i class="fa fa-angle-double-up"></i>
        </div>
        <div class="LevelPart0 LevelUpText2nd LevelPartGroup w3-tag w3-green">9</div>
        <div class="ShakeGroup LevelUpText2nd w3-tag w3-green">
            <i class="fa fa-angle-double-up"></i>
        </div>

        <blockquote class="Tutorial">
            <span class="Text w3-text-white" style="font-style: italic;">"Read much make you professional."</span>
            <br>
            <span class="Author w3-text-sand">Professor Tom</span>
        </blockquote>
        <div class="LevelUpCloseButton ButtonImage DivBlockCenter">
            <img src="/assets/images/NextButton.png"/>
        </div>
    </div>
</div>