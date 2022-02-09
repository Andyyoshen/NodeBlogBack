var from_ConnectionSouece = require('../../Config/ConnectSource')
module.exports.SelectDB_GeneralWeb = async function(){
    var cmd =  `SELECT * FROM  general_web WHERE type_general_web = 'ImageUrl'`
    let SelectURL_result = await from_ConnectionSouece.ConSql3(cmd,null)
    console.log(SelectURL_result)
    return SelectURL_result
}