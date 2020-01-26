<?php

$tenants=[
    [
        'first'=>'Dillon',
        'last'=>'Lucas',
        'picture'=>'https://scontent-iad3-1.xx.fbcdn.net/v/t1.0-0/c0.0.640.640a/p640x640/72438049_10156761434718284_5237003037335093248_n.jpg?_nc_cat=107&amp;_nc_oc=AQkh9Xq9anB7JAC84JBRpuPk4O6A25cw3uQskBGwNPKG7YcJmU1lQIajZDw6AEyEoYA&amp;_nc_ht=scontent-iad3-1.xx&amp;oh=9c04df335e0564ca2044de694ae00566&amp;oe=5ED1BC8E',
        'aptNum'=>'428',
        'rent'=>995.00,
        'latePayments'=>0,
    ],
    [
        'first'=>'Ethan',
        'last'=>'Howard',
        'picture'=>'https://scontent-iad3-1.xx.fbcdn.net/v/t1.0-1/c0.445.902.902a/73145412_421797671837522_7977558666037428224_o.jpg?_nc_cat=104&amp;_nc_oc=AQlpVBJQHNnKPri_WowFZNQmGzrzuhI0VwAYzAymDGoqa8JIBpMBD5D2r42yTLQixWk&amp;_nc_ht=scontent-iad3-1.xx&amp;oh=01476bf2754b2504e93185ef9a1564c1&amp;oe=5ECDC482',
        'aptNum'=>'123',
        'rent'=>1200.00,
        'latePayments'=>4,
    ],
    [
        'first'=>'Justin',
        'last'=>'Lucas',
        'picture'=>'https://i1.sndcdn.com/avatars-000660764021-idl7o3-t500x500.jpg',
        'aptNum'=>'986',
        'rent'=>699.50,
        'latePayments'=>10,
    ]
   
    
    ];
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>All Tenants</title>
  </head>
  <body>
    <div class="container">
    <h1>All Tenants</h1>
    <?php
    for ($i=0;$i<count($tenants);$i++){
        
        echo '<div class="media">
        <img src="'.$tenants[$i]['picture'].'" class="mr-3"  alt="..." style="max-width:96px">
        <div class="media-body">
          <h5 class="mt-0">'.$tenants[$i]['first'].' '.$tenants[$i]['last'].'</h5>
          <p>Apt. '.$tenants[$i]['aptNum'].'</p>
          <p><a href="detail.php?id='.$i.'">Click to see details</a></p>
        </div>
      </div>';
      echo '<hr>';
    }
    ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>