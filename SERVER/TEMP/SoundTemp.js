$(document).ready(function () {
    Beat();
});

async function Beat() {
    var LastWord = "";
    var IsOpenThisWord = false;
    var Tab = null;
    var IsTabInit = false;
    while (true) {
        // get current word
        var Str = await GetData("/tempsound/AjaxGetWord");
        var WordObj = JSON.parse(Str);
        // is change?
        if (LastWord !== WordObj.Word) {
            LastWord = WordObj.Word;
            Log("new word comming: " + LastWord);
            // close old work
            if(IsTabInit){
                Tab.close();
            }
            // active new work
            IsOpenThisWord = false;
        }
        Log("working with: " + LastWord + " ...");
        if (!IsOpenThisWord) {
            IsOpenThisWord = true;
            var url = "https://dictionary.cambridge.org/dictionary/english/" + WordObj.Word;
            var Tab = window.open(url, '_blank');
            Tab.focus();
            Log("open tab: " + LastWord);
            //
            IsTabInit = true;
        }
        await Sleep(250);
    }
}





/// CORE ===========================
function Log(Thing) {
    console.log(Thing);
}
function Sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
/// use like Sleep(): await SleepCanSkip();
async function SleepCanSkip(VarCondition, MiliSeconds) {
    if (VarCondition) {
        await Sleep(MiliSeconds);
    }
}

function GetData(AjaxUrl) {
    return $.ajax({
        url: AjaxUrl,
        type: 'GET',
        success: function (data) {
            // console.log(data);
        }
    });
}
;
