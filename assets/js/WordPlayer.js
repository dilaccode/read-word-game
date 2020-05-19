$(document).ready(function(){
        Run();
});

var TotalMeanLetters = 0;

async function SetData(Word, Mean, View){
    var WordDiv = $(".Word");
    var MeanDiv = $(".Mean");
    var ViewTextSpan = $(".ViewText");
    
    WordDiv.fadeOut();
    MeanDiv.fadeOut();
    $(".ReadCompletePanel").fadeOut();
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
    CssMeanFontSize = '35px';
    ArrayMeanWords = Mean.split(" ");
    if(ArrayMeanWords.length >= 20) // 20-3x words
        CssMeanFontSize = '30px';
    if(ArrayMeanWords.length >= 31) // 3x-55 words
        CssMeanFontSize = '22px';
    MeanDiv.css("font-size", CssMeanFontSize);
        // animation
    var MeanAnimationHtml = "";
    var Index = 0;
    for(Index = 0; Index < Mean.length; Index++){
        MeanAnimationHtml += "<span class='select" + Index + "'>" 
                        + Mean[Index] + "</span>";
    }
    MeanDiv.html(MeanAnimationHtml);

    // VIEW
    ViewTextSpan.text(View);

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
            PercentPartFive+=0.2)
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
var CurrentWord;
var NextWord;
var User;
var IsNoWord = true;
var testId= 8192;

async function FetchDataBeat(){
    while(true){
        if(IsNoWord){
            console.log("\nFetchDataBeat: I am fetch new word...");
            var JSONStr = await GetData("/word/AjaxGetWord/" + testId);
            var ArrayData = JSON.parse(JSONStr);
            NextWord = ArrayData[0];
            User = ArrayData[1];
            console.log(User);
            IsNoWord = false;
            console.log("FetchDataBeat: fetch success: " + NextWord.Word);
            // test
            testId++;
        }else{
            console.log("\nFetchDataBeat: no fetching.");
        }
        await Sleep(APP_TIME_BEAT);
    }
}

/// Operation
var IsPlayWord = false;
async function WordBeat(){
    while(true){
        var HaveWord = !IsNoWord;
        var IsFree = !IsPlayWord;
        if(HaveWord && IsFree){
            console.log("\nWordBeat: I start show word: " + NextWord.Word);
            CurrentWord = NextWord;
            IsNoWord = true;
            IsPlayWord = true;
            $(".LoadingWait").hide();
            var WordObj = CurrentWord;
            await SetData(WordObj.Word, WordObj.Mean, WordObj.View);
            await RunAnimation();
            var Exp = WordObj.Mean.length;
            await ShowCompletePanel(Exp);
            IsPlayWord = false;
        }else if(IsPlayWord){
            console.log("\nWordBeat: I showing..." + NextWord.Word);
        }else{
            console.log("\nWordBeat: I waiting new word...");
            $(".LoadingWait").show();
        }
        //
        await Sleep(APP_TIME_BEAT);
    }
}

async function Run(){
    FetchDataBeat();
    WordBeat();
}


/// old ---- will delete
var IsShowNextPanel = false;
var IsAjaxReadComplete = false;

async function Run1(){ 
        IsShowNextPanel = false;
        IsAjaxReadComplete = false;
        
        //[run first] ajax run no affect by Sleep()
        // GetData("<?php echo "/Word/AjaxReadComplete/$User->Id/$WordObj->Id"?>");

        // show complete panel
        // await Sleep(100);
        // $(".ReadResultPanel").show();
        // await Sleep(600);  // for panel above show
        //     // progres bar, will rewrite with ES6
        // ThisLevelTotalExp = <?php echo $User->ThisLevelTotalExp ?>;
        // var PercentPartFive = 0;
        // var TotalPercent = <?php echo $User->NewPercent ?> - <?php echo $User->CurrentPercent ?>;
        // var TotalTimeSleepProgressBar = 200; // ms, balance here
        // var SleepBeatTime = TotalTimeSleepProgressBar / TotalPercent;
        // for(PercentPartFive = <?php echo $User->CurrentPercent ?>; 
        //     PercentPartFive <= <?php echo $User->NewPercent ?>;
        //     PercentPartFive+=0.2)
        // {
        //     await Sleep(SleepBeatTime);
        //     var PercentUI = PercentPartFive > 100 ? 100 : PercentPartFive; // fix overflow >100%       
        //      $(".ProgressBarPercent").css("width", PercentUI + "%");
        //     if(PercentUI >=15)
        //         $(".ProgressBarPercent").text(parseFloat(PercentUI).toFixed(1) + "%");
            
        //     CurrentExpTemp = Math.round(PercentUI * ThisLevelTotalExp / 100);
        //     $(".ProgressBarText").text(CurrentExpTemp+"/"+ThisLevelTotalExp);
        // }

        // // next word
        // $(".NextWordPanel").show();
        // await Sleep(600);  // for panel above show        
        // IsShowNextPanel =true;

        // await Sleep(500); // wait some before show next word

        // $(".Loading").show(); // for wait if Ajax still running

        // // wait show banner complete and submit data done
        // var IsWait = true;
        // while(IsWait){
        //     IsWait = !IsShowNextPanel || !IsAjaxReadComplete;
        //     await Sleep(100);
        // }

        // next
        // location.href = "/Word/View/<?php echo rawurlencode($NextWord) ?>";

        // test
        await SetData("ok","babyyy LET YOu go, go",12345);

        RunAnimation();
    }