
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






































<?php
    //search in json by key and value
    function searchJSON($value){
        $results = array();
        $decoded = json_decode($GLOBALS['json_data'], true);
        foreach($decoded as $item){
            if( 
                $item->userId == $value ||
                strpos($item->title, $value) ||
                strpos($item->body, $value)
            ){
                $results[] = $item;
            }
        }
        $results = json_encode($results, JSON_PRETTY_PRINT);
        return $results;
    }
?>



<?php
    //sort json data by id or userId
    function sortJSON($value = 'id', $sortType = 'nr'){ //'nr' stands for 'not reversed',    'r' stands for 'reversed'
            //sort data
        $decoded = json_decode($GLOBALS['json_data'], true);
        
        if($value == 'id'){
            if($sortType == 'r'){
                usort($decoded, function ($a, $b) {
                    return $b['id'] - $a['id'];
                });
            }elseif($sortType == 'nr'){
                usort($decoded, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });
            }
            $decoded = json_encode($decoded, JSON_PRETTY_PRINT);
            return $decoded;
        }elseif($value == 'userId'){
            if($sortType == 'r'){
                usort($decoded, function ($a, $b) {
                    return $b['userId'] - $a['userId'];
                });
            }elseif($sortType == 'nr'){
                usort($decoded, function ($a, $b) {
                    return $a['userId'] - $b['userId'];
                });
            }
            $decoded = json_encode($decoded, JSON_PRETTY_PRINT);
            return $decoded;
        }else{
        echo "Cannot sort data by this property.";
        }
    }
?>