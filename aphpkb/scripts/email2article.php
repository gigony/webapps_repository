<?php // email2article.php - script to retreive email messages, verify author, submit article, confirm via email to author and set article for approval.
// open an IMAP connection

include"../config/config.php";
include"../config/e2a.config.php";

include "../classes/mysql.class.php";
$mysqldb = new mysql();
$mysqldb->connect();

$mysqldb->select(); 

$query = "SELECT Email FROM authors WHERE Username='admin'";
$mysqldb->query($query);

$row = $mysqldb->fetchObject();
$kbadminemail = $row->Email;

$title = '';
$from = '';
$emailid = '';
$articledata = '';
$authoriddb = '';
$usernamedb = '';
$firstnamedb = '';
$lastnamedb = '';
$emaildb = '';
$emailmd5db = '';
$approveddb = '';
$passwddb = '';
$registrationdatedb = '';

$user = ACCOUNT;
$pswd = PSWD;
$serv = SERVER;

$ms = imap_open("{$serv:143/imap/notls}INBOX", $user, $pswd);

//Retrieve total number of messages
$nummsgs = imap_num_msg($ms);
$messages = imap_fetch_overview($ms, "1:$nummsgs");
//If message not flagged as seen, output info about it
while(list($key,$value) = each($messages)) {
	if ($value->seen == 0) {
		$title = $value->subject;
		$from = $value->from;
		$emailid = $value->uid;
		$articledata = imap_fetchbody($ms, $emailid, 2, FT_UID|FT_PEEK);
		$displaybody = substr($articledata, 0, 154) . '...';
		
$matches = array();
$pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
preg_match($pattern,$from,$matches);
		}
$fromemail = $matches[0];





// Is this email from an author?  Let's find out!

$mysqldb->select(); 

$query = "SELECT * FROM authors WHERE Email='$fromemail' AND Approved='Y'";
$mysqldb->query($query);

$row = $mysqldb->fetchObject();
if($row) {
$authoriddb = $row->AuthorID;
$usernamedb = $row->UserName; 
$firstnamedb = $row->FirstName; 
$lastnamedb = $row->LastName; 
$emaildb = $row->Email; 
$emailmd5db = $row->EmailMD5; 
$approveddb = $row->Approved; 
$passwddb = $row->Passwd; 
$registrationdatedb = $row->RegistrationDate; 

$service = KBNAME;
$url = KBURL;

$mysqldb->select(); 
$query = "INSERT into articles (AuthorID, Title, Articledata, Approved, SubmitDate) VALUES ('$authoriddb', '$title', '$articledata', 'E', NOW())";
$mysqldb->query($query);
$fileid = mysql_insert_id();

$confirm = md5(uniqid(rand(),1));

$mysqldb->select(); 

$query = "UPDATE authors SET EmailMD5=$confirm WHERE AuthorID=$authoriddb";
$mysqldb->query($query);

$confirmurl = $url . 'sea.php?fileid=' . $fileid . '&confirm=' . $confirm;

$confirmation = <<<_CONFIRM
<pre>
Hello $firstnamedb,

Thank you for your submission of '$title' using $service's Email 2 Article feature.

Please use the following link to confirm your submission and save your article on the $service knowledgebase.

<a href="$confirmurl">$confirmurl</a>

Once confirmed, your article will be available on the knowledgebase for further editing and submission.

Regards,

$service knowledgebase admin
$kbadminemail
</pre>
_CONFIRM;

$envelope["from"] = $kbadminemail;
$msgpart["type"] = TYPETEXT;
$msgpart["subtype"] = "plain";
$msgpart["contents.data"] = $confirmation;
$msgbody[1] = $msgpart;
$message = imap_mail_compose($envelope,$msgbody);
#list($msgheader,$msgbody)=preg_split("\r\n\r\n",$message,2);
list($msgheader,$msgbody)=preg_split("/((\r(?!\n))|((?<!\r)\n)|(\r\n))/", $message,2); 
$subject = "Email 2 Article Confirmation for '$title'";
$to = $emaildb;
$result=imap_mail($to,$subject,$msgbody,$msgheader);

echo 'Email Result:' . $result . '<br />';
echo 'To:' . $to;
echo 'Subject:' . $subject;
echo 'Body:' . $msgbody;
echo 'Header: ' . $msgheader;

}
	}
?>