var express = require('express');
const fs = require('fs')
var multer  = require('multer')
var upload = multer({ dest: 'temp/' }) //用在formData
var router = express.Router();
var from_DBCtrl_ACCOUNT= require('../Modal/DBCtrl/ACCOUNT')
var from_ApiCtrl_Article_InsertArticleContent = require('../Modal/ApiCtrl/InsertArticleContent')
var from_ApiCtrl_Article_GetDropDownList = require('../Modal/ApiCtrl/GetDropDownList')
var from_LogicFun = require('../Modal/General/LogicFun')
var from_GetArticle_Title_Page = require('../Modal/ApiCtrl/GetArticle_Title_Page')
var from_UpdateArticle_Title_Page = require('../Modal/ApiCtrl/UpdataArticle_Title_Page')
/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});


//[取得今天日期並加密]
router.post('/CryptionTest', async function (req, res, next) {
  let TodayYear = new Date().getFullYear()
  let TodayMonth = new Date().getMonth() + 1
  let TodayDay = new Date().getDate()
  let TodayHour = new Date().getHours()
  let TodayMinutes = new Date().getMinutes()
  let TodayDate_Time = TodayYear + "/" + TodayMonth + "/" + TodayDay + " " + TodayHour + ":" + TodayMinutes
  let Encryption_result = await from_LogicFun.Encryption(TodayDate_Time)
    res.status(201).send({
      Status: true,
      Data: Encryption_result,
      Msg: "sucess"
    })
});

//[解密]
router.post('/DecryptionTest',async  function (req, res, next) {
  try{
  let Decryption_result =  await  from_LogicFun.Decryption(req.body.Token) 
      res.status(201).send({
        mas: "sucess",
        list: Decryption_result
      })
    }
  catch(err){
    res.send({
      mas: "fail",
    })
  }
  
})
//[驗證API是否過期]
router.post('/IsVerifyDateTest', async function (req, res, next) {
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token) 
    res.status(201).send({
      mas: "sucess",
      list: IsVerifyDate_result
    })
})

