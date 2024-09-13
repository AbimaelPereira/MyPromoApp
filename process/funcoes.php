<?php
function getConnection()
{
    $dsn = "mysql:host=127.0.0.1;dbname=mpa;charset=utf8";
    $user = "root";
    $pass = "password";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        return $pdo;
    } catch (PDOException $ex) {
        echo 'Erro: ' . $ex->getMessage();
    }
}

function sair($pagina)
{
    session_start();
    session_destroy();
    header("location: " . $pagina);
}

function uploadArquivo($arquivo)
{
    $formatosPermitidos = array("png", "jpeg", "jpg");
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $tamanhoFoto = $arquivo['size'];
    if (in_array($extensao, $formatosPermitidos) && $tamanhoFoto < 1000000) {
        $nomeTemporario = $arquivo['tmp_name'];
        $nomeNovo = uniqid() . "." . $extensao;
        $a = array(
            "nomeTemporario" => $nomeTemporario,
            "nomeNovo" => $nomeNovo,
        );
        return $a;
    } else {
        return false;
    }
}
function notify($nomeSession, $mensagem, $type, $pagina, $position)
{
    session_start();
    $_SESSION[$nomeSession] = $mensagem;
    $_SESSION['type'] = $type;
    $_SESSION['position'] = $position;
    header("location: " . $pagina);
}
function viewNotify($mensagemNotify, $typeNotify, $positionNotify)
{ ?>
    <script>
        $.notify("<?= $mensagemNotify ?>", "<?= $typeNotify ?>", {
            position: "<?= $positionNotify ?>"
        });
    </script>
<?php
}
function sendNotify($title, $body, $topic)
{
  // FCM API Url
  $url = 'https://fcm.googleapis.com/fcm/send';

  // Put your Server Key here
  $apiKey = "AAAAnXNdVzA:APA91bF-U2KBFW2aLCRfzq7R46JTrNpgf3HEqnDv65PZNXksOzdzL7cpPA69f4zujSj04xzrH5Z_R8YU4XFc_g9rQXBrtH4MslvJXJEKcY_FZCcIAP7UEO5TGpLMzWMX5P0BU_CML-ro";

  // Compile headers in one variable
  $headers = array(
    'Authorization:key=' . $apiKey,
    'Content-Type:application/json'
  );

  // Add notification content to a variable for easy reference
  $notifData = [
    'title' => $title,
    'body' => $body,
    //  "image": "url-to-image",//Optional
  ];


  // Create the api body
  $apiBody = [
    'notification' => $notifData,
    'time_to_live' => 600, // optional - In Seconds
    'to' => '/topics/'.$topic
  ];

  // Initialize curl with the prepared headers and body
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

  // Execute call and save result
  $result = curl_exec($ch);
  curl_close($ch);

  return $result;
}