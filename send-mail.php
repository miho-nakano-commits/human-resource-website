<?php
declare(strict_types=1);

mb_language('Japanese');
mb_internal_encoding('UTF-8');

$adminEmail = 'human.kanazawa@gmail.com';
$fromEmail = 'human.kanazawa@gmail.com';
$siteName = '合同会社ヒューマンリソース';

function json_response(bool $ok, string $message, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'ok' => $ok,
        'message' => $message,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function field(string $name, int $maxLength = 2000): string
{
    $value = isset($_POST[$name]) ? trim((string) $_POST[$name]) : '';
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    return mb_substr($value, 0, $maxLength);
}

function header_address(string $name, string $email): string
{
    return mb_encode_mimeheader($name, 'UTF-8') . " <{$email}>";
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, '不正なアクセスです。', 405);
}

if (field('_honey', 200) !== '') {
    json_response(true, '送信が完了しました。');
}

$company = field('会社名', 200);
$name = field('ご担当者名', 120);
$email = field('email', 254);
$tel = field('電話番号', 80);
$message = field('お問い合わせ内容', 3000);

if ($company === '' || $name === '' || $email === '' || $message === '') {
    json_response(false, '必須項目をご入力ください。', 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(false, 'メールアドレスの形式をご確認ください。', 400);
}

$submittedAt = date('Y年n月j日 H:i');
$adminSubject = '【' . $siteName . '】ホームページからお問い合わせがありました';
$adminBody = <<<TEXT
ホームページからお問い合わせがありました。

【送信日時】
{$submittedAt}

【会社名】
{$company}

【ご担当者名】
{$name}

【メールアドレス】
{$email}

【電話番号】
{$tel}

【お問い合わせ内容】
{$message}
TEXT;

$autoReplySubject = 'お問い合わせありがとうございます｜' . $siteName;
$autoReplyBody = <<<TEXT
{$name} 様

この度は、{$siteName}へお問い合わせいただきありがとうございます。
以下の内容でお問い合わせを受け付けました。

内容を確認のうえ、担当者よりご連絡いたします。

------------------------------
【会社名】
{$company}

【ご担当者名】
{$name}

【メールアドレス】
{$email}

【電話番号】
{$tel}

【お問い合わせ内容】
{$message}
------------------------------

{$siteName}
TEXT;

$fromHeader = header_address($siteName, $fromEmail);
$adminHeaders = [
    "From: {$fromHeader}",
    "Reply-To: {$email}",
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];
$replyHeaders = [
    "From: {$fromHeader}",
    "Reply-To: {$adminEmail}",
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];

$adminSent = mb_send_mail($adminEmail, $adminSubject, $adminBody, implode("\n", $adminHeaders));
$replySent = mb_send_mail($email, $autoReplySubject, $autoReplyBody, implode("\n", $replyHeaders));

if (!$adminSent || !$replySent) {
    json_response(false, '送信できませんでした。時間をおいて再度お試しください。', 500);
}

json_response(true, '送信が完了しました。お問い合わせありがとうございます。');
