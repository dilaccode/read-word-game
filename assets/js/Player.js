$(document).ready(function () {
    LoadHome();
});
/// global var
var IsWordPage = false; // for disable/enable beat

// navigation
function LoadHome() {
    Load("/Home/Start", "HomeScreen", "Home");
}
async function LoadWord() {
    await Load("/Word", "WordScreen", "Word", true);
    WordRun();
}

// load 
async function Load(URI, ClassName, JsName = "", IsShowLoadingOnExistScreen = false) {
    if (!IsLoaded(ClassName)) {
        $(".Loading").fadeIn();
        $(".Current").hide();
        $(".Current").removeClass("Current");

        var HtmlStr = await GetData(URI);
        if (JsName.length > 0) {
            await LoadJs(JsName);
        }
        // create new Div
        $("body").prepend("<!-- " + ClassName + " -->");
        $("body").prepend("<div class='" + ClassName + " Screen Current'></div>");
        $('.' + ClassName).html(HtmlStr);

        $(".Loading").fadeOut();

        // load manage
        console.log("Load new: " + ClassName);
        ListLoaded.push(ClassName);
    } else {
        console.log("Loaded: " + ClassName);
        //
        $(".Current").fadeOut();
        await Sleep(250);
        if (IsShowLoadingOnExistScreen)
            $(".Loading").fadeIn();
        $(".Current").removeClass("Current");
        $("." + ClassName).fadeIn();
        $("." + ClassName).addClass("Current");
        if (IsShowLoadingOnExistScreen)
            $(".Loading").fadeOut();
}
}


/// MANAGE LOADING RESOURCES
// loading thing 1 time, unique by ClassName

var ListLoaded = new Array();

function IsLoaded(ClassName) {
    return ListLoaded.indexOf(ClassName) > -1;
}

async function LoadJs(JsName) {
    var HtmlJs = "<script type='text/javascript' src='/assets/js/" + JsName + ".js'></script>";
    $("head").append(HtmlJs);
}