var http = require('http')
var mysql = require('mysql')
const TX_URL = 'orgelastosvoteapi-env.cbeiddp6hz.us-west-2.elasticbeanstalk.com'
var sql = ''

main()

function main(){
 
 if(!cliCheck()){
  return 
 }

 const postData = processArgv()

 httpPost(postData)

 fetchFromDb(sql)

}


function fetchFromDb(sql){
 
 var con = mysql.createConnection({
  host:"aakxzp9adcaf8w.clvpxuatb622.us-west-2.rds.amazonaws.com",
  user:"dbadmin",
  password:"2yrPdTuULV5w9BVUys29Rin8YJ3nnrRd",
  database:'ebdb'
 });

 con.connect(function(err) {
   if (err) throw err;
   con.query(sql, function (err, result) {
     if (err) throw err;
     console.log("Data From Db : " + JSON.stringify(result) + '\n\n');
  con.end();
   });
 });

}


function cliCheck(){
 if(process.argv.length < 3){
  console.error('\n Error: not enough arguments \n\n example : node auto.js getTopics \n')
  return false
 }
 return true
}  


function processArgv(){
 var api_type = process.argv[2]
 var ret = ''
 switch(api_type){
  case 'getTopics':
  if(process.argv.length < 4){
   console.log(`Not enough argument for api ${api_type} , example : node auto.js getTopics lemon`)
   process.exit(-1)
  }
  var regName = process.argv[3]
  ret = 
  `{
      "Action":"getTopics",
      "Version":"1.0.0",
      "Data":{
         "regName":${regName}
      }
  }`
  sql = 'select * from elastos_members a , elastos_topic b ,elastos_chainblock c where a.user_id = b.user_id and username = "'+regName + '" and c.type = "genTopic" and b.topic_id = c.source and c.sync = 1'
  break
 }
 return ret
}

function httpPost(postData){
 const options = {
   hostname: TX_URL,
   port: 80,
   path: '/v1/'+process.argv[2],
   method: 'POST',
   headers: {
     'Content-Type': 'application/x-www-form-urlencoded',
     'Content-Length': Buffer.byteLength(postData)
   }
 };

 const req = http.request(options, (res) => {
   // console.log(`STATUS: ${res.statusCode}`);
   // console.log(`HEADERS: ${JSON.stringify(res.headers)}`);
   res.setEncoding('utf8');
   var resp = ''
   res.on('data', (chunk) => {
    resp += chunk
   });
   res.on('end', () => {
    console.log('Data From blockchain : ', resp , "\n\nPlease Compare and Check \n\n")
   });
 });

 req.on('error', (e) => {
   console.error(`problem with request: ${e.message}`);
 });
 // write data to request body
 req.write(postData);
 req.end();
}