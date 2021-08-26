<?php

$transport = new Swift_SmtpTransport($config['email']['host'], $config['email']['port'], $config['email']['encryption']);
$transport->setUsername($config['email']['username']);
$transport->setPassword($config['email']['password']);
$mailer = new Swift_Mailer($transport);


$allWinnersLots = getWinnerLots($db);

if($allWinnersLots) {
    $sql = "UPDATE lot SET lot_winner_id = ? WHERE lot_id = ? ";
    $stmt = $db->prepare($sql);
    foreach ($allWinnersLots as $winnerLot){
        $stmt->bind_param('ss', $winnerLot['bet_author_id'], $winnerLot['lot_id']);
        $stmt->execute();


        if ($stmt->affected_rows == 1) {

            $email = include_template('email-template.php', [
                'host' => $host,
                'winnerLot' => $winnerLot
            ]);
            $message = new Swift_Message();
            $message->setSubject('Ваша ставка победила');
            $message->setFrom("keks@phpdemo.ru", "Yeticave");
            $message->setTo($winnerLot['user_email']);
            $message->setBody($email, 'text/html');
            $mailer->send($message);
        }
    }
}

