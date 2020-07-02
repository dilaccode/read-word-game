$(document).ready(function () {
    /// init    
    // Home button
    $(".HomeButton").click(function () {
        // disable beat
        IsWordPage = false;
        //
        LoadHome();
    });

    // load components
    LoadComponent("/Html/LevelUp.html", "LevelUp", "WordScreen", "LevelUp");
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

async function SetData(WordObj) {
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
    WordDiv.html(WordObj.Word);
    // change size on phone. Tablet, PC keep jumbo
    var WordFontSize = Config.IsPhone ? '64' : '70';
    if (Config.IsPhone) {
        if (WordObj.Word.length >= 7)
            WordFontSize = '44';
        if (WordObj.Word.length >= 10)
            WordFontSize = '36';
        if (WordObj.Word.length >= 13)
            WordFontSize = '24';
    }
    WordDiv.css("font-size", WordFontSize + "px");
    // MEAN
    var MeanAndExamples = WordObj.Mean;
    if (WordObj.ListExamples.length > 0) {
        MeanAndExamples += "\n";
        MeanAndExamples += WordObj.ListExamples.join("\n");
    }
    //
    TotalMeanLetters = MeanAndExamples.length;
    // mean size
//    var Test = 240;
//    MeanAndExamples = MeanAndExamples.substring(0,Test);
//    var Need = Test - MeanAndExamples.length;
//    for(var Index=0;Index<Need;Index+=5)
//        MeanAndExamples+="0000 ";
//    Log(MeanAndExamples.length);
     
    var MeanFontSize = Config.IsPhone ? '35' : '40';
    if (Config.IsPhone) {
        if (MeanAndExamples.length >= 0 && MeanAndExamples.length <= 100)
            MeanFontSize = '37';
        if (MeanAndExamples.length >= 101 && MeanAndExamples.length <= 180)
            MeanFontSize = '32';
        if (MeanAndExamples.length >= 181 && MeanAndExamples.length <= 240)
            MeanFontSize = '27';
        if (MeanAndExamples.length >= 241 && MeanAndExamples.length <= 375)
            MeanFontSize = '22';
        if (MeanAndExamples.length >= 376)
            MeanFontSize = '17';
    }
    MeanDiv.css("font-size", MeanFontSize + "px");
    // animation
    var MeanAnimationHtml = "<span class='Tag w3-tag w3-indigo' style='font-size: "
            + (MeanFontSize * 0.7) + "px;'>Mean</span> <b>";
    var Index = 0;
    var IsEndFirstSentence = false;
    for (Index = 0; Index < MeanAndExamples.length; Index++) {
        if (MeanAndExamples[Index] === "\n") { // end line
            if (!IsEndFirstSentence) {
                IsEndFirstSentence = true;
                MeanAnimationHtml += "</b>"; // end Mean
            }
            MeanAnimationHtml += "<br>"
                    + "<span class='Tag w3-tag w3-green' style='font-size: "
                    + (MeanFontSize * 0.7) + "px;'>Example</span> ";
        } else { // normal
            MeanAnimationHtml += "<span class='select" + Index + "'>"
                    + MeanAndExamples[Index] + "</span>";
        }
    }
    MeanDiv.html(MeanAnimationHtml);

    // 
    ViewTextSpan.text(WordObj.View);
    //
    NextWordTextSpan.text(WordObj.NextWord);

    // show again
    WordDiv.fadeIn();
    await SleepCanSkip(IsWordPage, 150);
    // word sound
    var ClassSoundFile = "Sound" + WordObj.Id;
    $("." + ClassSoundFile).get(0).play();
    $("." + ClassSoundFile).removeClass("SoundWaiting");
    $("." + ClassSoundFile).removeClass(ClassSoundFile);
    await SleepCanSkip(IsWordPage, 150);
    //
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
            // load word sound here
            var WordFileNameMp3 = NextWord.Word.toLowerCase().split(" ").join("_");
            var SoundClass = "Sound" + NextWord.Id;
            var IsAddToAudio1 = !$(".Audio1").attr("class")
                    .includes("SoundWaiting");
            if (IsAddToAudio1) {
                $(".Audio1").attr("src", "/Sounds/Word/" + WordFileNameMp3 + ".mp3");
                $(".Audio1").addClass(SoundClass);
                $(".Audio1").addClass("SoundWaiting");
            } else {
                $(".Audio2").attr("src", "/Sounds/Word/" + WordFileNameMp3 + ".mp3");
                $(".Audio2").addClass(SoundClass);
                $(".Audio2").addClass("SoundWaiting");
            }

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
            var WordObj = CurrentWord;
            await SetData(WordObj);
            await RunAnimation();
            //            
            if (IsWordPage) {
                var MeanAndExamples = WordObj.Mean;
                if (WordObj.ListExamples.length > 0) {
                    MeanAndExamples += WordObj.ListExamples.join("");
                }
                var Exp = MeanAndExamples.length;
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
                var JSONStr1 = await GetData(SERVER_URL + "/Word/ReadComplete/"
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

