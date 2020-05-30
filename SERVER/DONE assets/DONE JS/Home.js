$(document).ready(function () {
    // play button
    $(".PlayButton").click(function () {
        LoadWord();
        // enable beat
        IsWordPage = true;
    });
    SetLevelHomeScreen();
});

async function SetLevelHomeScreen(Level = 0, IsNoAjax = false) {
    // get level
    var LevelStr = "";
    if (!IsNoAjax) {
        LevelStr = await GetData("/User/AjaxGetLevel");
        LevelStr = String(LevelStr);
    } else {
        LevelStr = Level + "";
        console.log("set level no ajax");
    }
    // set level
    var HomeLevelDiv = $(".HomeLevel");
    HomeLevelDiv.html("");
    HomeLevelDiv.append("<span class=\"LevelPartGroup w3-tag w3-indigo\">LEVEL</span>");
    for (let Index = 0; Index < LevelStr.length; Index++) {
        HomeLevelDiv.append("<span class=\"LevelPartGroup w3-tag w3-green\">"
                + LevelStr[Index] + "</span>");
}
}