<?php
class tenantDB {
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

    //read
    //write
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        if ($data['dateIn'] != NULL) $data['dateIn'] = '"'.$data['dateIn'].'"';
        else $data['dateIn'] = '"'.date('Y-m-d').'"';

        if ($data['dateOut'] != NULL) $data['dateOut'] = '"'.$data['dateOut'].'"';
        else $data['dateOut'] = 'NULL';

        $sql = 'INSERT INTO '.$table.' ('.$columns.') 
        VALUES ("'.$data['first'].'", "'.$data['last'].'", "'.$data['picture'].'", "'.$data['aptNum'].'", '.$data['rent'].', '.$data['latePayments'].', '.$data['dateIn'].', '.$data['dateOut'].');';

        $this->pdo->query($sql);
    }
    //modify

    public function showCreateForm(){
        ?>
        <form action="create.php" method="POST">
            First: <input name="first" type="text"> Last: <input name="last" type="text"><br>
            Link to Photo: <input name="picture" type="text"><br>
            Apartment Number: <input name="aptNum" type="text"><br>
            Rent: $<input name="rent" type="number" step="0.01"><br>
            Number of Late Payments: <input name="latePayments" type="number"><br>
            Date In: <input name="dateIn" type="date"><br>
            Date Out: <input name="dateOut" type="date"><br>
            <button type="submit">Submit</button>
        </form>
    <?php
    }

    public function processCreateForm(){
        $this->create();
        $columns = implode(',', array_keys($_POST));
        if ($_POST['dateIn'] != NULL) $_POST['dateIn'] = '"'.$_POST['dateIn'].'"';
        else $_POST['dateIn'] = '"'.date('Y-m-d').'"';

        if ($_POST['dateOut'] != NULL) $_POST['dateOut'] = '"'.$_POST['dateOut'].'"';
        else $_POST['dateOut'] = 'NULL';

       
        $sql = 'INSERT INTO tenant ('.$columns.', createdBy) 
        VALUES ("'.$_POST['first'].'", "'.$_POST['last'].'", "'.$_POST['picture'].'", "'.$_POST['aptNum'].'", '.$_POST['rent'].', '.$_POST['latePayments'].', '.$_POST['dateIn'].', '.$_POST['dateOut'].', "'.$_SESSION['uid'].'");';

        $this->pdo->query($sql);
    }

    public function showEditForm($id){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM tenant WHERE tenantID='.$id);
        $tenant=$results->fetch();        ?>
        <form method="POST" action="modify.php?id=<?= $id ?>">
            First: <input name="first" type="text" value="<?= $tenant['first']?>"> Last: <input name="last" type="text"
                value="<?= $tenant['last']?>"><br><br>
            Link to Photo: <input name="picture" type="text" value="<?= $tenant['picture']?>"><br><br>
            Apartment Number: <input name="aptNum" type="text" value="<?= $tenant['aptNum']?>"><br><br>
            Rent: $<input name="rent" type="number" step="0.01" value="<?= $tenant['rent']?>"><br><br>
            Number of Late Payments: <input name="latePayments" type="number" value="<?= $tenant['latePayments']?>"><br><br>
            Date In: <input name="dateIn" type="date" value="<?= $tenant['dateIn']?>"><br>
            Date Out: <input name="dateOut" type="date" value="<?= $tenant['dateOut']?>"><br>
            <button type="submit">Submit</button>
        </form>
        <?php
    }

    public function processEditForm($id){
        $this->create();
        $columns = implode(',', array_keys($_POST));
        if ($_POST['dateIn'] != NULL) $_POST['dateIn'] = '"'.$_POST['dateIn'].'"';
        else $_POST['dateIn'] = '"'.date('Y-m-d').'"';

        if ($_POST['dateOut'] != NULL) $_POST['dateOut'] = '"'.$_POST['dateOut'].'"';
        else $_POST['dateOut'] = 'NULL';

        $sql = 'UPDATE tenant 
        SET first="'.$_POST['first'].'", last="'.$_POST['last'].'", picture="'.$_POST['picture'].'", aptNum="'.$_POST['aptNum'].'", rent='.$_POST['rent'].', latePayments='.$_POST['latePayments'].', dateIn='.$_POST['dateIn'].', dateOut='.$_POST['dateOut'].'
        WHERE tenantID='.$id.';';

        $this->pdo->query($sql);
    }

    public function showPreview(){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM tenant');
        while($record=$results->fetch() ){
            echo 
        '<div class="media">
            <img src="'.$record['picture'].'" class="mr-3"  alt="..." style="max-width:96px">
            <div class="media-body">
                <h5 class="mt-0">'.$record['first'].' '.$record['last'].'</h5>
                <p>Apt. '.$record['aptNum'].'</p>
                <p><a href="detail.php?id='.$record['tenantID'].'">Click to see details</a></p>
            </div>
        </div>';
        echo '<hr>';
        }
    }

    public function showDetail($id){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM tenant WHERE tenantID='.$id);
        $tenant=$results->fetch();
        ?>
        <h1><?= $tenant['first'].' '.$tenant['last'] ?></h1>
        <img src="<?= $tenant['picture'] ?>" style="max-width:500px" />
        <p>Apartment Number: <?= $tenant['aptNum'] ?></p>
        <p> Rent: $<?= $tenant['rent'] ?></p>
        <p>Late Payments: <?php
        if($tenant['latePayments'] < 2){
            echo '<span class="badge badge-success">'.$tenant['latePayments'].'</span>';
        }
        elseif($tenant['latePayments'] < 7){
            echo '<span class="badge badge-warning">'.$tenant['latePayments'].'</span>';
        }
        else{
            echo '<span class="badge badge-danger">'.$tenant['latePayments'].'</span>';
        }
        if($_SESSION['uid'] == $tenant['createdBy'] || $_SESSION['uid'] == 'admin') echo '<p><a href="modify.php?id='.$id.'">Edit</a></p>';
        if($_SESSION['uid'] == $tenant['createdBy'] || $_SESSION['uid'] == 'admin') echo '<p><a href="delete.php?id='.$id.'" style="color:red">Delete</a></p>'
        ?> </p>
        <?php
    }

    public function delete($id){
        $this->create();
        $sql = 'DELETE FROM tenant 
        WHERE tenantID='.$id.';';

        $this->pdo->query($sql);
    }
}


?>