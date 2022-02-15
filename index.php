<!DOCTYPE HTML>
<head>
    <script src="https://kit.fontawesome.com/def66b134a.js" crossorigin="anonymous"></script>
</head>
<body bgcolor="#F4F4F4";>
    <h1>Battery monitoring</h1>
            <?php
                $tempColor = "000000";
                $curColor = "000000";

                $conn = mysqli_connect("127.0.0.1","root","11111111","pbl");
                $sql = "SELECT * FROM info ORDER BY id DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                    $speed = $row['speed'];
                    $current = $row['current'];
                    $now = $row['time'];
                    $temperature = $row['temperature'];
                }
                if($speed >= 4.0){
                    $speed_data = $speed.' km/h (주행 중) ';
                }
                else{
                    $speed_data = $speed.' km/h';
                }
                if(($current>=60)||($current<=1)){
                    $messege = '배터리 전압에 이상이 있습니다!!\n\n현재 위치 : '.$latitude.' N, '.$longitude.' E\n현재 속도 : '.$speed_data;
                    echo "<script>alert('$messege');</script></script><script language='JavaScript'>window.open('https://www.google.com/maps/place/".$latitude."N+".$longitude."E')</script>";
                    $curColor = "FF0000";
                }
                if((int)$temperature>=22){
                    $messege = '배터리 온도가 높습니다!!\n\n현재 위치 : '.$latitude.' N, '.$longitude.' E\n현재 속도 : '.$speed_data;
                    echo "<script>alert('$messege');</script><script language='JavaScript'>window.open('https://www.google.com/maps/place/".$latitude."N+".$longitude."E')</script>";
                    $tempColor = "FF0000";
                }
                echo "<div class ='wrapper'>
                        <div class = 'contentsWrapper'>
                            <div class = 'contents1'>
                                <div class= 'icon1'>
                                    <i class='fas fa-thermometer-full'></i>
                                </div>
                                <div class = 'title1'>    
                                    <h2 style='color:#".$tempColor.";'>Temperature</h2>
                                </div>
                                <div class = 'value1' style='color:#".$tempColor.";'>
                                    ".$temperature." °C
                                </div>
                                    
                            </div>
                            <div class = 'contents2'>
                                <div class= 'icon2'>
                                    <i class='fas fa-bolt'></i>
                                </div>  
                                <div class = 'title2'>   
                                    <h2 style='color:#".$curColor.";'>Curreunt</h2>
                                </div>
                                <div class ='value2' style='color:#".$curColor.";'>
                                    ".$current." mA
                                </div>
                            </div>
                            <div class = 'contents3'>
                                <div class= 'icon3'>
                                    <i class='fas fa-tachometer-alt'></i>
                                </div>  
                                <div class = 'title3'>
                                    <h2>Speed</h2>
                                </div>
                                <div class = 'value3'>
                                    ".$speed."km/h
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class = 'time'>
                            Time : ".$now."
                        </div>
                    </div>";
                
                //echo 'Time : '.$now;
                
                mysqli_close($conn);

                //echo("<meta http-equiv='refresh' content='5'>");
            ?>
            <style>
                h1 {text-align:center;
                    color:#000000;
                    border-bottom:4px solid darksalmon;
                    padding: 10px 10px 10px 10px;
                    font-size: 3.5em;

                }   
                .wrapper{
                    text-align: left;
                    display : flex;
                    justify-content : center;
                    flex-direction: column;
                    align-items: center;
                }
                .contentsWrapper{
                    display : flex;
                    justify-content : center;
                    flex-direction: row;
                    
                    
                }
                .time{
                    text-decoration: underline;
                    padding: 10px 20px 10px 20px;
                    margin : 6px;
                }
                h2{
                    padding: 0px 20px 0px 5px;
                    margin : 2px;
                }
                .contents1{
                    width: 230px; 
                    height: 200px;
                    text-align : left;
                    background-color:#FCFCFC;
                    padding : 10px 10px 10px 10px;
                    border-radius: 10px;
                    margin : 6px;
                    box-shadow: 0px 0px 3px 1px lightgray;
                }
                .contents2{
                    width: 230px; 
                    height: 200px;
                    text-align : left;
                    background-color:#FCFCFC;
                    padding : 10px 10px 10px 10px;
                    border-radius: 10px;
                    margin : 6px;
                    box-shadow: 0px 0px 3px 1px lightgray;
                }
                .contents3{
                    width: 230px; 
                    height: 200px;
                    text-align : left;
                    background-color:#FCFCFC;
                    padding : 10px 10px 10px 10px;
                    border-radius: 10px;
                    margin : 6px;
                    box-shadow: 0px 0px 3px 1px lightgray;
                }
                .title1{

                }
                .icon1{
                    color:#F68181;
                    font-size:50px;
                    text-align:left;
                    padding : 0 0 0 10px;
                }
                .icon2{
                    color:#F68181;
                    font-size:50px;
                    text-align:left;
                    padding : 0 0 0 10px;
                }
                .icon3{
                    color:#F68181;
                    font-size:50px;
                    text-align:left;
                    padding : 0 0 0 10px;
                }
                .value1{
                    text-align : left;
                    padding : 20px 10px 10px 5px;
                    font-size : 3em;
                    font-weight: 700;
                }
                .value2{
                    text-align : left;
                    padding : 20px 10px 10px 5px;
                    font-size : 3em;
                    font-weight: 700;
                }
                .value3{
                    text-align : left;
                    padding : 20px 0px 10px 5px;
                    font-size : 3em;
                    font-weight: 700;
                }
            </style>
</body>
</html>