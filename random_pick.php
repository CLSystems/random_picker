<?php

// Determine the addresses that will NOT participate
$excludes = [
	'0x4f768587bb7ad033cd7c1ec78f411ffcf1ae6070' => 'PayFlow Deployer',
	'0x0ebcd2e67027936f2a878df1529be65640d36ce3' => 'PanCake Swap',
	'0xca5ce2c1e22bc6077794076a018fdb93e3afadf5' => 'Tokenomics',
	'0x6bbc71be1ef93dcf725e732b841a1a7521470d90' => 'Tokenomics',
	'0x880d5a32e4973ae8178dfd9e04bb4c8185f89af1' => 'Tokenomics',
	'0x12b61b82f441bad5a6e4dd86d74b92e8f15b930b' => 'Contract',
	'0x5ce908a6ffb393e9cb88dd8d6e8594a6a14a0b60' => 'Contract',
	'0x0000000000dba7f30ba877d1d66e5324858b1278' => 'Contract',
	'0x0b28a3051fa2a49ba020c60b2052f530d7d9d01e' => 'Contract',

];

echo 'Reading downloaded CSV file from BscScan...<br/>';
$data = array_map('str_getcsv', file('export-tokenholders-for-contract-0xe3b42852a85d38b18076ab2dd96b0f894cc0636c.csv'));
array_walk($data, function(&$a) use ($data) {
	$a = array_combine($data[0], $a);
});
array_shift($data); // Remove column header

echo 'Got ' . count($data) . ' addresses, removing excluded...<br/>';
foreach ($data as $key => $row)
{
	if (true === in_array($row['HolderAddress'], array_keys($excludes)))
	{
		unset($data[$key]);
	}
}

$count = count($data);
$selected = [];
echo 'Done, have ' . $count . ' addresses for pool...<br/>';
echo 'The winners are:<br/>';

do
{
	$rand = rand(0, $count);
	// Check if available in pool
	$chosen = $data[$rand];
	if (false === empty($chosen))
	{
		$selected[] = $chosen;
		echo $chosen['HolderAddress'] . '<br/>';
		// Remove winner from pool
		unset($data[$rand]);
	}
//	sleep(2);
}
while (count($selected) <= 24); // Stop when array count reaches 25

echo '<pre>';
print_r($selected);
