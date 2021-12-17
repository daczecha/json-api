
<?php
    header("Access-Control-Allow-Origin: *"); 
    //connect to database
    $conn = mysqli_connect('localhost', 'daczecha', 'data123', 'json_saved');


    //create array for response
    $response = array();
    //check connection
    //
    if($conn){ //if ok generate json
        
        //get data
        $sql = 'SELECT id,title,body,userId FROM posts';
        $result = mysqli_query($conn, $sql);

        //get info from rows and update to response arrray
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {//iterates through row by row untill no more rows

            $response[$i]['id'] = $row['id'];

            $response[$i]['title'] = $row['title'];
            $response[$i]['body'] = $row['body'];
            $response[$i]['userId'] = $row['userId'];
            
            $i++;
        }
        
        $json_data = json_encode($response);
        echo $json_data;
    }else{//if not show error 
        echo 'Connection error' . mysqli_connect_error();
    }
?>
