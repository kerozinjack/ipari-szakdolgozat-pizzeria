<?php
    class Regisztracio extends Adatbazis{
        public function regisztral($nev, $felhasznalo, $email, $jelszo, $mjelszo){
            // $nev = stri($nev, ENT_QUOTES, 'UTF-8');
            // $felhasznalo = htmlentities($felhasznalo, ENT_QUOTES, 'UTF-8');
            // $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
            // $jelszo = htmlentities($jelszo, ENT_QUOTES, 'UTF-8');
            // $mjelszo = htmlentities($mjelszo, ENT_QUOTES, 'UTF-8');

            $nev = strip_tags($nev);
            $felhasznalo = strip_tags($felhasznalo);
            $email = strip_tags($email);
         

            
            $muvelet = "SELECT * FROM `users` WHERE `username`=? OR `email`=?";
            // var_dump($muvelet);

            $paramArr = array($felhasznalo, $email);
            // var_dump($paramArr);
            $ismetlodes = Adatbazis::adatLekeresParam($muvelet, $paramArr);
            
            

            if($ismetlodes['valasz'] != "Nincs találat!"){
                return 0; 
            } else {
                if($jelszo == $mjelszo){
                    $hasheltjelszo = password_hash($jelszo, PASSWORD_DEFAULT);
                    
                    $muveletInsert = "INSERT INTO `users`(`name`, `username`, `email`, `password`) VALUES(?,?,?,?)";
                    $paramArrInsert = array($nev,$felhasznalo,$email,$hasheltjelszo);
                    $vegrehajtas = Adatbazis::adatValtoztatasParam($muveletInsert, $paramArrInsert);
                    
                    if($vegrehajtas['valasz'] == 'Sikeres művelet!'){
                        return 1;
                    } else {
                        return -2; 
                    }
                } else {
                    return -1; 
                }    
            }
        }
    }
    
    class Bejelentkezes extends Adatbazis{
        public $id;
        public function bejelentkez($felhasznalo_v_email, $jelszo){
            $muvelet = "SELECT * FROM `users` WHERE `username`=? OR `email`=?";
            $paramArr = array($felhasznalo_v_email, $felhasznalo_v_email);
            $letezo = Adatbazis::adatLekeresParam($muvelet, $paramArr);
            // var_dump($letezo);
            if(!isset($letezo['valasz'])){
                $hasheltJelszo = $letezo[0]["password"];
                if(password_verify($jelszo, $hasheltJelszo)){
                    $this->id = $letezo[0]["id"];
                    $_SESSION["id"] = $letezo[0]["id"];
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return -1;
            }
        }
    
        public function felhasznaloId(){
            return $this->id;
        }
    }
    

    class Felhasznalo extends Adatbazis{
        public function felhasznalo_kivalasztasa($id){
            $muvelet="SELECT * FROM `users` WHERE `id`=?";
            $paramArr=array($id);
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }

        public function felhasznalo_adatmodositas($m_nev, $m_felhnev, $m_email, $id){

            $nev = strip_tags($m_nev);
            $felhasznalo = strip_tags($m_felhnev);
            $email = strip_tags($m_email);

            
            $ell_1 = "SELECT * FROM `users` WHERE `username`=? AND `id` <> ?";
            $ell_2 = "SELECT * FROM `users` WHERE `email`=? AND `id` <> ?";

            $ell_1_paramArr = array($felhasznalo, $id);
            $ell_2_paramArr = array($email, $id);
            
            // var_dump($paramArr);
            $ismetlodes_ell1 = Adatbazis::adatLekeresParam($ell_1, $ell_1_paramArr);
            $ismetlodes_ell2 = Adatbazis::adatLekeresParam($ell_2, $ell_2_paramArr);
            
            

            if($ismetlodes_ell1['valasz'] != "Nincs találat!")
                return 0;
            if($ismetlodes_ell2['valasz'] != "Nincs találat!")
                return 1; 
            if($ismetlodes_ell1['valasz'] == "Nincs találat!" && $ismetlodes_ell2['valasz'] == "Nincs találat!"){
                $muvelet_rendelesek = "UPDATE `rendelesek` SET `nev`=? WHERE `email`=?";
                $paramArr_rendelesek = array($nev, $email);
                Adatbazis::adatValtoztatasParam($muvelet_rendelesek, $paramArr_rendelesek);
    
                $muvelet = "UPDATE `users` SET `name`=?, `username`=?, `email`=? WHERE `users`.`id`=?";
                $paramArr = array($nev, $felhasznalo, $email, $id);
                
                return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
            }
        }

        public function felhasznalo_jelszomodositas($m_regi,$m_uj,$m_mjelszo,$id){
            $sql_get_password = "SELECT * FROM `users` WHERE `id` = ?";
            $get_password_paramArr = array($id);
            $result = Adatbazis::adatLekeresParam($sql_get_password, $get_password_paramArr);

            if (!isset($result['valasz'])) {

                $old_hash = $result[0]['password'];

                if (password_verify($m_regi, $old_hash)) {
                    if ($m_uj == $m_mjelszo) {
                        $sql_jelszomodosit = "UPDATE `users` SET `password` = ? WHERE `id` = ?";

                        $new_hash = password_hash($m_uj, PASSWORD_DEFAULT);
                        $jelszomodosit_paramArr = array($new_hash, $id);
                        return Adatbazis::adatValtoztatasParam($sql_jelszomodosit, $jelszomodosit_paramArr);
                    } else {

                        return 1;
                    }
                } else {

                    return 2;
                }
            } else {

                return 0;
            }
        }
    }

    class CRUD extends Adatbazis{
        public function kategoria_lekerdezes($kategoria){
            if (isset($_GET['rendezesszerint'])) {
                $sort_by = $_GET['rendezesszerint'];
            } else {
                $sort_by = 'termek_nev_az';
            }
            switch ($sort_by) {
                case 'termek_nev_az':
                    $order_by = 'termek_nev';
                    $order = 'ASC';
                    break;
                case 'termek_nev_za':
                    $order_by = 'termek_nev';
                    $order = 'DESC';
                    break;
                case 'termek_ar_asc':
                    $order_by = 'termek_ar';
                    $order = 'ASC';
                    break;
                case 'termek_ar_desc':
                    $order_by = 'termek_ar';
                    $order = 'DESC';
                    break;
                case 'termek_id_asc':
                    $order_by = 'id';
                    $order = 'ASC';
                    break;
                case 'termek_id_desc':
                    $order_by = 'id';
                    $order = 'DESC';
                    break;
                default:
                    $order_by = 'termek_nev';
                    $order = 'ASC';
                    break;
            }
            if ($kategoria === 'all') {
                $muvelet = "SELECT * FROM `termekek` ORDER BY id ASC";
                return Adatbazis::adatLekeres($muvelet);
            }
            $paramArr=array($kategoria);
            $muvelet = "SELECT * FROM `termekek` WHERE `termek_kategoria`=? ORDER BY $order_by $order";
            return Adatbazis::adatLekeresParam($muvelet,$paramArr);
        }
        public function ujdonsagok(){
            $muvelet="SELECT * FROM termekek WHERE termek_kategoria IN ('pizza', 'tal', 'frissensult', 'hamburger', 'ontet') AND (termek_kategoria, id) IN (SELECT termek_kategoria, MAX(id) FROM termekek WHERE termek_kategoria IN ('pizza', 'tal', 'frissensult', 'hamburger', 'ontet') GROUP BY termek_kategoria)";
            return Adatbazis::adatLekeres($muvelet);
        }

        public function termek_feltoltes($nev, $ar, $kategoria, $leiras, $kepurl){
            $paramArr = array($nev, $ar, $kategoria, $leiras, $kepurl);
            $muvelet = "INSERT INTO `termekek`(`termek_nev`,`termek_ar`,`termek_kategoria`,`termek_leiras`,`termek_kepurl`) VALUES (?, ?, ?, ?, ?)";
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function modositando_termek_id($id){
            $muvelet = "SELECT * FROM `termekek` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }
        
        public function termek_modositas($id, $nev, $ar, $kategoria, $leiras, $kepurl){
            $muvelet = "UPDATE `termekek` SET `termek_nev`=?, `termek_ar`=?, `termek_kategoria`=?, `termek_leiras`=?, `termek_kepurl`=? WHERE `id`=?";
            $paramArr = array($nev, $ar, $kategoria, $leiras, $kepurl, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        public function termek_kategoria_mod($id, $val){
            $muvelet = "UPDATE `termekek` SET `termek_kategoria` = ? WHERE `termekek`.`id` = ?";
            $paramArr = array($val, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        public function termek_torles($id){
            $muvelet = "DELETE FROM `termekek` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function felhasznalok_lekerdezes($mennyit, $adminokat){
            if($adminokat == 0){
                $muvelet = "SELECT * FROM `users` WHERE `admin`=0 LIMIT ?";
                $paramArr = array($mennyit);
                return Adatbazis::adatLekeresParam($muvelet, $paramArr);
            } else {
                $muvelet = "SELECT * FROM `users` WHERE `admin`=1 LIMIT ?";
                $paramArr = array($mennyit);
                return Adatbazis::adatLekeresParam($muvelet, $paramArr);
            }
        }
        
        public function felhasznalo_torles($id){
            $muvelet = "DELETE FROM `users` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function modositando_felhasznalo_id($id){
            $muvelet = "SELECT * FROM `users` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }
        
        public function felhasznalo_modositas($m_nev, $m_felhnev, $m_email, $m_admin, $id){
            $muvelet = "UPDATE `users` SET `name`=?, `username`=?, `email`=?, `admin`=? WHERE `users`.`id`=?";
            $paramArr = array($m_nev, $m_felhnev, $m_email, $m_admin, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function admin_jogok_mod($id, $val){
            $muvelet = "UPDATE `users` SET `admin` = ? WHERE `users`.`id` = ?";
            $paramArr = array($val, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }

        public function rendeles_leadas($nev, $email, $tel, $szcim, $termekek, $vegosszeg){
            $muvelet = "INSERT INTO rendelesek(`nev`, `email`, `telefonszam`, `sz_cim`, `termekek`, `vegosszeg`) VALUES (?, ?, ?, ?, ?, ?)";
            $paramArr = array($nev, $email, $tel, $szcim, $termekek, $vegosszeg);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function rendelesek_lekerdezes($top_mennyit, $fizetetteket){
            if($fizetetteket != 1){
                $muvelet = "SELECT * FROM `rendelesek` WHERE `fizetve`=0 ORDER BY `rendeles_datuma` ASC LIMIT ?";
            } else {
                $muvelet = "SELECT * FROM `rendelesek` WHERE `fizetve`=1 ORDER BY `rendeles_datuma` ASC LIMIT ?";
            }
            $paramArr = array($top_mennyit);
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }
        public function rendeles_fizetve_mod($id, $val){
            $muvelet = "UPDATE `rendelesek` SET `fizetve` = ? WHERE `rendelesek`.`id` = ?";
            $paramArr = array($val, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function modositando_rendeles_id($id){
            $muvelet = "SELECT * FROM `rendelesek` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }
        
        public function rendeles_modositas($m_nev, $m_email, $m_tel, $m_szcim, $m_termekek, $m_vegosszeg, $m_fizetve, $id){
            $muvelet = "UPDATE `rendelesek` SET `nev` = ? , `email` = ? , `telefonszam` = ? , `sz_cim` = ? , `termekek` = ? , `vegosszeg` = ? , `fizetve` = ? WHERE `rendelesek`.`id` = ?";
            $paramArr = array($m_nev, $m_email, $m_tel, $m_szcim, $m_termekek, $m_vegosszeg, $m_fizetve, $id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function rendeles_torles($id){
            $muvelet = "DELETE FROM `rendelesek` WHERE id=?";
            $paramArr = array($id);
            return Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
        }
        
        public function user_rendelesei($id){
            $tmp = "SELECT `name` FROM `users` WHERE `id`=?";
            $paramArrTmp = array($id);
            $nev = Adatbazis::adatLekeresParam($tmp, $paramArrTmp);
            $muvelet = "SELECT * FROM `rendelesek` WHERE `nev`=?";
            $paramArr = array($nev[0]['name']);        
            return Adatbazis::adatLekeresParam($muvelet, $paramArr);
        }
        public function hirlevelre_feliratkoz($email){
            $email = trim($email);
            $email = strtolower($email);
        
            $ell = "SELECT `email` FROM `hirlevelesek` WHERE `email` = ?";
            $paramArrEll = array($email);
            $ismetlodes = Adatbazis::adatLekeresParam($ell, $paramArrEll);
        
            if($ismetlodes['valasz'] != "Nincs találat!"){
                return 0;
            }
            else{
                $muvelet = "INSERT INTO `hirlevelesek` (`email`) VALUES (?)";
                $paramArr = array($email);
                $tmp = Adatbazis::adatValtoztatasParam($muvelet, $paramArr);
                return 1;
            }
        }
        
    }



