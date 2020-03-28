<?php
class Tenant {
    private $first;
    private $last;
    private $picture;
    private $aptNum;
    private $rent;
    private $latePayments;
    private $dateIn;
    private $dateOut;

    

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
        require_once('FileUtility.php');
        FileUtility::writeJSON('tenants.json',$_POST);
    }

    public function showEditForm($id){
        require_once('FileUtility.php');
        $tenant=FileUtility::readJSON('tenants.json',$id);
        ?>
        <form method="POST" action="modify.php?id=<?= $id ?>">
            First: <input name="first" type="text" value="<?= $tenant['first']?>"> Last: <input name="last" type="text" value="<?= $tenant['last']?>"><br><br>
            Link to Photo: <input name="picture" type="text" value="<?= $tenant['picture']?>"><br><br>
            Apartment Number: <input name="aptNum" type="text" value="<?= $tenant['aptNum']?>"><br><br>
            Rent: $<input name="rent" type="number" step="0.01" value="<?= $tenant['rent']?>"><br><br>
            Number of Late Payments: <input name="latePayments" type="number" value="<?= $tenant['latePayments']?>"><br><br>
            Date In: <input name="dateIn" type="date" value="<?= $tenant['dateIn']?>"><br>
            Date Out: <input name="dateOut" type="date"value="<?= $tenant['dateOut']?>"><br>
            <button type="submit">Submit</button>
        </form>
        <?php
    }

    public function processEditForm($id){
        require_once('FileUtility.php');
        FileUtility::modifyJSON('tenants.json', $id, $_POST);
    }

    public function showPreview($tenant, $id){
        echo '<div class="media">
        <img src="'.$tenant['picture'].'" class="mr-3"  alt="..." style="max-width:96px">
        <div class="media-body">
          <h5 class="mt-0">'.$tenant['first'].' '.$tenant['last'].'</h5>
          <p>Apt. '.$tenant['aptNum'].'</p>
          <p><a href="detail.php?id='.$id.'">Click to see details</a></p>
        </div>
      </div>';
      echo '<hr>';
    }

    public function showDetail($id){
        require_once('FileUtility.php');
        $tenant=FileUtility::readJSON('tenants.json',$id);
        ?>
        <h1><?= $tenant['first'].' '.$tenant['last'] ?></h1>
    <img src="<?= $tenant['picture'] ?>" style="max-width:500px"/>
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
    if(isset($_SESSION['id'])) echo '<p><a href="modify.php?id='.$id.'">Edit</a></p>';
    if(isset($_SESSION['id'])) echo '<p><a href="delete.php?id='.$id.'" style="color:red">Delete</a></p>'
    ?> </p>
    <?php
    }

    public function delete($id){
        require_once('FileUtility.php');
        FileUtility::deleteJSON('tenants.json', $id);
    }

    

    public function setFirst($first) {
        $this->first=$first;
    }

    public function setLast($last) {
        $this->last=$last;
    }

    public function setPicture($picture) {
        $this->picture=$picture;
    }
    public function setAptNum($aptNum) {
        $this->aptNum=$aptNum;
    }

    public function setRent($rent) {
        $this->rent=$rent;
    }

    public function setLatePayments($latePayments) {
        $this->latePayments=$latePayments;
    }

    public function setDateIn($dateIn) {
        $this->dateIn=$dateIn;
    }

    public function setDateOut($dateOut) {
        $this->dateOut=$dateOut;
    }

    public function getFirst() {
        return $this->first;
    }

    public function getLast() {
        return $this->last;
    }

    public function getPicture() {
        return $this->picture;
    }
    public function getAptNum() {
        return $this->aptNum;
    }

    public function getRent() {
        return $this->rent;
    }

    public function getLatePayments() {
        return $this->latePayments;
    }

    public function getDateIn() {
        return $this->dateIn;
    }

    public function getDateOut() {
        return $this->dateOut;
    }

    public function expose(){
        return get_object_vars($this);
    }
}

?>


