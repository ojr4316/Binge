<?php
$data = json_decode(file_get_contents("php://input"),true) ?? $_POST;

mail('8602005926@vtext.com', 'Website Request', PHP_EOL.'Name:'.$data['name'].PHP_EOL.'Email: '.$data['email'].PHP_EOL."Message: ".$data['message']);

?>
