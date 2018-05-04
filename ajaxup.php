<?php

header('Content-Type: application/json');
include("pass.php");

try {
    $dbh = new PDO($host, $user, $passwd);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


function update(){
       		global $dbh;
                if( isset($_POST['setTime'], $_POST['user'], $_POST['setMsg'], $_POST['setColor']) ){
                    
                    $sth = $dbh->prepare('insert into chat(data, user, msg, exist) values(:data, :user, :msg, :color);');
                    $sth->bindValue(':data', $_POST['setTime'], PDO::PARAM_STR);
                    $sth->bindValue(':user', $_POST['user'], PDO::PARAM_STR);
                    $sth->bindValue(':msg', $_POST['setMsg'], PDO::PARAM_STR);
                    $sth->bindValue(':color', $_POST['setColor'], PDO::PARAM_STR);
                    $sth->execute();
                    
                }
                
}


function countTime($strTime, $strTime2){
		
	$ar = explode(' ', $strTime);
	$arH = explode(':', $ar[1]);
	$arR = explode('-', $ar[0]);

	$time1 = mktime ($arH[0] , $arH[1] , $arH[2] , $arR[1] , $arR[2] , $arR[0]);


	$arr = explode(' ', $strTime2);
	$arrH = explode(':', $arr[1]);
	$arrR = explode('-', $arr[0]);

	$time2 = mktime ($arrH[0] , $arrH[1] , $arrH[2] , $arrR[1] , $arrR[2] , $arrR[0]);

	$diff = $time2 - $time1;
        return $diff;
}


function clearBase(){
       		global $dbh;
                if( isset($_POST['clear']) ){
                    
                    $today = date("Y-m-d H:i:s"); 
                    
                    $sthh = $dbh->prepare('SELECT * FROM chat');
                    $sthh->execute();
                    $result = $sthh->fetchAll();
                    
                    for($i = 0; $i < count($result); $i++){  
                        
                        if(countTime($result[$i]['time'], $today) > 7200){                                 
                            $clear = $dbh->prepare('DELETE FROM chat WHERE ID=:del');
                            $clear->bindValue(':del', $result[$i]['ID'], PDO::PARAM_STR);
                            $clear->execute();
                        }
                        
                    }
                    
                    
                }
                
}

if(!empty($_POST)){
	update();
        clearBase();
}

?>