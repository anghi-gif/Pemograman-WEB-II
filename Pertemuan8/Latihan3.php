<?php
function repeat($text, $num = 10)
{
   echo "<ol>";
   for($i = 0; $i < $num; $i++)
   {
      echo "<li>$text</li>";
   }
   echo "</ol>";
}

// dengan 2 parameter
repeat("I'm the best", 15);

// dengan 1 parameter (pakai default)
repeat("You're the man");
?>