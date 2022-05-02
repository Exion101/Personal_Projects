<?php
    require("conn.php");
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
        </style>
    </head>
    <body>
        <div class="topnav">

                <a  href="index.php">Home</a>
                <a  href="hoboken.php">Hoboken</a>
                <a  class="active" href="edgewater.php">Edgewater</a>
                <a  href="trenton.php">Trenton</a>
                <a  href="jc.php">Jersey City</a>
                <a  href="wny.php">West New York</a>


        </div>

        <?php
            $query = "SELECT * FROM weather_report WHERE city_name='Edgewater'";
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
                    echo "<td>" . $row["city_name"] . "</td>" ;
                    echo "<td>" . $row["date_recorded"] . "</td>";
                    echo "<td>" . $row["day_night"] . "</td>";
                    echo "<td>" . $row["temp"] ."</td>";
                    echo "<td>" . $row["short_desc"] . "</td>";
                    echo "<td>" . $row["long_desc"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        
        ?>
    </body>
</html>