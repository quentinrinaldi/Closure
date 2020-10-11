<?php

function add ($x, $y)
{
    return $x + $y;
}

function add2 ($x, $y, $z, $t, $q)
{
    return $x+$y+$z+$t+$q;
}
function curry ($function, $val)
{
    return function ($x) use ($function, $val)
    {
        return $function($x, $val);
    };
}

function curry_advenced ($function, ...$parameters ) {
    return function (...$otherParameters) use ($function, $parameters)
    {
        return $function (...$parameters, ...$otherParameters,);
    };
}

$incr = curry('add', 1);
echo $incr(4)."\n";

$sum = curry_advenced('add2', 2, 2 );
echo $sum(2, 3, 4)."\n";

function superPipe (array $functions)
{
    $previousReturnType = null;
    foreach ($functions as $function)
    {
        $refFunc = new ReflectionFunction($function);
        if (count($refFunc->getParameters()) != 1)
                throw new Exception("La fonction n'a pas le bon nombre d'argument");

        if ($previousReturnType != null && $refFunc->getParameters()[0]->getType() !=  $previousReturnType) {
          //  if (!\is_sublcass_of ($refFunc->getParameters()[0]->getType(),$previousReturnType))
                throw new Exception("Les types sont incompatibles");
        }
        $previousReturnType = $refFunc->getReturnType();
    }
    return pipe($functions);
}
function pipe (array $functions) {

    if (count($functions) == 1) {
        $function = $functions[0];
        return function ($x) use ($function) {
            return $function($x);
        };
    }
    else {
        $function = array_pop($functions);
        return function ($x) use ($function, $functions)
        {
            return $function(pipe($functions)($x));
        };
    }
}

function double (double $x) :int
{
    return $x * 2;
}

function square (int $x) :int
{
    return $x ** 2;
}

function hello (mixed $x) :string
{
    return "hello $x";
}

//$square_double = pipe(['square', 'double']);
//echo "square_double : ".$square_double(2)."\n";

$square_double2 = superPipe(['square', 'double']);
echo $square_double2(4)."\n";
