var from_ConnectionSouece = require('../../Config/ConnectSource')

//[用title_article_titlepage搜尋文章]
module.exports.SearchDB_Article_Title = async function(arry){
    var cmd =   `SELECT personallog.article_titlepage.*,personallog.dropdown_list.Name
                FROM personallog.dropdown_list
                INNER JOIN personallog.article_titlepage
                ON personallog.dropdown_list.idDropDown_list = personallog.article_titlepage.tag_article_titlepage
                WHERE personallog.article_titlepage.title_article_titlepage  LIKE  ?`
    let dataList = from_ConnectionSouece.ConSql3(cmd,arry)
    return  dataList           
}
//[刪除文章]
module.exports.DeleteDB_Article_Title = async function(arry){
  var cmd =   `update personallog.article_titlepage
               set personallog.article_titlepage.type_article_titlepage = 'Delete'
               WHERE personallog.article_titlepage.id_article_titlepage = ?`
    let dataList = from_ConnectionSouece.ConSql3(cmd,arry)
    return  dataList
}
//[文章按照日期排序]
module.exports.GetTopNewDB_Article_Title = async function(){
    var cmd = `SELECT * FROM personallog.article_titlepage order by date_article_titlepage;`
    let dataList = from_ConnectionSouece.ConSql3(cmd,null)
    return dataList;
}