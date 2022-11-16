var from_DBCtrl_Article_TitlePage = require('../DBCtrl/Article_TitlePage')
var from_DBCtrl_GeneralWeb = require('../DBCtrl/GeneralWeb')

//[搜尋封面文章]
module.exports.Search_Artitcle_Title = async function(obj){
    try{
        console.log(obj)
        obj.SearchData = '%' + obj.SearchData + '%' // 為了要符合模糊查詢
        var DTO_trance = Object.values(obj)
        let SearchDB_Article_Title_result =await from_DBCtrl_Article_TitlePage.SearchDB_Article_Title(DTO_trance)
        let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
       // console.log(GetDB_Article_TitlePage_result[0])
       SearchDB_Article_Title_result.forEach(num=>{
            num.img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+num.img_article_titlepage
        })
       // GetDB_Article_TitlePage_result[0].img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+GetDB_Article_TitlePage_result[0]
        if(SearchDB_Article_Title_result.length != 0){
            return SearchDB_Article_Title_result
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

//[封面文章日期topNew]
module.exports.GetTopNew_Artitcle_Title = async function(){
    try{
       // console.log(obj)
        let GetTopNewDB_Article_Title_result = await from_DBCtrl_Article_TitlePage.GetTopNewDB_Article_Title() //撈新日期封面文章
        let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
       // console.log(GetDB_Article_TitlePage_result[0])
       
        if(GetTopNewDB_Article_Title_result.length != 0){
            GetTopNewDB_Article_Title_result.forEach(num=>{
                num.img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+num.img_article_titlepage
            })
             return GetTopNewDB_Article_Title_result.slice(0,3)
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