var from_DRCtrl_Article = require('../DBCtrl/Article')
var from_DBCtrl_GeneralWeb = require('../DBCtrl/GeneralWeb')
var from_LogicFun = require('../General/LogicFun')
//[新增文章]
module.exports.InsertArticleContent = async function(obj){
    //console.log(obj)
    let GetTodayDateForSql_result = from_LogicFun.GetTodayDateForSql()
    console.log(GetTodayDateForSql_result)
   // return false
    //把obj的資料分裝DTO_in_article_titlepage(封面)
    var DTO_in_article_titlepage = {
        title_article_titlepage:obj.title_article_titlepage,
        previewcontent_article_titlepage:obj.previewcontent_article_titlepage,
        type_article_titlepage:"Normal",
        tag_article_titlepage:obj.tag_article_titlepage,
        img_article_titlepage:obj.img_article_titlepage,
        date_article_titlepage:GetTodayDateForSql_result
    }
    try{
        //新增封面資料
        let InsertDB_Article_TitlePage_result = await from_DRCtrl_Article.InsertDB_Article_TitlePage(DTO_in_article_titlepage)
        if(InsertDB_Article_TitlePage_result.length!=0){
            //把obj的資料分裝DTO_in_article(內容)
            var DTO_in_article={
                content_article:obj.content_article,
                article_titlepage_id:InsertDB_Article_TitlePage_result.insertId,
                img_article:obj.img_article_titlepage
            }
            //新增內容資料
            let InsertDB_ArticleContent_result = await from_DRCtrl_Article.InsertDB_ArticleContent(DTO_in_article)
            if(InsertDB_ArticleContent_result.length!=0){
                return true
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
//[更新文章]
module.exports.UpdateArticleContent = async function(obj){
    //console.log(obj)
    let GetTodayDate_result = from_LogicFun.GetTodayDate()
    //console.log(GetTodayDate_result)
    if(obj.img_article_titlepage != undefined){
        //把obj的資料分裝DTO_in_article_titlepage(封面)
        var DTO_in_article_titlepage = {  
            title_article_titlepage:obj.title_article_titlepage, //標題
            previewcontent_article_titlepage:obj.previewcontent_article_titlepage, //摘要
            type_article_titlepage:"Normal", //狀態
            tag_article_titlepage:obj.tag_article_titlepage, //標籤
            img_article_titlepage:obj.img_article_titlepage, //封面圖
            date_article_titlepage:GetTodayDate_result, //日期      
        }
    }
    else{
        //把obj的資料分裝DTO_in_article_titlepage(封面)
        var DTO_in_article_titlepage = {  
            title_article_titlepage:obj.title_article_titlepage, //標題
            previewcontent_article_titlepage:obj.previewcontent_article_titlepage, //摘要
            type_article_titlepage:"Normal", //狀態
            tag_article_titlepage:obj.tag_article_titlepage, //標籤
            date_article_titlepage:GetTodayDate_result, //日期      
        }
    }
    try{
        //新增封面資料
        console.log(DTO_in_article_titlepage)
        var DTO_arry = []; //為了符合sql規格
        DTO_arry.push(DTO_in_article_titlepage,obj.id_article_titlepage);
        let UpdateDB_Article_TitlePage_result = await from_DRCtrl_Article.UpdateDB_Article_TitlePage(DTO_arry)
        console.log(UpdateDB_Article_TitlePage_result)
        // if(UpdateDB_Article_TitlePage_result.length!=0){
        //     return true
        // }
        // return false
        if(UpdateDB_Article_TitlePage_result.length!=0){
            if(obj.img_article_titlepage!=undefined){
                //把obj的資料分裝DTO_in_article(內容)
                    var DTO_in_article={
                    content_article:obj.content_article,
                   // article_titlepage_id:UpdateDB_Article_TitlePage_result.insertId,
                    img_article:obj.img_article_titlepage
                }
            }
            else{
                var DTO_in_article={
                    content_article:obj.content_article,
                    //article_titlepage_id:UpdateDB_Article_TitlePage_result.insertId,
                }
            }
            //新增內容資料
            var ArticleContent_DTO_arry = [];
            ArticleContent_DTO_arry.push(DTO_in_article,obj.id_article_titlepage)
            let UpdateDB_ArticleContent_result = await from_DRCtrl_Article.UpdateDB_ArticleContent(ArticleContent_DTO_arry)
            if(UpdateDB_ArticleContent_result.length!=0){
                return true
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
//[不一條件抓封面]
module.exports.Get_Article_TitlePageNoWhere = async function(obj){
    console.log("大家好")
    try{
        var DTO_trance = Object.values(obj)
        let GetDB_Article_TitlePage_result =await from_DRCtrl_Article.GetDB_Article_TitlePage_JOIN_Dropdown_List_NoWHERE(null)
        let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
       // console.log(GetDB_Article_TitlePage_result[0])
        GetDB_Article_TitlePage_result.forEach(num=>{
            num.img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+num.img_article_titlepage
        })
       // GetDB_Article_TitlePage_result[0].img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+GetDB_Article_TitlePage_result[0]
        if(GetDB_Article_TitlePage_result.length != 0){
            return GetDB_Article_TitlePage_result
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
//[抓封面]
module.exports.Get_Article_TitlePage = async function(obj){
    
    try{
        var DTO_trance = Object.values(obj)
        let GetDB_Article_TitlePage_result =await from_DRCtrl_Article.GetDB_Article_TitlePage_JOIN_Dropdown_List(DTO_trance)
        let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
       // console.log(GetDB_Article_TitlePage_result[0])
        GetDB_Article_TitlePage_result.forEach(num=>{
            num.img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+num.img_article_titlepage
        })
       // GetDB_Article_TitlePage_result[0].img_article_titlepage = SelectDB_GeneralWeb_result[0].content_general_web+GetDB_Article_TitlePage_result[0]
        if(GetDB_Article_TitlePage_result.length != 0){
            return GetDB_Article_TitlePage_result
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
//[抓文章內容]
module.exports.GetArticleContent = async function(obj){
    try{
        var DTO_trance = Object.values(obj)
        let GetDB_ArticleContent_result = await from_DRCtrl_Article.GetDB_ArticleContent_JOIN_Article(DTO_trance) //撈文章內容
        let SelectDB_GeneralWeb_result  = await from_DBCtrl_GeneralWeb.SelectDB_GeneralWeb() // 撈基礎網址
        if(GetDB_ArticleContent_result.length!=0){
            console.log("asdd")
            //將基礎網址加上圖片名稱
            GetDB_ArticleContent_result[0].img_article = SelectDB_GeneralWeb_result[0].content_general_web+GetDB_ArticleContent_result[0].img_article
            return GetDB_ArticleContent_result
        }
    }
    catch(err){
        console.log(err)
        return false
    }
}