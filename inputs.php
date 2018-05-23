<html>
    <head></head>
    <body>
<?php
function processNode($nodeRowParameter, $con, $depth) 
{
        $depth++;
        
        echo ("<pre>");
        
        for ($deep = 0; $deep < $depth; $deep++)
        {
            echo(" ");
        }
        
        $nodeTypeSQL = "select * from NodeTypes where id = " . $nodeRowParameter[type_id] . ";";
    
        $nodeTypeResults = $con->query($nodeTypeSQL);
    
        while ($nodeTypeRow = mysqli_fetch_array($nodeTypeResults))
        {
            echo("[" . $nodeTypeRow[name] . "] ");
        }

        echo($nodeRowParameter[content] . "</pre>");

        $nodeLinkSQL = "select * from NodeLinks where from_node_id = " . $nodeRowParameter[id] . ";";
    
        $nodeLinkResults = $con->query($nodeLinkSQL);
    
        while ($nodeLinkRow = mysqli_fetch_array($nodeLinkResults))
        {
            $nodeSQL = "select * from Nodes where id = " . $nodeLinkRow[to_node_id] . ";";
        
            $nodeResults = $con->query($nodeSQL);
            
            while ($nodeRecurseRow = mysqli_fetch_array($nodeResults))
            {
                processNode($nodeRecurseRow, $con, $depth);
            }
        }
}
?>

<?php
include 'dbconnect.php';

// Connect to the database
$con = db_connect();

// Check connection
if ($con->connect_error) 
{
    die("Connection failed: " . $con->connect_error);
}

$inputSQL = "select * from Inputs order by id;";

$inputResults = $con->query($inputSQL);

while ($inputROW = mysqli_fetch_array($inputResults))
{
    //echo ("<pre>" . $inputROW[id] . "</pre>");
    
    $nodeSQL = "select * from Nodes where id = " . $inputROW[node_id] . ";";

    $nodeResults = $con->query($nodeSQL);

    while ($nodeRow = mysqli_fetch_array($nodeResults))
    {
                processNode($nodeRow, $con, 0);
    }
}

$con->close();

?>
</body>
</html>
