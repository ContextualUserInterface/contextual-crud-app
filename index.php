<html>
<head>   
    <link rel="stylesheet" href="styles.css">
</head>    
<body>

<?php

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

$cellindex = 0;

echo("<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"100%\">");

for ($y = 0; $y < 3; $y++)
{
    echo("<tr height=\"33%\">");
    
    for ($x = 0; $x < 3; $x++)
    {
        echo("<td width=\"33%\">");
            echo("<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"100%\">");

            if ($shapecodes[$cellindex] === 0)
            {
                echo("<tr height=\"100%\">");
                    echo("<td width=\"100%\" style=\"background-color: silver;\">");
                        echo("<p/>");
                    echo("</td>");
                echo("</tr>");
            }
            else
            {
                echo("<form action=\"input.php\" method=\"post\">");
                   echo("<tr height=\"75%\">");
                        echo("<td>");
                            echo("<textarea style=\"width: 100%; height: 100%;\" name=\"data\"></textarea>");
                        echo("</td>");
                    echo("</tr>");
                    echo("<tr height=\"25%\">");
                        echo("<td>");
                            echo("<input type=\"hidden\" name=\"shape\" value=\"" . $shapecodes[$cellindex] . "\" />");
                            echo("<input style=\"width: 100%; height: 100%;\" type=\"submit\" value=\"" . $shapenames[$cellindex] . "\" />");
                        echo("</td>");
                   echo("</tr>");
                echo("</form>");
            }
            
            echo("</table>");
        echo("</td>");
        
        $cellindex++;
    }
    
    echo("</tr>");
}

echo("</table>");

?>

</body>    
</html>



