<?php
//session_start();
//if (isset($_POST[submit]))
//{
//$_SESSION[central]= $_POST[data];
//$_SESSION[shape]= $_POST[shape];

// Create connection
$con = new mysqli("localhost","pmaas_ushin_demo_code","redacted", "pmaas_ushin_demo");

// $config = parse_ini_file('../../private/config.ini'); 
// $con = new mysqli("localhost",$config['username'],$config['password'],"pmaas_ushin_demo");



// Check connection
if ($con->connect_error) 
{
    die("Connection failed: " . $con->connect_error);
} 

//$sql="INSERT INTO Inputs (id, node_id) VALUES('$_POST[id]','$_POST[node_id]')";
$sql = "INSERT INTO Nodes (content, type_id) VALUES('$_POST[data]', $_POST[shape])";

if ($con->query($sql) === TRUE) 
{
    $last_node_id = $con->insert_id;
    
    echo "<p>Inserted Node: " . $last_node_id . " content: " . $_POST[data] . "</p>";

    $sql = "INSERT INTO NodeLinks (from_node_id, to_node_id) VALUES($_POST[parent], $last_node_id)";

    if ($con->query($sql) === TRUE) 
    {
        $last_link_id = $con->insert_id;
        
    echo "<p>Inserted NodeLink: " . $last_link_id . " from: " . $_POST[parent] . " to: " . $last_node_id . "</p>";
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} 
else 
{
    echo "Error: " . $sql . "<br>" . $con->error;
}

$shapeLabel = "UNKNOWN";

$inputSQL = "select * from NodeTypes where id = " . $_POST[shape] . ";";

$inputResults = $con->query($inputSQL);

while ($inputROW = mysqli_fetch_array($inputResults))
{
   $shapeLabel = $inputROW[name];    
}

mysql_close($con)
//}
?>
<html>
<head></head>    
<body>
<style>
textarea
{
   color: black;
}

.submit
{
   color: black;
}
</style>

<table width="100%">
    <tr>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="shape" value="3">
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Facts" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="shape" value="2">
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Merits" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                            <input type="hidden" name="shape" value="1">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="People" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                            <input type="hidden" name="shape" value="4">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Thoughts" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="33%">
                 <table width="100%">
                    <tr height="75">
                        <td style="background-color: silver;text-align:center;">
            <p><?php echo $_POST[data];?></p>
                        </td>
                    </tr>
                    <tr height="25">
                        <td style="background-color: yellow;text-align:center;">
            <p><?php echo $shapeLabel;?></p>
                        </td>
                    </tr>
                </table>
       </td>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                            <input type="hidden" name="shape" value="5">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Actions" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                            <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                            <input type="hidden" name="shape" value="6">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Feelings" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                             <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                           <input type="hidden" name="shape" value="7">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Needs" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="33%">
            <form action="child.php" method="post">
                <table width="100%">
                    <tr height="75">
                        <td>
                            <textarea style="width: 100%; height: 100%;" name="data"></textarea>
                             <input type="hidden" name="parent" value="<?php echo $last_node_id;?>">
                           <input type="hidden" name="shape" value="8">
                        </td>
                    </tr>
                    <tr height="25">
                        <td>
                            <input style="width: 100%; height: 100%;" type="submit" value="Topics" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>

</body>    
</html>



