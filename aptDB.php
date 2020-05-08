<?php
class aptDB {
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
    
    public function processNewApt($aptNum) {
        $this->create();
        $sql = 'INSERT INTO apartment VALUES (?, ?);';
        try {
            $insert = $this->pdo->prepare($sql);
            $insert->execute([$aptNum, 0]);
            header('Location: adminApts.php');

        } catch(PDOException $e){
            echo '<script>alert("This apartment already exists.")</script>';
            header('Refresh:0');
        }
    }

    public function showNewApt(){?>
        <form action="newApt.php" method="POST">
            Apartment Number: <input name="aptNum" type="text"> 
            <button type="submit">Submit</button>
        </form>
    <?php }
    
    public function showApts(){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM apartment');
            echo 
        '<div class="media">
            <div class="media-body">
            <table class="table">
            <thead>
              <tr>
                <th scope="col">Apartment #</th>
                <th scope="col">Number of Tenants</th>
              </tr>
            </thead>
            <tbody>';
            while($record=$results->fetch() ){
                echo
              '<tr>
                <td>'.$record['aptNum'].'</td>
                <td>'.$record['numTenants'].'</td>
              </tr>';
            } echo
            '</tbody>
          </table>
            </div>
        </div>';
        echo '<hr>';
        
    }
}

?>