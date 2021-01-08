<?php

function age($birthDate)
{
    $from = new DateTime($birthDate);
    $to   = new DateTime('today');
    echo $from->diff($to)->y;
 
}

