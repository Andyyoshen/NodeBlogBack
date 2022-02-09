var mysql = require('mysql');
var address = require('../config/db')
//建立連線
var connection = mysql.createConnection(address);

module.exports.ConSql2 =  function (sql,post, callback) { 
    connection.query(sql,post, function (err, rows, fields) {
        if (err) {
            console.log("錯誤"+err);
            callback(err, null);
            return;
        };
       // console.log(rows)
        callback(rows);
    });
}


module.exports.ConSql3 =  function (sql,post, callback) { 

    return new Promise(function(resolve,reject){
        connection.query(sql,post,function(err,rows,fields){
            if(err){
                reject(err)
            }
            else{
                resolve(rows)
            }
        })
    })
}