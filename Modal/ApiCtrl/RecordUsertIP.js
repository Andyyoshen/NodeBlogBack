var from_DBCtrl_ClientIpAddress = require('../DBCtrl/ClientIpAddress');


//[新增客戶端ip位置]
module.exports.InsertClientIP = async function(obj){
    // console.log(obj)
    // return false;
   let InsertClientIPDB_result = from_DBCtrl_ClientIpAddress.InsertClientIPDB(obj)
   if(InsertClientIPDB_result.length!=0){
       return true
   }
   else{
       return false
   }
}