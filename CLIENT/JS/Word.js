$(document).ready(function () {
    /// init    
    // Home button
    $(".HomeButton").click(function () {
        // disable beat
        IsWordPage = false;
        //
        LoadHome();
    });
});



var TotalMeanLetters = 0;
/// Data
var APP_TIME_BEAT = 100;
var CurrentWord = null;
var NextWord;
var UserId = 1; // test
var User;
var IsInitUser = true;
var IsNoWord = true;
var NextWordId = 0;


async function SetInitState() {
    $(".Word").html("...");
    $(".Mean").html("...");
    $(".ViewText").html("...");
    $(".ReadCompletePanel").hide();
    $(".NextWordPanel").hide();
    $(".LevelUp").hide();
}

async function SetData(Word, Mean, View, NextWordText) {
    var WordDiv = $(".Word");
    var MeanDiv = $(".Mean");
    var ViewTextSpan = $(".ViewText");
    var NextWordTextSpan = $(".NextWordText");

    WordDiv.fadeOut();
    MeanDiv.fadeOut();
    $(".ReadCompletePanel").fadeOut();
    $(".NextWordPanel").fadeOut();
    await SleepCanSkip(IsWordPage, 750);
    /// set data
    // WORD 
    WordDiv.html(Word);
    // change size on phone. Tablet, PC keep jumbo
    var WordFontSize = IsPhone ? '64' : '70';
    if (IsPhone) {
        if (Word.length >= 7)
            WordFontSize = '48';
        if (Word.length >= 10)
            WordFontSize = '36';
        if (Word.length >= 13)
            WordFontSize = '24';
    }
    WordDiv.css("font-size", WordFontSize + "px");
    // MEAN
    TotalMeanLetters = Mean.length;
    // mean size
    var MeanFontSize = IsPhone ? '35' : '40';
    if (IsPhone) {
        if (Mean.length >= 0 && Mean.length <= 100)
            MeanFontSize = '35';
        if (Mean.length >= 101 && Mean.length <= 180)
            MeanFontSize = '30';
        if (Mean.length >= 181 && Mean.length <= 210)
            MeanFontSize = '25';
        if (Mean.length >= 211 && Mean.length <= 375)
            MeanFontSize = '20';
        if (Mean.length >= 376)
            MeanFontSize = '15';
    }
    MeanDiv.css("font-size", MeanFontSize + "px");
    // animation
    var MeanAnimationHtml = "<span class='Tag w3-tag w3-indigo' style='font-size: "
            + (MeanFontSize * 0.7) + "px;'>Mean</span> <b>";
    var Index = 0;
    var IsEndFirstSentence = false;
    for (Index = 0; Index < Mean.length; Index++) {
        if (Mean[Index] === "\n") { // end line
            if (!IsEndFirstSentence) {
                IsEndFirstSentence = true;
                MeanAnimationHtml += "</b>"; // end Mean
            }
            MeanAnimationHtml += "<br>"
                    + "<span class='Tag w3-tag w3-green' style='font-size: "
                    + (MeanFontSize * 0.7) + "px;'>Example</span> ";
        } else { // normal
            MeanAnimationHtml += "<span class='select" + Index + "'>"
                    + Mean[Index] + "</span>";
        }
    }
    MeanDiv.html(MeanAnimationHtml);

    // 
    ViewTextSpan.text(View);
    //
    NextWordTextSpan.text(NextWordText);

    // show again
    WordDiv.fadeIn();
    await SleepCanSkip(IsWordPage, 300);
    MeanDiv.fadeIn();
}

