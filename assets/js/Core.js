function Sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
/// use like Sleep(): await SleepCanSkip();
async function SleepCanSkip(VarCondition, MiliSeconds){
     if(VarCondition){
        await Sleep(MiliSeconds);
     }
}

function GetData(AjaxUrl) { 
    return $.ajax({
        url: AjaxUrl,
        type: 'GET',
        success : function(data) {
            // console.log(data);
        }
    });
};
