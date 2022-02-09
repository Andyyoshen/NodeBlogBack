var from_ConnectionSouece = require('../../Config/ConnectSource')
module.exports.SelectAccount = async function(arry){
    console.log(arry)
    var cmd = "SELECT * FROM account WHERE AC_ID = ?"
    let  dataList = await from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}
