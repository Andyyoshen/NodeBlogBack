var from_DRCtrl_Article_TitlePage = require('../DBCtrl/Article_TitlePage')
var from_DRCtrl_Article = require('../DBCtrl/Article')
var from_DBCtrl_GeneralWeb = require('../DBCtrl/GeneralWeb')
module.exports.DeleteArticle_TitlePage = async function(obj){
    try{
        var DTO_trance = Object.values(obj)
        
        let DeleteDB_Article_Title_result  = await from_DRCtrl_Article_TitlePage.DeleteDB_Article_Title(DTO_trance)
        console.log(DeleteDB_Article_Title_result)
        if(DeleteDB_Article_Title_result!=0){
            let GetDB_Article_TitlePage_result =await from_DRCtrl_Article.GetDB_Article_TitlePage_JOIN_Dropdown_List_NoWHERE(null)
            let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
            GetDB_Article_TitlePage_result.forEach(num=>{
                num.img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+num.img_article_titlepage
            })
            if(GetDB_Article_TitlePage_result.length != 0){
                return GetDB_Article_TitlePage_result
            }
            else{
                return false
            }
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