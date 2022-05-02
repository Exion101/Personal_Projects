<?php
    require("conn.php");
    
    // get ip address
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $query = "SELECT city FROM settings where ip='$ip'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)>0){
        # there is something in db
        $city = mysqli_fetch_array($result);
        $pref = $city["city"];
    }

    // if submit button is pressed
    if(isset($_POST['SubmitButton'])){
        $pref = $_POST['preferred_city'];
        $query = "SELECT * FROM settings WHERE ip='$ip'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result)>0){
            // results found
            $query = "UPDATE settings SET city='$pref' WHERE ip='$ip'";
            $result = mysqli_query($conn, $query);
        }
        else{
            // no results
            $query = "INSERT INTO settings (city, ip) VALUES ('$pref', '$ip')";
            $result = mysqli_query($conn, $query);
        }
    }




?>

<html>
    <head>
        <title>Weather</title>
        <style>
                body{
                    background-image: url(weather_bg.jpg);
                    background-size: cover;
                }
                /* Add a black background color to the top navigation */
                .topnav {
                background-color: #333;
                overflow: hidden;
                }

                /* Style the links inside the navigation bar */
                .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
                }

                /* Change the color of links on hover */
                .topnav a:hover {
                background-color: #ddd;
                color: black;
                }

                /* Add a color to the active/current link */
                .topnav a.active {
                background-color: #1E90FF;
                color: white;
                }

                .display_table{

                    margin: auto;
                    width: 60%;

                    padding: 10px;
                }
                
                th, td{
                    padding: 15px;
                    text-align: center;
                    border-bottom: 1px solid #1E90FF;
                }

                tr:hover {background-color: #87CEFA;}
                tr{background-color: #f2f2f2;}
                form {
                    box-sizing: border-box;
                    padding: 2rem;
                    border-radius: 1rem;
                    background-color: hsl(0, 0%, 100%);
                    border: 4px solid hsl(0, 0%, 90%);
                    grid-template-columns: 1fr 1fr;
                    gap: 2rem;
                    }
                                    
        </style>
    </head>
    <body>
        <div class="topnav">

                <a class="active" href="#">Home</a>
                <a  href="hoboken.php">Hoboken</a>
                <a  href="edgewater.php">Edgewater</a>
                <a  href="trenton.php">Trenton</a>
                <a  href="jc.php">Jersey City</a>
                <a  href="wny.php">West New York</a>


        </div>

        <?php
            $query = "SELECT * FROM weather_report WHERE city_name='$pref'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)>0){
                echo "<table class='display_table'>";
                echo "<td width='120px'><b>City</b></td>";
                echo "<td width='120px'><b>Date</b></td>";
                echo "<td><b>Day or Night</b></td>";
                echo "<td><b>Temperature</b></td>";
                echo "<td><b>Short Description</b></td>";
                echo "<td><b>Long Description</b></td>";
            
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td width='120px'>" . $row["city_name"] . "</td>" ;
                    echo "<td width='120px'>" . $row["date_recorded"] . "</td>";
                    echo "<td>" . $row["day_night"] . "</td>";
                    echo "<td>" . $row["temp"] ."</td>";
                    echo "<td>" . $row["short_desc"] . "</td>";
                    echo "<td>" . $row["long_desc"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        
        ?>

        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h3>Choose Preferred City</h3>
            <input type="radio" name="preferred_city" id="wny" value="West New York">
            <label for="wny">West New York</label>
            <input type="radio" name="preferred_city" id="jc" value="Jersey City">
            <label for="jc">Jersey City</label>
            <input type="radio" name="preferred_city" id="trenton" value="Trenton">
            <label for="trenton">Trenton</label>
            <input type="radio" name="preferred_city" id="hoboken" value="Hoboken">
            <label for="hoboken">Hoboken</label>
            <input type="radio" name="preferred_city" id="edgewater" value="Edgewater">
            <label for="edgewater">Edgewater</label>
            <input type="submit" value="Submit" name="SubmitButton">
        </form>
    </body>
</html>