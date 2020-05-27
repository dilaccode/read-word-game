$(document).ready(function () {
    LoadHome();
});
/// navigation
function LoadHome() {
    Load("/Home/Start", "Home", "Home");
}

function LoadWord() {
    Load("/Word", "Word", "Word");
}

// load 
async function Load(URI, ClassName, JsName = "") {
    if (!IsLoaded(ClassName)) {
        $(".Loading").fadeIn();
        $(".Current").hide();
        
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
        Sleep(500);
        $("." + ClassName).fadeIn();
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