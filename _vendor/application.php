<?php
include_once('config.php');
$global = (object)[];
DEFINE('BASE_PATH', dirname(__FILE__).'/');
spl_autoload_register(function ($className) {
    if (substr($className, -5) === 'Model') {
        include_once(dirname(__FILE__).'/model/'.lcfirst(substr($className, 0, -5)).'.php');
    } else if (substr($className, -4) === 'Base') {
        include_once(dirname(__FILE__).'/action/base/'.lcfirst(substr($className, 0, -4)).'.php');
    }
});
register_shutdown_function(function () {
    global $global;
    if (isset($global->db)) {
        $global->db = NULL;
        unset($global->db);
    }
});
function runSystem () {
    global $config;
    header('Content-Type: application/json');
    if (isset($_POST['data'])) {
        $key = pbkdf2('sha1', $config->DECRYPT_CODE, str_repeat("\0", 8), 1000, 24, true);
        $formData = substr($_POST['data'], 0, 5) === 'data=' ? substr($_POST['data'], 5) : $_POST['data'];
        $data = base64_decode($formData);
        $out = trim(mcrypt_decrypt(MCRYPT_3DES, $key, $data, MCRYPT_MODE_ECB));
        $request = preg_replace('/[[:^print:]]/', '', $out);
        $pattern = '/"player_id"\s?:\s?(\d+)/i';
        $replacement = '"player_id":"$1"';
        $request = preg_replace($pattern, $replacement, $request);
        $data = json_decode($request, true);
    } else {
        $request = file_get_contents('php://input');
        $pattern = '/"player_id"\s?:\s?(\d+)/i';
        $replacement = '"player_id":"$1"';
        $request = preg_replace($pattern, $replacement, $request);
        $data = json_decode($request, true);
    }
    $result = [];
    if ($data) {
        $playerId = isset($data['player_id']) ? (string)$data['player_id'] : NULL;
        if (strlen($playerId) >= 16) {
            if (($userData = UserModel::getDataByPlatform(['ACC', $playerId])) !== false) {
                $playerId = $userData->playerId;
            }
        }
    	DEFINE('PLAYER_ID', $playerId);
        for ($i = 0; $i < count($data['actions']); $i++) {
            array_push($result, runApi($data['actions'][$i]['action'], isset($data['actions'][$i]['aparams']) ? $data['actions'][$i]['aparams'] : NULL));
        }
    } else {
        echo json_encode(runApi(NULL, 'session', NULL));
        exit();
    }
    echo json_encode([
        'actions' => $result
    ]);
}
function runApi ($method, $params) {
    $filePath = dirname(__FILE__).'/action/'.$method.'.php';
    if (file_exists($filePath)) {
        include_once($filePath);
        $methodClass = new $method();
        $response = $methodClass->runAction($params);
        if ($method !== 'session') {
            $response->action = $method;
            if (!isset($response->status)) {
                $response->status = 'success';
            }
            $response->status_code = 0;
            $response->success = true;
        }
        return $response;
    } else {
        return (object)[
            'action' => $method,
            'status' => 'error',
            'status_code' => 1,
            'success' => false
        ];
    }
}
function connectDB() {
    global $config, $global;
    if (!isset($global->db)) {
        $global->db = new PDO('sqlite:'.$config->DB_PATH);
    }
    return $global->db;
}
function pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput = false) {
    $algorithm = strtolower($algorithm);
    if (!in_array($algorithm, hash_algos(), true)) {
        trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
     }
    if ($count <= 0 || $keyLength <= 0) {
        trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
    }
    if (function_exists('hash_pbkdf2')) {
        // The output length is in NIBBLES (4-bits) if $rawOutput is false!
        if (!$rawOutput) {
            $keyLength = $keyLength * 2;
        }
        return hash_pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput);
    }
    $hashLength = strlen(hash($algorithm, '', true));
    $blockCount = ceil($keyLength / $hashLength);
    $output = '';
    for ($i = 1; $i <= $blockCount; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt.pack('N', $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }
    $decryptData = substr($output, 0, $keyLength);
    if($rawOutput) {
        return $decryptData;
    }
    return bin2hex($decryptData);
}