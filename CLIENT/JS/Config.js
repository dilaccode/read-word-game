//
var SERVER_URL = "http://" + window.location.hostname + ":81";
//
var IsLoadedConfigFromServer = false;
var Config = null;
//
$(document).ready(function () {
//    Is Phone
    GetConfigIsPhone();
});
async function GetConfigIsPhone() {
    var ConfigStr = await GetData(SERVER_URL + "/ClientConfig/IsPhone");
    var Config = JSON.parse(ConfigStr);
    IsLoadedConfigFromServer = true;
    // Load Device css
    $("head").append("<!-- Device CSS -->");
    if (Config.IsPhone) {
        $("head").append("<link rel=\"stylesheet\" href=\"/CSS/Phone.css\">");
    } else {
        $("head").append("<link rel=\"stylesheet\" href=\"/CSS/TabletAndPC.css\">");
    }
}
