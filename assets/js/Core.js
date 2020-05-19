function Sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
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