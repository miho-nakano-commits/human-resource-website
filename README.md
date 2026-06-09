# 合同会社ヒューマンリソース ホームページ

合同会社ヒューマンリソースの静的ホームページです。

## ファイル構成

- `index.html`: トップページ
- `company.html`: 会社概要
- `services.html`: 事業紹介
- `cases.html`: 支援事例
- `contact.html`: お問い合わせ
- `css/style.css`: 共通スタイル
- `js/contact.js`: お問い合わせフォーム送信設定
- `send-mail.php`: お問い合わせ通知・自動返信メール送信
- `img/`: 画像・アイコン素材

## お問い合わせフォーム

お問い合わせフォームはXserver上のPHPで送信します。

- 管理者通知先: `human.kanazawa@gmail.com`
- 自動返信メールの送信元表示: `合同会社ヒューマンリソース <human.kanazawa@gmail.com>`

送信先を変更する場合は、`send-mail.php` 内の `$adminEmail` と `$fromEmail` を変更してください。
GitHub PagesではPHPが動かないため、フォーム送信機能はXserverへアップロードした環境で動作します。

## プレビュー

`index.html` をブラウザで開くと確認できます。
