
<?php

require __DIR__.'/vendor/autoload.php'; 

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;


//sqlsrv
$capsule->addConnection([
    'driver'    => 'sqlsrv',
    'host'      => 'XUKIEN-THINK',
    'database'  => 'Northwind',
    'username'  => 'sa',
    'password'  => 'sa1234',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();


/*Demo for connect SQL server DB Northwind*/
/*echo 'Open connect to host sqlsrv (DB=Northwind, table=Employees): <br>';
$Employees = Capsule::table('Employees')->get();
echo "Total select " . count($Employees) . " records.";
echo "<br>";
echo "<table>";
echo "<tr><th>EmployeeID</th><th>FirstName</th><th>LastName</th></tr>";
foreach ($Employees as $item) {
	# code...
	echo "<tr>";

	echo "<td>" . $item->EmployeeID . "</td>";
	echo "<td>" . $item->FirstName . "</td>";
	echo "<td>" . $item->LastName . "</td>";
	
	
	echo "</tr>";
}

echo "</table>";*/

/*Demo for connect SQL server DB Northwind*/
echo 'Open connect to host sqlsrv to call procudure=CustOrderHist(@CustomerID): <br>';
$results = Capsule::select('EXEC CustOrderHist ?', ['QUICK']);
echo "Total select " . count($results) . " records.";
echo "<br>";
echo "<table>";
echo "<tr><th>ProductName</th><th>Total</th></tr>";
foreach ($results as $item) {
	# code...
	echo "<tr>";

	echo "<td>" . $item->ProductName . "</td>";
	echo "<td>" . $item->Total . "</td>";
	
	echo "</tr>";
}

echo "</table>";

echo "<hr>";

/* Turn to mysql*/

//mysql
$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'sakila',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
), 'host_mysql');


/*Demo for connect Mysql DB Sakila*/
echo 'Open connect to host mysql (DB=sakila, table=actor): <br>';
$hostMysql = $capsule->connection('host_mysql');

// do Insert from sqlsrv to mysql
$preDatas = [];
foreach ($Employees as $item) {
	array_push($preDatas, ['first_name' => $item->FirstName, 'last_name' => $item->LastName]);
}

/*
$hostMysql->transaction(function() use ($hostMysql, $preDatas)
{
    $hostMysql->table('actor')->insert($preDatas);
});
echo 'insert success for all ' . count($preDatas) . ' records ! <br>';
*/


// select to check data
$actor = $hostMysql->table('actor')->orderBy('actor_id', 'desc')->get()->take(count($preDatas));
echo "Total select " . count($preDatas) . " records.";
echo "<br>";
echo "<table>";
echo "<tr><th>Id</th><th>First Name</th><th>Last Name</th></tr>";
foreach ($actor->reverse() as $item) {
	# code...
	echo "<tr>";

	echo "<td>" . $item->actor_id . "</td>";
	echo "<td>" . $item->first_name . "</td>";
	echo "<td>" . $item->last_name . "</td>";
	
	echo "</tr>";
}
//var_dump($actor);

echo "</table>";


?>


<br>
---------------------------------END------------------------------------------------
