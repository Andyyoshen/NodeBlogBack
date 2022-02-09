var from_DRCtrl_Article = require('../DBCtrl/DropDown_list')
module.exports.GetTag_DropDown_list = async function(obj){
    var DTO_in_article_titlepage = Object.values(obj)
    try{
        let SelectDB_DropDown_List_result = await from_DRCtrl_Article.SelectDB_DropDown_List(DTO_in_article_titlepage)
        if(SelectDB_DropDown_List_result.length!=0){
            console.log(SelectDB_DropDown_List_result)
            return SelectDB_DropDown_List_result
        }
        else{
            return false
        }
    }
    catch(err){
        console.log(err)
        return false
    }
}
