var from_ConnectionSouece = require('../../Config/ConnectSource')
//[新增文章article]
module.exports.InsertDB_ArticleContent = async function(obj){
    console.log("過年")
    console.log(obj)
    var cmd = "INSERT INTO article SET ?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,obj)
    return dataList
}
//[更新文章article]
module.exports.UpdateDB_ArticleContent = async function(arry){
    var cmd =  `update personallog.article
                SET ?
                WHERE personallog.article.article_titlepage_id = ?`
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}
//[新增封面article_titlepage]
module.exports.InsertDB_Article_TitlePage = async function(obj){
    var cmd = "INSERT INTO article_titlepage SET ?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,obj)
    return dataList
}
//[更新封面article_titlepage]
module.exports.UpdateDB_Article_TitlePage = async function(arry){
    var cmd = `update personallog.article_titlepage 
               SET ?
               WHERE personallog.article_titlepage.id_article_titlepage = ?`
               
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}
//[根據type_article_titlepage抓article_titlepage]
module.exports.GetDB_Article_TitlePage = async function(arry){
    var cmd = "SELECT * FROM article_titlepage WHERE type_article_titlepage =  ?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}
//[根據type_article_titlepage條件合併dropdown_list和article_titlepage]
module.exports.GetDB_Article_TitlePage_JOIN_Dropdown_List =  function(arry){
    var cmd =   `SELECT personallog.article_titlepage.*,personallog.dropdown_list.Name
                FROM personallog.dropdown_list
                INNER JOIN personallog.article_titlepage
                ON personallog.dropdown_list.idDropDown_list = personallog.article_titlepage.tag_article_titlepage
                WHERE personallog.article_titlepage.type_article_titlepage = ?` 
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}
//[不依條件合併dropdown_list和article_titlepage]
module.exports.GetDB_Article_TitlePage_JOIN_Dropdown_List_NoWHERE =  function(arry){
    var cmd =   `SELECT personallog.article_titlepage.*,personallog.dropdown_list.Name
                FROM personallog.dropdown_list
                INNER JOIN personallog.article_titlepage
                ON personallog.dropdown_list.idDropDown_list = personallog.article_titlepage.tag_article_titlepage` 
let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
return dataList
}
//[根據article_titlepage_id抓文章內容]
module.exports.GetDB_ArticleContent = async function(arry){
    obj={}
    var cmd = "SELECT * FROM article WHERE article_titlepage_id = ?"
    let  dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}

// [JOIN然後抓文章內容]
module.exports.GetDB_ArticleContent_JOIN_Article = function(arry) {
 var cmd =  `SELECT personallog.article.*,personallog.article_titlepage.title_article_titlepage,personallog.article_titlepage.date_article_titlepage,
            personallog.article_titlepage.tag_article_titlepage,personallog.article_titlepage.previewcontent_article_titlepage,personallog.dropdown_list.Name
            FROM personallog.article_titlepage
            INNER JOIN personallog.article
            ON personallog.article.article_titlepage_id = personallog.article_titlepage.id_article_titlepage
            left JOIN personallog.dropdown_list
            ON personallog.article_titlepage.tag_article_titlepage = personallog.dropdown_list.idDropDown_list
            WHERE personallog.article.article_titlepage_id = ?`
    let dataList =  from_ConnectionSouece.ConSql3(cmd,arry)
    return dataList
}