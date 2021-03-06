<?php

include_once __DIR__ . '/../include.php';
include_once __DIR__ . '/lib_example.php';


//$config = [
//    'host' => 'cluster.clickhouse.dns.com',
//    'port' => '8123',
//    'username' => 'default',
//    'password' => ''
//];
//

// load production config
$config = include_once __DIR__ . '/../../_clickhouse_config_product.php';

// ----------------------------------------------------------------------
$cl = new ClickHouseDB\Cluster($config);
$cl->setScanTimeOut(2.5); // 2500 ms
if (!$cl->isReplicasIsOk())
{
    throw new Exception('Replica state is bad , error='.$cl->getError());
}

echo "Ips:\n";
print_r($cl->getNodes());
echo "getClusterList:\n";
print_r($cl->getClusterList());

//
foreach (['pulse','repikator','sharovara','repikator3x','sharovara3x'] as $name)
{
    echo "-------------------- $name ---------------------------\n";
    print_r($cl->getClusterNodes($name));

    echo "> Count Shard   = ".$cl->getClusterCountShard($name)."\n";
    echo "> Count Replica = ".$cl->getClusterCountReplica($name)."\n";
}
// ----------------------------------------------------------------------
echo "\n----\nEND\n";
// ----------------------------------------------------------------------
