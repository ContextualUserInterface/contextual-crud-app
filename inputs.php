<html>
<head>   
    <link rel="stylesheet" href="styles.css">
</head>    
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

$cell_width_ids = array
(
    "w_fact",    "w_merit",  "w_person",
    "w_thought", "w_center", "w_action",
    "w_feeling", "w_need",   "w_topic"
);

$cell_height_ids = array
(
    "h_fact",    "h_merit",  "h_person",
    "h_thought", "h_center", "h_action",
    "h_feeling", "h_need",   "h_topic"
);

$shapecodes = array
(
    3, 2, 1,
    4, 0, 5,
    6, 7, 8
);

$shapenames = array
(
    "Facts",    "Merits", "People",
    "Thoughts", "Center", "Actions",
    "Feelings", "Needs",  "Topics"
);

$shapeclasses = array
(
    "fact",    "merit",  "person",
    "thought", "center", "action",
    "feeling", "need",   "topic"
);

$shapeclasseslinear = array
(
    "",
    "person",
    "merit",  
    "fact",  
    "thought", 
    "action",
    "feeling",
    "need",   
    "topic"
);

if ($_GET['id'])
{
    $inputSQL = "select * from Inputs where id = " . $_GET['id'] . ";";
    
    $inputResults = $con->query($inputSQL);
    
    if ($inputROW = mysqli_fetch_array($inputResults))
    {
        $nodeSQL = "select * from Nodes where id = " . $inputROW[node_id] . ";";
    
        $nodeResults = $con->query($nodeSQL);
    
        if ($nodeRow = mysqli_fetch_array($nodeResults))
        {
            
            $cellindex = 0;
            
            echo("<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"100%\">");
            
            for ($y = 0; $y < 3; $y++)
            {
                echo("<tr height=\"33%\">");
                
                for ($x = 0; $x < 3; $x++)
                {
                    echo("<td width=\"33%\">");
                        echo("<table cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" height=\"100%\">");
            
                        if ($shapecodes[$cellindex] === 0)
                        {
                           echo("<tr height=\"100%\">");
                                echo("<td class=\"" . $shapeclasseslinear[$nodeRow[type_id]] . "\">");
                                    echo("<p>" . $nodeRow[content] . "</p>");
                                echo("</td>");
                            echo("</tr>");
                        }
                        else
                        {
                           echo("<tr height=\"100%\">");
                                echo("<td class=\"" . $shapeclasses[$cellindex] . "\">");
                            
                            $nodeLinkSQL = "select * from NodeLinks where from_node_id = " . $nodeRow[id] . ";";
                        
                            $nodeLinkResults = $con->query($nodeLinkSQL);
                        
                            while ($nodeLinkRow = mysqli_fetch_array($nodeLinkResults))
                            {
                                $nodeSQL = "select * from Nodes where id = " . $nodeLinkRow[to_node_id] . " and type_id = " . $shapecodes[$cellindex] . ";";
                            
                                $nodeResults = $con->query($nodeSQL);
                                
                                if ($nodeRecurseRow = mysqli_fetch_array($nodeResults))
                                {
                                    if (empty(trim($nodeRecurseRow[content])))
                                    {
                                        echo("<p>(empty)</p>");
                                    }
                                    else
                                    {
                                        echo("<p>" . $nodeRecurseRow[content] . "</p>");
                                    }
                                }
                                else
                                {
                                    echo("<p> </p>");
                                }
                            }

                                echo("</td>");
                            echo("</tr>");
                        }
                        
                        echo("</table>");
                    echo("</td>");
                    
                    $cellindex++;
                }
                
                echo("</tr>");
            }
            
            echo("</table>");
        }
    }
}
else
{
    
    $inputSQL = "select * from Inputs order by id;";
    
    $inputResults = $con->query($inputSQL);
    
    while ($inputROW = mysqli_fetch_array($inputResults))
    {
        // echo ("<hr/>");
        
        $nodeSQL = "select * from Nodes where id = " . $inputROW[node_id] . ";";
    
        $nodeResults = $con->query($nodeSQL);
    
        while ($nodeRow = mysqli_fetch_array($nodeResults))
        {
            if (empty($nodeRow[content]) || empty($nodeRow[type_id]))
            {
                echo ("<p> [" . $shapeclasseslinear[$nodeRow[type_id]] . "] <a href=\"http://ushin.net/u-4-u-demo/inputs.php?id=" . $inputROW[id] . "\"> (empty) </a></p>");
            }
            else
            {
                echo ("<p> [" . $shapeclasseslinear[$nodeRow[type_id]] . "] <a href=\"http://ushin.net/u-4-u-demo/inputs.php?id=" . $inputROW[id] . "\"> " . $nodeRow[content] . " </a></p>");
                // processNode($nodeRow, $con, 0);
            }
        }
    }
}

$con->close();

?>
</body>
</html>
