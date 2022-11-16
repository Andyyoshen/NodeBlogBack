var from_ConnectionSouece = require('../../Config/ConnectSource')
module.exports.InsertClientIPDB = async function(obj){
    var cmd = "INSERT INTO personallog.clientipaddress SET?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,obj)
    return dataList

}