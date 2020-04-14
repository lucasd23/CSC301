<?php
class userOps {
    public function signIn(){
        require_once('FileUtility.php');
        if (!file_exists('userAccounts.csv')) die('This email is not associated with an account');
        else{
            $_POST['email']=strtolower($_POST['email']);
            $verified=false;
            for ($index=0;FileUtility::readCSV('userAccounts.csv',$index) != null && $verified==false;$index++){
                $line = FileUtility::readCSV('userAccounts.csv',$index);
                if ($line[0] == $_POST['email']){
                    $verified = true;
                    if (!password_verify(trim($_POST['password']), trim($line[1]))) die('Incorrect Password'.var_dump($line[1]));
                    $_SESSION['uid'] = 1;
                    header('Location: index.php');

                }
             
            }
            die('This email is not associated with an account');
        }
    }

    public function signUp(){
        require_once('FileUtility.php');
        $_POST['email']=strtolower($_POST['email']);
        $_POST['password']=password_hash($_POST['password'], PASSWORD_BCRYPT);
        if (!file_exists('userAccounts.csv')) FileUtility::writeCSV('userAccounts.csv', $_POST);
        else{
            for ($index=0;FileUtility::readCSV('userAccounts.csv',$index) != null;$index++){
                $line = FileUtility::readCSV('userAccounts.csv',$index);
                if ($line[0] == $_POST['email']) die('This email is already associated with an account');
            }
            FileUtility::writeCSV('userAccounts.csv', $_POST);
        }
    }

    public function signOut(){
        session_destroy();
        header('location: index.php');
        
    }
}

?>