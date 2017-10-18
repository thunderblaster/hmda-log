function getUserName() {
 var wshNetwork = new ActiveXObject("WScript.Network");
 var userName = wshNetwork.UserName; 
 return userName;
}
 
function getAD(userName) {
 //var name = userName.split(".");
 objConnection = new ActiveXObject("ADODB.Connection");
 objConnection.Provider="ADsDSOObject";
 objConnection.Open("ADs Provider");
 objCommand = new ActiveXObject("ADODB.Command");
 objCommand.ActiveConnection = objConnection;
 
 //SET LDAP DATA HERE!
 objCommand.CommandText = "SELECT sAMAccountName, givenName, SN, mail FROM 'LDAP://domain.local/OU=organizational unit,' WHERE objectCategory='user' and sAMAccountName = '"+userName+"'";
 
 /* Next up is the command itself.*/
 objRecordSet = objCommand.Execute();
 
 /* Then we execute the command */
 /* Once executed, the command will return an enumeration of the results.*/
 
 var userMail,lastName,firstName;
 if (objRecordSet.RecordCount == 1) {
  objRecordSet.Movefirst;  
  userMail = objRecordSet.Fields("mail").value;
  firstName = objRecordSet.Fields("givenName").value;
  lastName = objRecordSet.Fields("SN").value;
 }
 else
 {  
  userMail = "";
  firstName = "";
  lastName = "";
 }
 objConnection.Close;
 
 return userMail+";"+firstName+";"+lastName;
}
 
var AD = getAD(getUserName()).split(";");
 
var mail = AD[0];
var firstName = AD[1];
var lastName = AD[2];