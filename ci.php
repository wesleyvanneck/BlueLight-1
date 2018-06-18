<?php
$time = time();
$port = rand(1000,60000);
while(system("/usr/sbin/lsof -i:".$port) != null){
	$port = rand(1000,60000);
}
echo "php: ".PHP_VERSION.PHP_EOL;
echo "port is ".$port.PHP_EOL;
system("echo \"server-port=".$port."\" > server.properties");
system("echo \"DevTools=on\" > bluelight.properties");
$server = proc_open(PHP_BINARY . " src/pocketmine/PocketMine.php --no-wizard --disable-readline --settings.enable-dev-builds=1", [
	0 => ["pipe", "r"],
	1 => ["pipe", "w"],
	2 => ["pipe", "w"]
], $pipes);
fwrite($pipes[0], "version\nmakeserver\nstop\n\n");
while(!feof($pipes[1]) and time()-$time<60*3){
	echo fgets($pipes[1]);
}
fclose($pipes[0]);
fclose($pipes[1]);
fclose($pipes[2]);
echo "\n\nReturn value: ". proc_close($server) ."\n";
if(count(glob("plugin_data/DevTools/*.phar")) === 0){
	echo "No server phar created!\n";
	exit(1);
}else{
	echo "Server phar created!\n";
	exit(0);
}
