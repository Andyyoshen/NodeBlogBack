var from_ConnectionSouece = require('../../Config/ConnectSource')
module.exports.SelectDB_DropDown_List = async function(arry){
    var cmd = "SELECT * FROM dropdown_list WHERE Type = ?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList

}