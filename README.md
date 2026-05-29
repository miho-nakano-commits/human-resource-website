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
- `img/`: 画像・アイコン素材

## お問い合わせフォーム

通知先メールアドレスが決まったら、`js/contact.js` の `CONTACT_EMAIL_HERE` を通知先メールアドレスに置き換えてください。

例:

```js
const CONTACT_EMAIL = 'info@example.com';
```

このフォームは FormSubmit を利用します。初回送信時に通知先メールアドレスへ確認メールが届くため、承認すると以後のお問い合わせ通知が届くようになります。

## プレビュー

`index.html` をブラウザで開くと確認できます。
