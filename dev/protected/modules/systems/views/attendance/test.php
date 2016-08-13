<!--[
{ "firstName":"Bill" , "lastName":"Gates" },
{ "firstName":"George" , "lastName":"Bush" },
{ "firstName":"Thomas" , "lastName": "Carter" }
];
-->
<?php
$i = 0;

function Fibonacci($n) {
//echo $n.'：';
    if ($n <= 0) {
        return 0;
    } elseif ($n == 1) {
        return 1;
    } else {
        return Fibonacci($n - 1) + Fibonacci($n - 2);
    }
    // echo '<br/>';
}

//思路
//echo Fibonacci(4); return Fibonacci(3) + Fibonacci(2);
//echo Fibonacci(3); return Fibonacci(2) + Fibonacci(1);
//echo Fibonacci(2); return Fibonacci(1) + Fibonacci(0);
?>