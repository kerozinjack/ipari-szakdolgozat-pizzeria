<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

session_start();

class Adatbazis{
    private static $kiszolgalo='localhost';
    private static $felhasznalo='root';
    private static $jelszo='';
    private static $tabla='pizzeria';
    private static $db;

    public static function adatLekeresParam($muvelet, $paramArr){
        self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
        $adatok = "";
        
		if(self::$db->connect_errno == 0){
            $stmt = self::$db->prepare($muvelet);
            
            if($stmt){
                if(!empty($paramArr)){
                    $types = '';
                    foreach($paramArr as $param){
                        if(is_int($param)){
                            $types .= 'i';
                        } elseif(is_float($param)){
                            $types .= 'd';
                        } else {
                            $types .= 's';
                        }
                    }
                    $stmt->bind_param($types, ...$paramArr);
				}
		
                $stmt->execute();
                $eredmeny = $stmt->get_result();
    
                if($eredmeny->num_rows > 0){
                    $adatok = $eredmeny->fetch_all(MYSQLI_ASSOC);
                } else {
                    $adatok = array('valasz' => "Nincs találat!");
                }
    
                $stmt->close();
            } else {
                $adatok = array('valasz' => self::$db->error);
            }
        }else {
            $adatok = array('valasz' => self::$db->connect_error);
        }
    
        return $adatok;
    }
    
    public static function adatLekeres($muvelet){
        self::$db=new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
        if(self::$db->connect_errno==0){
            $eredmeny=self::$db->query($muvelet);
            if(self::$db->errno==0){
                if($eredmeny->num_rows>0){
                    $adatok=$eredmeny->fetch_all(MYSQLI_ASSOC);
                }
                else{
                    $adatok=array('valasz'=>"Nincs találat!");
                }
            }
            else{
                $adatok=array('valasz'=>self::$db->error);
            }
        }
        else{
            $adatok=array('valasz'=>self::$db->connect_error);
        }
        return $adatok;
    }
    
    public static function adatValtoztatasParam($muvelet, $paramArr){
        self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
        $adatok = "";
        
        if (self::$db->connect_errno == 0) {
            $stmt = self::$db->prepare($muvelet);
            
            if ($stmt) {
                $types = '';
                if (!empty($paramArr)) {
                    foreach($paramArr as $param){
                        if(is_int($param)){
                            $types .= 'i';
                        } elseif(is_float($param)){
                            $types .= 'd';
                        } else {
                            $types .= 's';
                        }
                    }
                    $stmt->bind_param($types, ...$paramArr);
                }
    
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {
                    $adatok = array('valasz' => 'Sikeres művelet!');
                } else if ($stmt->affected_rows == 0) {
                    $adatok = array('valasz' => 'Sikertelen művelet');
                }
    
                $stmt->close();

			} else {
				$adatok = array('valasz' => self::$db->error);
			}
        } else {
            $adatok = array('valasz' => self::$db->connect_error);
        }
    
        return $adatok;
    }
}
