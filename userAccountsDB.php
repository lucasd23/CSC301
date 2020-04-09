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
                if($_SESSION['id'] == 'admin') header('Location: admin.php');
                else header('Location: index.php');
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
    
    public function showPreview(){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM useraccounts');
        while($record=$results->fetch() ){
            echo 
        '<div class="media">
            <div class="media-body">
                <h5 class="mt-0">'.$record['email'].'</h5>
                <p><a href="adminEdit.php?id='.$record['email'].'"><svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="blue" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                </svg></a>
                <a href="adminDelete.php?id='.$record['email'].'"><svg class="bi bi-trash-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z" clip-rule="evenodd"/>
                </svg></a></p>
            </div>
        </div>';
        echo '<hr>';
        }
    }
    public function delete($email){
        $this->create();
        $sql = 'DELETE FROM useraccounts 
        WHERE email="'.$email.'";';

        $this->pdo->query($sql);
    }

    public function showEditForm($id){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM useraccounts WHERE email="'.$id.'"');
        $user=$results->fetch();        ?>
        <form action="adminEdit.php?id=<?=$_GET['id']?>" method="POST">
        Email: <input name="email" type="email" value="<?= $user['email'] ?>" required><br><br>
        Password: <input name="password" type="password" value="<?= $user['password'] ?>" required><br><br>
        <button type="submit">Submit Change</button>
</form>
        <?php
    }

    public function processEditForm($id){
        $this->create();

        $sql = 'UPDATE useraccounts 
        SET email="'.$_POST['email'].'", password="'.$_POST['password'].'"
        WHERE email="'.$id.'";';

        $this->pdo->query($sql);
    }
}


?>