async function RunAnimation() {
    var Index = 0;
    var TIME_BEAT = 50;
    for (Index = 0; Index < TotalMeanLetters; Index++) {
        await SleepCanSkip(IsWordPage, TIME_BEAT);
        $(".select" + Index).addClass("w3-light-blue");
    }
}
async function ShowCompletePanel(AmountExp) {
    // init data
    $(".AmountExp").text(AmountExp);
    $(".ProgressBarPercent").css("width", User.CurrentPercent + "%");
    $(".ProgressBarText").text(User.CurrentExp + "/" + User.ThisLevelTotalExp);
    var ProgressBarText = User.CurrentPercent > 15 ? (User.CurrentPercent + "%") : "";
    $(".ProgressBarPercent").text(ProgressBarText);
    // show
    await SleepCanSkip(IsWordPage, 100);
    $(".ReadCompletePanel").show();
    await SleepCanSkip(IsWordPage, 600);  // for panel above show
    ThisLevelTotalExp = User.ThisLevelTotalExp;
    var PercentPartFive = 0;
    var TotalPercent = User.NewPercent - User.CurrentPercent;
    var TotalTimeSleepProgressBar = 200; // ms, balance here
    var SleepBeatTime = TotalTimeSleepProgressBar / TotalPercent;
    for (PercentPartFive = User.CurrentPercent;
            PercentPartFive <= User.NewPercent;
            PercentPartFive += 0.2)
    {
        await SleepCanSkip(IsWordPage, SleepBeatTime);
        var PercentUI = PercentPartFive > 100 ? 100 : PercentPartFive; // fix overflow >100%       
        $(".ProgressBarPercent").css("width", PercentUI + "%");
        if (PercentUI >= 15)
            $(".ProgressBarPercent").text(parseFloat(PercentUI).toFixed(1) + "%");

        CurrentExpTemp = Math.round(PercentUI * ThisLevelTotalExp / 100);
        $(".ProgressBarText").text(CurrentExpTemp + "/" + ThisLevelTotalExp);
    }
}


async function FetchDataBeat() {
    while (IsWordPage) {
        if (IsNoWord) {
            // init
            if (NextWordId === 0) {
                var Str = await GetData(SERVER_URL + "/Word/StartId");
                NextWordId = JSON.parse(Str);
            }
            //
            var JSONStr = await GetData(SERVER_URL + "/Word/GetWord/" + NextWordId);
            NextWord = JSON.parse(JSONStr);

            // init User data first time
            if (IsInitUser) {
                IsInitUser = false;
                var JSONStr1 = await GetData(SERVER_URL + "/Word/GetUser/" + UserId + "/" + NextWord.Id);
                User = JSON.parse(JSONStr1);
            }

            IsNoWord = false;
            NextWordId = NextWord.NextWordId;
        } else {
            // do no thing
        }
        await SleepCanSkip(IsWordPage, APP_TIME_BEAT);
    }
}

/// Operation
var IsPlayWord = false;
var IsSubmitReadResult = false;
async function WordBeat() {
    while (IsWordPage) {
        var HaveWord = !IsNoWord;
        var IsFree = !IsPlayWord;
        if (HaveWord && IsFree) {
            CurrentWord = NextWord;
            IsNoWord = true;
            IsPlayWord = true;
            $(".LoadingWait").hide();
            var WordObj = CurrentWord
            await SetData(WordObj.Word, WordObj.Mean, WordObj.View, WordObj.NextWord);
            await RunAnimation();
            //            
            if (IsWordPage) {
                var Exp = WordObj.Mean.length;
                await ShowCompletePanel(Exp);

                // level up
                if (User.NewPercent >= 100) {
                    await SleepCanSkip(IsWordPage, 500); // for user watch some
                    ShowLevelUp(parseInt(User.Level) + 1);
                    SetLevelHomeScreen(parseInt(User.Level) + 1, true);
                    while (IsLevelUpPopupShow) { // script in LevelUp.php
                        await SleepCanSkip(IsWordPage, 100);
                    }

                    await SleepCanSkip(IsWordPage, 500); // for fadeOut working...
                }
            }

            // next word
            if (IsWordPage) {
                $(".NextWordPanel").show();
                await SleepCanSkip(IsWordPage, 600);  // for panel above show  
            }

            if (IsWordPage) {
                // submit result: for user view complete panel            
                IsSubmitReadResult = true;
                var JSONStr1 = await GetData("/Word/AjaxReadComplete/"
                        + User.Id + "/" + WordObj.Id + "/" + NextWord.Id);
                // will wrong if NextWord.Id noy loading next yet.
                User = JSON.parse(JSONStr1); // user store updated data
                IsSubmitReadResult = false;
            }

            IsPlayWord = false;
        } else if (IsPlayWord) {
            // no case here
        } else {
            // wait new word
        }
        //
        await SleepCanSkip(IsWordPage, APP_TIME_BEAT);
    }
}

//
async function OtherBeat() {
    // loading show...
    while (IsWordPage) {
        console.log("beat running...")
        var IsLoadingPanelShow = $(".Loading").is(":visible");
        if ((IsNoWord || IsSubmitReadResult) && !IsLoadingPanelShow) {
            $(".LoadingWait").show();
        } else {
            $(".LoadingWait").hide();
        }
        //
        await SleepCanSkip(IsWordPage, APP_TIME_BEAT);
    }
}

async function WordRun() {
    //
    SetInitState();
    // beat
    FetchDataBeat();
    WordBeat();
    OtherBeat();
}

