$(document).ready(function(){
        Run();
});

var TotalMeanLetters = 0;

async function SetData(Word, Mean, View, NextWordText){
    var WordDiv = $(".Word");
    var MeanDiv = $(".Mean");
    var ViewTextSpan = $(".ViewText");
    var NextWordTextSpan = $(".NextWordText");
    
    WordDiv.fadeOut();
    MeanDiv.fadeOut();
    $(".ReadCompletePanel").fadeOut();
    $(".NextWordPanel").fadeOut();
    await Sleep(750);
    /// set data
    // WORD 
    WordDiv.html(Word);
        // word size
    var ClassesSize = ["w3-jumbo", "w3-xxxlarge", "w3-xxlarge", "w3-xlarge"];
    var ClassWordSize = 'w3-jumbo';
    if(Word.length >= 7) ClassWordSize = 'w3-xxxlarge';
    if(Word.length >= 10) ClassWordSize = 'w3-xxlarge';
    if(Word.length >= 13) ClassWordSize = 'w3-xlarge';
    $.each(ClassesSize, function(i, v){
        WordDiv.removeClass(v);
    });
    WordDiv.addClass(ClassWordSize);
    // MEAN
    TotalMeanLetters = Mean.length;
        // mean size
    if(Mean.length >= 0 && Mean.length <= 100)
        CssMeanFontSize = '35px';
    if(Mean.length >= 101 && Mean.length <= 180) 
        CssMeanFontSize = '30px';
    if(Mean.length >= 181 && Mean.length <= 210) 
        CssMeanFontSize = '25px';
    if(Mean.length >= 211 && Mean.length <= 375) 
        CssMeanFontSize = '20px';
    if(Mean.length >= 376 ) 
        CssMeanFontSize = '15px';
    MeanDiv.css("font-size", CssMeanFontSize);
        // animation
    var MeanAnimationHtml = "<span style='text-shadow: 0 0 0 black;'>";
    var Index = 0;
    var IsEndFirstSentence = false;
    for(Index = 0; Index < Mean.length; Index++){
        if(Mean[Index] === "\n"){ // end line
            MeanAnimationHtml += "<br>- ";
            if(!IsEndFirstSentence){
                IsEndFirstSentence = true;
                MeanAnimationHtml += "</span>"; // end Mean
            }
        }else{ // normal
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
    await Sleep(300);
    MeanDiv.fadeIn();
}

async function RunAnimation(){
        var Index = 0;
        var TIME_BEAT = 50;
        for(Index = 0; Index < TotalMeanLetters; Index++){
            await Sleep(TIME_BEAT);
            $(".select"+Index).addClass("w3-light-blue");
        }
}
async function ShowCompletePanel(AmountExp){
        // init data
        $(".AmountExp").text(AmountExp);
        $(".ProgressBarPercent").css("width", User.CurrentPercent + "%");
        $(".ProgressBarText").text(User.CurrentExp + "/" + User.ThisLevelTotalExp);
        var ProgressBarText = User.CurrentPercent > 15 ? (User.CurrentPercent + "%") : "";
        $(".ProgressBarPercent").text(ProgressBarText);
        // show
        await Sleep(100);
        $(".ReadCompletePanel").show();
        await Sleep(600);  // for panel above show
        ThisLevelTotalExp =  User.ThisLevelTotalExp;
        var PercentPartFive = 0;
        var TotalPercent = User.NewPercent - User.CurrentPercent;
        var TotalTimeSleepProgressBar = 200; // ms, balance here
        var SleepBeatTime = TotalTimeSleepProgressBar / TotalPercent;
        for(PercentPartFive = User.CurrentPercent; 
            PercentPartFive <= User.NewPercent;
            PercentPartFive += 0.2)
        {
            await Sleep(SleepBeatTime);
            var PercentUI = PercentPartFive > 100 ? 100 : PercentPartFive; // fix overflow >100%       
             $(".ProgressBarPercent").css("width", PercentUI + "%");
            if(PercentUI >=15)
                $(".ProgressBarPercent").text(parseFloat(PercentUI).toFixed(1) + "%");
            
            CurrentExpTemp = Math.round(PercentUI * ThisLevelTotalExp / 100);
            $(".ProgressBarText").text(CurrentExpTemp + "/" + ThisLevelTotalExp);
        }
}
/// Data
var APP_TIME_BEAT = 100;
var CurrentWord = null;
var NextWord;
var UserId = 1; // test
var User;
var IsInitUser = true;
var IsNoWord = true;
var NextWordId = 0;

async function FetchDataBeat(){
    while(true){
        if(IsNoWord){
            // init
            if(NextWordId === 0){
                NextWordId = StartWordId;
            }
            //
            var JSONStr = await GetData("/word/AjaxGetWord/" + NextWordId);
            NextWord = JSON.parse(JSONStr);

            // init User data first time
            if(IsInitUser){
                IsInitUser = false;
                var JSONStr1 = await GetData("/word/AjaxGetUser/" + UserId + "/" + NextWord.Id);
                User = JSON.parse(JSONStr1);
            }

            IsNoWord = false;
            NextWordId = NextWord.NextWordId;
        }else{
            // do no thing
        }
        await Sleep(APP_TIME_BEAT);
    }
}

/// Operation
var IsPlayWord = false;
var IsSubmitReadResult = false;
async function WordBeat(){
    while(true){
        var HaveWord = !IsNoWord;
        var IsFree = !IsPlayWord;
        if(HaveWord && IsFree){
            CurrentWord = NextWord;
            IsNoWord = true;
            IsPlayWord = true;
            $(".LoadingWait").hide();
            var WordObj = CurrentWord;
            await SetData(WordObj.Word, WordObj.Mean, WordObj.View, WordObj.NextWord);
            await RunAnimation();
            
            //
            var Exp = WordObj.Mean.length;
            await ShowCompletePanel(Exp);

            // level up
            if(User.NewPercent >= 100){
                await Sleep(500); // for user watch some

                ShowLevelUp(parseInt(User.Level) + 1);
                while(IsLevelUpPopupShow){ // script in LevelUp.php
                    await Sleep(100);
                }

                await Sleep(500); // for fadeOut working...
            }

            // next word
            $(".NextWordPanel").show();
            await Sleep(600);  // for panel above show  
            // submit result: for user view complete panel
            IsSubmitReadResult = true; 
            var JSONStr1 = await GetData("/Word/AjaxReadComplete/" 
                            + User.Id + "/" + WordObj.Id + "/" + NextWord.Id);
                            // will wrong if NextWord.Id noy loading next yet.
            User = JSON.parse(JSONStr1); // user store updated data
            IsSubmitReadResult = false;

            IsPlayWord = false;
        }else if(IsPlayWord){
            // no case here
        }else{
            // wait new word
        }
        //
        await Sleep(APP_TIME_BEAT);
    }
}

//
async function OtherBeat(){
    // loading show...
    while(true){
        if(IsNoWord || IsSubmitReadResult){
            $(".LoadingWait").show();
        }else{
            $(".LoadingWait").hide();
        }
        //
        await Sleep(APP_TIME_BEAT);
    }
}

async function Run(){
    FetchDataBeat();
    WordBeat();
    OtherBeat();
}