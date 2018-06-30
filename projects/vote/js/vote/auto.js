var http = require('http')
var mysql = require('mysql')
var colors = require('colors')

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
     console.log(("Data From Db : \n" + JSON.stringify(result,null,2) + '\n\n').yellow);
  con.end();
   });
 });

}


function cliCheck(){
 if(process.argv.length < 3){
  console.error('\n Error: not enough arguments \n\n example : node auto.js getTopics \n'.red)
  return false
 }
 if('--help' === process.argv[2] || 'help' === process.argv[2]){
  console.log(
`
example : 
 get topics by regName : 
  node auto.js getTopics lemon

 get topic options by topic address :
  node auto.js getTopicOpts EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2 
 
 get topic votes by topic address :
  node auto.js getVotesRecords EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2
 
 get topic result by topic address :
  node auto.js getTopicsResult EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2
 
 get registed user :
  node auto.js getRegUsers
`.yellow)
  process.exit(0)
 }
 return true
}  


function processArgv(){
 var api_type = process.argv[2]
 var ret = ''
 switch(api_type){
  case 'getTopics':
   if(process.argv.length < 4){
    console.log(`Not enough argument for api ${api_type} , example : node auto.js getTopics lemon`.red)
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
   sql = 'select b.* from elastos_members a , elastos_topic b ,elastos_chainblock c where a.user_id = b.user_id and username = "'+regName + '" and c.type = "genTopic" and b.topic_id = c.source and c.sync = 1'
   break
  case 'getTopicOpts':
   if(process.argv.length < 4){
    console.log(`Not enough argument for api ${api_type} , example : node auto.js getTopicOpts EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2`.red)
    process.exit(-1)
   }
   var topicAddr = process.argv[3]
   ret = 
   `{
       "Action":"getTopicOpts",
       "Version":"1.0.0",
       "Data":{
          "topicAddr":${topicAddr}       
      }
   }`
   sql = 'select b.* from elastos_topic a , elastos_topic_option b ,elastos_chainblock c where b.topic_id = a.topic_id and topicAddr = "'+topicAddr+'" and c.type = "addTopicOpt" and a.topic_id = c.source and c.sync = 1 '
   break
  case 'getVotesRecords':
   if(process.argv.length < 4){
    console.log(`Not enough argument for api ${api_type} , example : node auto.js getVotesRecords EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2`.red)
    process.exit(-1)
   }
   var topicAddr = process.argv[3]
   ret = 
   `{
       "Action":"getVotesRecords",
       "Version":"1.0.0",
       "Data":{
          "topicAddr":${topicAddr}       
      }
   }`
   sql = 'select b.* from elastos_topic a , elastos_vote b ,elastos_chainblock c where b.topic_id = a.topic_id and topicAddr = "'+topicAddr+'" and c.type = "vote" and b.vote_id = c.source and c.sync = 1 '
   break
  case 'getTopicsResult':
   if(process.argv.length < 4){
    console.log(`Not enough argument for api ${api_type} , example : node auto.js getTopicsResult EKDb9T8hDgT5CwrvxRuoCeKN3WcAKCShB2`.red)
    process.exit(-1)
   }
   var topicAddr = process.argv[3]
   ret = 
   `{
       "Action":"getTopicsResult",
       "Version":"1.0.0",
       "Data":{
          "topicAddr":${topicAddr}       
      }
   }`
   sql = 'select d.* from elastos_topic a , elastos_topic b ,elastos_chainblock c , elastos_topic_option d where b.topic_id = a.topic_id and b.topic_id = d.topic_id and d.is_answer = 1 and a.topicAddr = "'+topicAddr+'" and c.type = "submitTopicResult" and a.topic_id = c.source and c.sync = 1'
   break
  case 'getRegUsers':
   ret = 
   `{
       "Action":"getRegUsers",
       "Version":"1.0.0",
       "Data":{
          "topicAddr":${topicAddr}       
      }
   }`
   sql = 'select a.username from elastos_members a ,elastos_chainblock c where c.type = "userReg" and a.user_id = c.source and c.sync = 1'
   break
  default :
   console.log("\n No such option \n");
   process.exit(-1)
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
    console.log(('\n\nData From blockchain : \n' + JSON.stringify(JSON.parse(resp),null,2)).yellow)
   });
 });

 req.on('error', (e) => {
   console.error(`problem with request: ${e.message}`);
 });
 // write data to request body
 req.write(postData);
 req.end();
}

