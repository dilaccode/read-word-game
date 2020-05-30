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