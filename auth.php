<?php

$secret     = 'TOPSECRET';
$user       = 'viewer@example.com';
$expiration = time() + 3600;

$dataForHash = [
	'user'     => $user,
	'someData' => 'otherData'
];

$hashToken = generateHash($dataForHash, $secret, $expiration);

$redirectTo = 'http://www.ustream.tv/embed/hashlock/pass?hash=' . urlencode($hashToken);

header('Location: ' . $redirectTo);

function generateHash($data, $secret, $expiration)
{
	$hashData = implode('|', $data) . '|' . $expiration . '|' . $secret;
	$hash     = md5($hashData);

	$hashTokenData = array_chunk(
		array_merge(
			$data,
			[
				'hashExpire' => $expiration,
				'hash'       => $hash
			]
		),
		1,
		true
	);

	return json_encode($hashTokenData);
}