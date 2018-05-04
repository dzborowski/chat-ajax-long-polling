<?php

// jquery cssemoticons
// slack, asana

header('Content-Type: application/json');
include("pass.php");

try {
    $dbh = new PDO($host, $user, $passwd);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$tabCount;

$sth = $dbh->prepare('SELECT COUNT(*) FROM chat');
$sth->execute();
$sthRes = $sth->fetchAll();
$tabCount = $sthRes[0][0]; 

/*
<- max_id()
-> POST['mid'] != max_id()
*/


$time=time();
while(time() - $time <= 30){

	$sth = $dbh->prepare('SELECT COUNT(*) FROM chat');
        $sth->execute();
        $sthRes = $sth->fetchAll();
        $checkCount = $sthRes[0][0];

    
        if($checkCount != $tabCount){

                    $sthh = $dbh->prepare('SELECT * FROM chat ORDER BY id DESC LIMIT 1');
                    $sthh->execute();
                    $result = $sthh->fetchAll();
                    echo json_encode($result); 
                    
            break;
        }
    
	usleep(1000);
}


        

?>
