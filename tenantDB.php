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
        if ($data['dateIn'] != NULL) $data['dateIn'] = $data['dateIn'];
        else $data['dateIn'] = date('Y-m-d');

        if ($data['dateOut'] != NULL) $data['dateOut'] = $data['dateOut'];
        else $data['dateOut'] = 'NULL';

        $sql = 'INSERT INTO '.$table.' ('.$columns.') 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);';

        $insert = $this->pdo->prepare($sql);
        $insert->execute(array($data['first'], $data['last'], $data['picture'], $data['aptNum'], $data['rent'], $data['latePayments'], $data['dateIn'], $data['dateOut']));

    }
    //modify

    public function showCreateForm(){
        ?>
        <form action="create.php" method="POST">
            First: <input name="first" type="text"> Last: <input name="last" type="text"><br><br>
            Link to Photo: <input name="picture" type="text"><br><br>
            Apartment Number: <input name="aptNum" type="text"><br><br>
            Rent: $<input name="rent" type="number" step="0.01"><br><br>
            Number of Late Payments: <input name="latePayments" type="number"><br><br>
            Date In: <input name="dateIn" type="date"><br><br>
            Date Out: <input name="dateOut" type="date"><br><br>
            <button type="submit">Submit</button>
        </form>
    <?php
    }

    public function processCreateForm(){
        $this->create();
        $columns = implode(',', array_keys($_POST));
        if ($_POST['dateIn'] != NULL) $_POST['dateIn'] = $_POST['dateIn'];
        else $_POST['dateIn'] = date('Y-m-d');

        if ($_POST['dateOut'] != NULL) $_POST['dateOut'] = $_POST['dateOut'];
        else $_POST['dateOut'] = 'NULL';

       
        $sql = 'INSERT INTO tenant ('.$columns.', createdBy) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';

        $insert = $this->pdo->prepare($sql);
        $insert->execute(array($_POST['first'], $_POST['last'], $_POST['picture'], $_POST['aptNum'], $_POST['rent'], $_POST['latePayments'], $_POST['dateIn'], $_POST['dateOut'], $_SESSION['uid']));
    }

    public function showEditForm($id){
        $this->create();
        $sql = $this->pdo->prepare('SELECT * FROM tenant WHERE tenantID=?');
        $sql->execute([$id]);
        $tenant=$sql->fetch(PDO::FETCH_ASSOC);        ?>
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
        if ($_POST['dateIn'] != NULL) $_POST['dateIn'] = $_POST['dateIn'];
        else $_POST['dateIn'] = date('Y-m-d');

        if ($_POST['dateOut'] != NULL) $_POST['dateOut'] = $_POST['dateOut'];
        else $_POST['dateOut'] = 'NULL';

        $sql = $this->pdo->prepare('UPDATE tenant 
        SET first=:first, last=:last, picture=:picture, aptNum=:aptNum, rent=:rent, latePayments=:latePayments, dateIn=:dateIn, dateOut=:dateOut
        WHERE tenantID=:id;', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sql->execute(array(':first' => $_POST['first'], ':last' => $_POST['last'], ':picture' => $_POST['picture'], ':aptNum' => $_POST['aptNum'], ':rent' => $_POST['rent'], ':latePayments' => $_POST['latePayments'], ':dateIn' => $_POST['dateIn'], ':dateOut' => $_POST['dateOut'], ':id' => $id));
    }

    public function showPreview(){
        $this->create();
        $results = $this->pdo->query('SELECT * FROM tenant');
        while($record=$results->fetch() ){
            ?>
        <div class="media">
            <img src="<?php if($record['picture'] != '') echo $record['picture']; else echo 'https://adland.tv/sites/all/themes/themag/assets/images/default-user.png'?>" class="mr-3"  alt="..." style="max-width:96px">
            <div class="media-body">
                <h5 class="mt-0"><?=$record['first'].' '.$record['last']?></h5>
                <p>Apt. <?= $record['aptNum']?></p>
                <p><a href="detail.php?id=<?=$record['tenantID']?>">Click to see details</a></p>
            </div>
        </div>
        <hr><?php
        }
    }

    public function showDetail($id){
        $this->create();
        $results = $this->pdo->prepare('SELECT * FROM tenant WHERE tenantID=?');
        $results->execute([$id]);
        $tenant=$results->fetch(PDO::FETCH_ASSOC);
        ?>
        <h1><?= $tenant['first'].' '.$tenant['last'] ?></h1>
        <img src="<?php if($tenant['picture'] != '') echo $tenant['picture']; else echo 'https://adland.tv/sites/all/themes/themag/assets/images/default-user.png'?>" style="max-width:500px" />
        <p>Apartment Number: <?= $tenant['aptNum'] ?></p>
        <p> Rent: $<?= $tenant['rent'] ?></p>
        <p> Date In: <?= $tenant['dateIn'] ?></p>
        <p> Date Out: <?php if($tenant['dateOut'] == '0000-00-00') echo 'N/A'; else echo $tenant['dateOut']?></p>
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
        if($_SESSION['uid'] == $tenant['createdBy'] || $_SESSION['uid'] == 'admin' || $_SESSION['uid'] == 'manager') echo '<p><a href="modify.php?id='.$id.'">Edit</a></p>';
        if($_SESSION['uid'] == $tenant['createdBy'] || $_SESSION['uid'] == 'admin' || $_SESSION['uid'] == 'manager') echo '<p><a href="delete.php?id='.$id.'" style="color:red">Delete</a></p>'
        ?> </p>
        <?php
    }

    public function delete($id){
        $this->create();
        $sql = 'DELETE FROM tenant 
        WHERE tenantID=?;';

        $delete = $this->pdo->prepare($sql);
        $delete->execute([$id]);
    }
}


?>