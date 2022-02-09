var crypto = require('crypto');


var key = "37725295ea78b626";
var iv = "efcf77768be478c2";
let sign = ""

//[加密]
module.exports.Encryption = async function (encrypt) {
    let sign = "";
    const cipher = crypto.createCipheriv("aes-128-cbc", key, iv); // createCipher在10.0.0已被废弃
    sign += cipher.update(encrypt, "utf8", "hex");
    sign += cipher.final("hex");
    return sign
    // callback(sign)
}

//[解密]
module.exports.Decryption = async function (TodayToken) {
    let src = "";
    const cipher = crypto.createDecipheriv("aes-128-cbc", key, iv);
    src += cipher.update(TodayToken, "hex", "utf8");
    src += cipher.final("utf8");
    return src

}
//[取得今天日期]
module.exports.GetTodayDate =  function(){
  let TodayYear = new Date().getFullYear()
  let TodayMonth = new Date().getMonth() + 1
  let TodayDay = new Date().getDate()
  let TodayHour = new Date().getHours()
  let TodayMinutes = new Date().getMinutes()
  let TodayDate_Time = TodayYear + "/" + TodayMonth + "/" + TodayDay 
  return   TodayDate_Time
}
//[取得今天日期for資料庫格式]
module.exports.GetTodayDateForSql =  function(){
    let TodayYear = new Date().getFullYear()
    let TodayMonth = new Date().getMonth() + 1
    TodayMonth = (TodayMonth < 10 ? "0" : "")+TodayMonth ; //判斷月份補0
    let TodayDay = new Date().getDate();
    TodayDay = (TodayDay < 10 ? "0" : "")+TodayDay ; //判斷天數補0
    let TodayDate_Time = TodayYear + "-" + TodayMonth + "-" + TodayDay 
    return   TodayDate_Time
  }
//[透過Token驗證API是否過期]
module.exports.IsVerifyDate = async function (Token) {
    let Decryption_result  = await this.Decryption(Token) 
        //------------------- 日期相減比較----------------------
        let TodayYear = new Date().getFullYear()
        let TodayMonth = new Date().getMonth() + 1
        let TodayDay = new Date().getDate()
        let TodayHour = new Date().getHours()
        let TodayMinutes = new Date().getMinutes()
        let Today_Total_Time = TodayYear + "/" + TodayMonth + "/" + TodayDay + " " + TodayHour + ":" + TodayMinutes
        let Today_Total_Time_Trance = new Date(Today_Total_Time)
        let Late_Time = new Date(Decryption_result)
        let Final_Time = parseInt(Math.abs(Today_Total_Time_Trance - Late_Time) / 1000 / 60)
        //------------------- 日期相減比較----------------------
        if (Final_Time < 100) {
            return true
        }
        else {
            return false
        }
}