router.get('/d', async function(req, res, next) {
  var arry = [81,2]
  let getaccount = await from_DBCtrl_ACCOUNT.SelectAccount(arry)
  res.send({
    Status:200,
    Msg:getaccount
  });
});
// [抓文章Tag的選單]
router.post('/GetTag', async function(req, res, next) {
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token) 
  if(IsVerifyDate_result){
    try{
      let GetTag_DropDown_list_result = await from_ApiCtrl_Article_GetDropDownList.GetTag_DropDown_list(req.body.U_data)
      console.log(GetTag_DropDown_list_result)
      if(GetTag_DropDown_list_result!= false){
        res.send({
          Status:true,
          Data:GetTag_DropDown_list_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:200,
          Data:'',
          Msg:'fail'
        });
      }

    }
    catch(err){
      console.log(err)
      res.send({
        Status:505,
        Data:'',
        Msg:'fail'
      })
    }
  }
});
//[抓部落格封面文章]
router.post('/GetArticleTitle', async function(req, res, next) {
  console.log(req.body)
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token) 
  if(IsVerifyDate_result){
    try{
      let Get_Article_TitlePage_result = await from_ApiCtrl_Article_InsertArticleContent.Get_Article_TitlePage(req.body.U_data)
      if(Get_Article_TitlePage_result!= false){
        res.send({
          Status:true,
          Data:Get_Article_TitlePage_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:false,
          Data:'',
          Msg:'fail'
        });
      }

    }
    catch(err){
      console.log(err)
      res.send({
        Status:false,
        Data:'',
        Msg:'fail'
      })
    }
  }
});
//[不一條件抓部落格封面文章]
router.post('/GetArticleTitleNoWhere', async function(req, res, next) {
  console.log(req.body)
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token) 
  if(IsVerifyDate_result){
    try{
      let Get_Article_TitlePage_result = await from_ApiCtrl_Article_InsertArticleContent.Get_Article_TitlePageNoWhere(req.body.U_data)
      if(Get_Article_TitlePage_result!= false){
        res.send({
          Status:true,
          Data:Get_Article_TitlePage_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:false,
          Data:'',
          Msg:'fail'
        });
      }

    }
    catch(err){
      console.log(err)
      res.send({
        Status:false,
        Data:'',
        Msg:'fail'
      })
    }
  }
});
//[新增文章]
router.post('/InsertArticlContent',upload.single('img_article_titlepage'), async function(req, res, next) {
    console.log(req.body)
  //  console.log(req.file)
  try{
  //為了符合格試，把前端傳來的FormData在拼裝一次
  var DTO={
    U_data: {
      content_article:req.body.content_article,
      title_article_titlepage:req.body.title_article_titlepage,
      tag_article_titlepage:req.body.tag_article_titlepage,
      previewcontent_article_titlepage:req.body.previewcontent_article_titlepage,
      img_article_titlepage:req.file.originalname
    },
    Token_data: {
        Token: req.body.Token,
      },
  }
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(DTO.Token_data.Token) 
  if(IsVerifyDate_result){
   
      let InsertArticleContent_result = await from_ApiCtrl_Article_InsertArticleContent.InsertArticleContent(DTO.U_data)
      //return false
      if(InsertArticleContent_result == true){
         fs.readFile(req.file.path, (err, data) => {
          if (err) return console.log(err)
         // 寫入 upload 資料夾
         fs.writeFile(`public/images/${req.file.originalname}`, data, () => {
           console.log("成功")
            //檔案寫入成功後，後續動作...
            res.send({
              Status:true,
              Data:"新增成功",
              Msg:'sucess'
            });
         })
        })
        
      }
       else{
        res.send({
          Status:false,
          Data:"新增失敗",
          Msg:'fail'
        });
       }
      }
    }
    catch(err){
      console.log("大家好")
      console.log(err)
      res.send({
        Status:false,
        Data:'',
        Msg:'fail'
      })
    }
 // }
});
//[更新文章]
router.post('/UpdateArticlContent',upload.single('img_article_titlepage'), async function(req, res, next) {
//  console.log(req.body)
// console.log(req.file)
  //return false
try{
if(req.file != undefined){
  //為了符合格試，把前端傳來的FormData在拼裝一次
  var DTO={
    U_data: {
      id_article_titlepage:req.body.id_article_titlepage,
      content_article:req.body.content_article,
      title_article_titlepage:req.body.title_article_titlepage,
      tag_article_titlepage:req.body.tag_article_titlepage,
      previewcontent_article_titlepage:req.body.previewcontent_article_titlepage,
      img_article_titlepage:req.file.originalname 
    },
    Token_data: {
        Token: req.body.Token,
      },
  }
}
else{
  //為了符合格試，把前端傳來的FormData在拼裝一次
var DTO={
  U_data: {
    id_article_titlepage:req.body.id_article_titlepage,
    content_article:req.body.content_article,
    title_article_titlepage:req.body.title_article_titlepage,
    tag_article_titlepage:req.body.tag_article_titlepage,
    previewcontent_article_titlepage:req.body.previewcontent_article_titlepage,
    //img_article_titlepage:req.file.originalname 暫時
  },
  Token_data: {
      Token: req.body.Token,
    },
}
}

let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(DTO.Token_data.Token) 
if(IsVerifyDate_result){
 
    let UpdateArticleContent_result = await from_ApiCtrl_Article_InsertArticleContent.UpdateArticleContent(DTO.U_data)
    //return false
    if(UpdateArticleContent_result == true){
      if(req.file != undefined){
        fs.readFile(req.file.path, (err, data) => {
        if (err) return console.log(err)
       // 寫入 upload 資料夾
       fs.writeFile(`public/images/${req.file.originalname}`, data, () => {
         console.log("成功一")
          //檔案寫入成功後，後續動作...
       })
      })
    }
    console.log("成功二")
      res.send({
      Status:true,
      Data:"更新成功",
      Msg:'sucess'
    });
    }
     else{
      res.send({
        Status:false,
        Data:"更新失敗",
        Msg:'fail'
      });
     }
    }
  }
  catch(err){
    console.log("大家好")
    console.log(err)
    res.send({
      Status:false,
      Data:'',
      Msg:'fail'
    })
  }
// }
});
//[依id_article_titlepage刪除文章]
router.post('/DeleteArticleTitle',async function(req,res,next){
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token) 
  if(IsVerifyDate_result){
    try{
     let DeleteArticle_TitlePage_result =  await from_UpdateArticle_Title_Page.DeleteArticle_TitlePage(req.body.U_data)
      if(DeleteArticle_TitlePage_result!= false){
        res.send({
          Status:true,
          Data:DeleteArticle_TitlePage_result,
          Msg:'sucess'
        });
      }
    }
    catch(err){
      res.send({
        Status:false,
        Data:'',
        Msg:'fail'
      });
    }
  }
})
//[依title搜尋文章]
router.post('/SearchArticle' , async function(req, res, next){
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token) 
  if(IsVerifyDate_result){
    try{
      let Search_Artitcle_Title_result = await from_GetArticle_Title_Page.Search_Artitcle_Title(req.body.U_data)
      if(Search_Artitcle_Title_result!= false){
        res.send({
          Status:true,
          Data:Search_Artitcle_Title_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:false,
          Data:'',
          Msg:'fail'
        });
      }

    }
    catch(err){
      console.log(err)
      res.send({
        Status:false,
        Data:'',
        Msg:'fail'
      })
    }
  }
})
//[article_titlepage_id抓文章內容]
router.post('/GetArticleContent', async function(req, res, next) {
  console.log("大家好2")
  console.log(req.body)
  console.log("大家好")
  try{
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token)
    if(IsVerifyDate_result){
      let GetArticleContent_result = await from_ApiCtrl_Article_InsertArticleContent.GetArticleContent(req.body.U_data)
      if(GetArticleContent_result != false){
        res.send({
          Status:true,
          Data:GetArticleContent_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:false,
          Data:"",
          Msg:'sucess'
        });
      }
    }
  }
  catch(err){
    console.log(err)
  }
});
//[上傳圖片轉換]
router.post('/TranceLateImage',upload.single('file'),async function(req, res, next) {
  console.log(req.body)
  console.log(req.file)
  if(req.file){
      // 讀傳過來的檔案
    fs.readFile(req.file.path, (err, data) => {
      if (err) return console.log(err)
     // 寫入 upload 資料夾
     fs.writeFile(`public/images/${req.file.originalname}`, data, () => {
       res.send({
         Status:true,
         data:`http://localhost:3000/images/${req.file.originalname}`,
         Msg:'sucess'
       })
       console.log("成功")
        //檔案寫入成功後，後續動作...
     })
    })
  }
  else{
    res.send({
      Status:false,
      data:"",
      Msg:'fail'
    })
    console.log("失敗")
  }
});
//[抓最新前3個文章]
router.post('/GetTopArtitcle_TitleNew', async function(req, res, next) {
  try{
  let IsVerifyDate_result =  await from_LogicFun.IsVerifyDate(req.body.Token_data.Token)
    if(IsVerifyDate_result){
      let GetTopNew_Artitcle_Title_result = await from_GetArticle_Title_Page.GetTopNew_Artitcle_Title()
      if(GetTopNew_Artitcle_Title_result != false){
        res.send({
          Status:true,
          Data:GetTopNew_Artitcle_Title_result,
          Msg:'sucess'
        });
      }
      else{
        res.send({
          Status:false,
          Data:"",
          Msg:'sucess'
        });
      }
    }
  }
  catch(err){
    console.log(err)
    res.send({
      Status:false,
      Data:"",
      Msg:'fail'
    });
    
  }
});
module.exports = router;
