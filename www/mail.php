<?php
function get_data($smtp_conn)
{
    $data="";
    while($str = fgets($smtp_conn,515))
    {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    }
    return $data;
}
//$dat = json_decode($_POST['data']);
$name  = substr($_POST ['name'], 0, 64 );
$lastname = substr($_POST['lastname'],0,64);
$email = substr($_POST['email'], 0,64);
$mess = substr($_POST['mess'], 0,250);
$mail = $_POST['mail'];

if (!empty($mail))
{
    echo '��� �� ��!!';
}
else
{

if(!empty($_POST['email'])) 
        { 
           if(preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['email'])) 
           { 
              //���������� ����
                $header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
                $header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($name." ".$lastname)))."?= <pavel.m89@bk.ru>\r\n";
                $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
                $header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('���')))."?= <pavel.m89@bk.ru>\r\n";
                $header.="X-Priority: 3 (Normal)\r\n";
                $header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
                $header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('�����')))."?= <poligot89@gmail.com>\r\n";
                $header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('� �������')))."?=\r\n";
                $header.="MIME-Version: 1.0\r\n";
                $header.="Content-Type: text/plain; charset=windows-1251\r\n";
                $header.="Content-Transfer-Encoding: 8bit\r\n";

                $smtp_conn = fsockopen("smtp.mail.ru", 25,$errno, $errstr, 10);
                if(!$smtp_conn) {print "���������� � �������� �� ������"; fclose($smtp_conn); exit;}
                $data = get_data($smtp_conn);
                fputs($smtp_conn,"EHLO mail\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 250) {print "������ ���������� EHLO"; fclose($smtp_conn); exit;}
                fputs($smtp_conn,"AUTH LOGIN\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 334) {print "������ �� �������� ������ �����������"; fclose($smtp_conn); exit;}

                fputs($smtp_conn,base64_encode("pavel.m89@bk.ru")."\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 334) {print "������ ������� � ������ �����"; fclose($smtp_conn); exit;}


                fputs($smtp_conn,base64_encode("poligot1989")."\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 235) {print "�� ���������� ������"; fclose($smtp_conn); exit;}

                $size_msg=strlen($header."\r\n".$mess);

                fputs($smtp_conn,"MAIL FROM:<pavel.m89@bk.ru> SIZE=".$size_msg."\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 250) {print "������ ������� � ������� MAIL FROM"; fclose($smtp_conn); exit;}

                fputs($smtp_conn,"RCPT TO:<pavel.m89@bk.ru>\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 250 AND $code != 251) {print "������ �� ������ ������� RCPT TO"; fclose($smtp_conn); exit;}

                fputs($smtp_conn,"DATA\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 354) {print "������ �� ������ DATA"; fclose($smtp_conn); exit;}

                fputs($smtp_conn,$header."\r\n".$mess." ".$email."\r\n.\r\n");
                $code = substr(get_data($smtp_conn),0,3);
                if($code != 250) {print "������ �������� ������"; fclose($smtp_conn); exit;}

                fputs($smtp_conn,"QUIT\r\n");
                fclose($smtp_conn);

                header("Refresh:3; http://mas-pavel.no-ip.org/");
                echo '�������, ���� ��������� ���� �����������';
                exit;
           } 
           else 
           { 
              header('Refresh: 5; URL=http://mas-pavel.no-ip.org/feedback.html');
              echo $_POST['email']. "---"." ���� ���� �� �������� ���������� .";
           } 
        } 
        else 
        { 
            header('Refresh: 5; URL=http://mas-pavel.no-ip.org/feedback.html');
            echo "�� �� ����� email.";     
        } 

}


?>