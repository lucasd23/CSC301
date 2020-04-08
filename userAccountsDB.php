<?php
class userAccount {
    public $pdo;

    public function create()
    {
        $settings=[
            'host'=>'localhost',
            'db'=>'rental',
            'user'=>'admin',
            'pass'=>'admin'
        ];
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $dsn = 'mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4';

        try {
            $this->pdo = new PDO($dsn, $settings['user'], $settings['pass'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

    }

    public function signIn(){
        $this->create();
        try{
            $result = $this->pdo->query('SELECT * FROM useraccounts WHERE email="'.$_POST['email'].'"');
            if ($result->rowCount() < 1) throw new PDOException('no results');
            $result = $result->fetch();

            $_POST['email']=strtolower($_POST['email']);
            //if (!password_verify(trim('dang'), trim('$2y$10$Oe0JvaH36pNLrKUTIvYAW.RQy'))) print('Incorrect Password'.$result['password']);
            if ($_POST['password'] != $result['password']) print('Incorrect Password'.$result['password']);
            else{ 
                $id = explode('@', $_POST['email']);
                $_SESSION['id'] = $id[0];
                header('Location: index.php');
            }

            
             
            
        } catch(PDOException $e) {
            print("This email is not associated with an account.");
        }
    }
    //read
    //write
    public function signUp($table, $data) {
        $user = explode('@', $data['email']);
        if ($user[0] == 'admin') {
            print("This email is already associated with an account.");
            return;
        }
        $this->create();
        $data['email']=strtolower($_POST['email']);
        //$data['password']=password_hash($data['password'], PASSWORD_BCRYPT);
        $sql = 'INSERT INTO '.$table.' VALUES ("'.$data['email'].'", "'.$data['password'].'");';
        try {
            $this->pdo->query($sql);

        } catch(PDOException $e){
            print("This email is already associated with an account.");
        }
    }
    //modify
}


?>