# 楽家計（Rakukake）- 家計管理アプリケーション

<p align="center">
<img src="https://img.shields.io/badge/-PHP-777BB4.svg?logo=php&style=for-the-badge&logoColor=white">
<img src="https://img.shields.io/badge/-Laravel-FF2D20.svg?logo=laravel&style=for-the-badge&logoColor=white">
<img src="https://img.shields.io/badge/-React-61DAFB.svg?logo=react&style=for-the-badge&logoColor=black">
<img src="https://img.shields.io/badge/-Tailwind%20CSS-38B2AC.svg?logo=tailwind-css&style=for-the-badge&logoColor=white">
<img src="https://img.shields.io/badge/-MySQL-4479A1.svg?logo=mysql&style=for-the-badge&logoColor=white">
<img src="https://img.shields.io/badge/-Docker-2496ED.svg?logo=docker&style=for-the-badge&logoColor=white">
</p>

## プロジェクト概要

楽家計（Rakukake）は、日々の収入と支出を簡単に記録・管理し、家計の健全化をサポートするWebアプリケーションです。収入・支出の登録、カテゴリ管理、固定収支の管理、レポート機能などを提供します。

## 使用している主な技術

### バックエンド
- PHP 8.1以上
- Laravel 10.x
- MySQL 8.0

### フロントエンド
- React 18.x
- Inertia.js
- Tailwind CSS
- Headless UI
- Highcharts（グラフ表示）

### 開発・インフラ
- Docker / Laravel Sail
- PHPUnit（テスト）
- GitHub Actions（CI/CD）

## 環境変数一覧

環境変数の設定は `.env` ファイルで行います。主な環境変数は以下の通りです：

| 変数名                 | 役割                      | デフォルト値           |
|-----------------------|--------------------------|---------------------|
| APP_NAME              | アプリケーション名          | Laravel             |
| APP_ENV               | 実行環境                  | local               |
| APP_KEY               | アプリケーションキー        | 自動生成される値       |
| APP_DEBUG             | デバッグモード             | true                |
| APP_URL               | アプリケーションURL        | http://localhost    |
| DB_CONNECTION         | データベース接続方式        | mysql               |
| DB_HOST               | データベースホスト          | mysql               |
| DB_PORT               | データベースポート          | 3306                |
| DB_DATABASE           | データベース名             | laravel             |
| DB_USERNAME           | データベースユーザー名      | sail                |
| DB_PASSWORD           | データベースパスワード      | password            |

## コマンド一覧

| コマンド                            | 説明                                         |
|------------------------------------|---------------------------------------------|
| `sail up`                          | Docker環境を起動                             |
| `sail up -d`                       | Docker環境をバックグラウンドで起動             |
| `sail down`                        | Docker環境を停止                             |
| `sail artisan migrate`             | データベースマイグレーションを実行              |
| `sail artisan db:seed`             | シードデータを投入                            |
| `sail npm run dev`                 | フロントエンド開発サーバーを起動                |
| `sail npm run build`               | フロントエンドのビルド                        |
| `sail artisan test`                | テストを実行                                 |
| `sail php --version`               | PHPのバージョンを確認                         |
| `sail composer install`            | PHPパッケージをインストール                    |
| `sail npm install`                 | NPMパッケージをインストール                    |

## ディレクトリ構成

```
rakukake/
├── app/                  # アプリケーションのコアコード
│   ├── Http/             # コントローラー、ミドルウェア、リクエスト
│   ├── Domain/           # ドメインモデル
│   │   └── Model/        # エンティティと値オブジェクト
│   ├── UseCase/          # ユースケース（アプリケーションロジック）
│   └── Repository/       # リポジトリインターフェースと実装
├── bootstrap/            # アプリケーション起動ファイル
├── config/               # 設定ファイル
├── database/             # マイグレーションとシード
├── public/               # 公開ディレクトリ
├── resources/            # ビュー、未コンパイルアセット
│   ├── js/               # Reactコンポーネント
│   └── css/              # スタイルシート
├── routes/               # ルート定義
├── storage/              # アップロードファイル、キャッシュなど
├── tests/                # テストファイル
└── vendor/               # Composerパッケージ
```

## 開発環境構築手順

### 前提条件
- Docker
- Docker Compose
- Git

### 手順

1. リポジトリをクローン
```bash
git clone [リポジトリURL]
cd rakukake
```

2. 環境設定ファイルをコピー
```bash
cp .env.example .env
```

3. Dockerコンテナを起動
```bash
./vendor/bin/sail up -d
```

4. アプリケーションキーを生成
```bash
./vendor/bin/sail artisan key:generate
```

5. 依存パッケージをインストール
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

6. マイグレーションを実行
```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed  # （オプション）テストデータを投入
```

7. フロントエンド開発サーバーを起動
```bash
./vendor/bin/sail npm run dev
```

8. ブラウザでアクセス  
http://localhost にアクセスすると、アプリケーションが表示されます。

## トラブルシューティング

### Docker起動時に「Ports are not available: address already in use」エラーが発生する場合
別のアプリケーションが同じポートを使用している可能性があります。`.env`ファイルの`APP_PORT`を変更してください。

### マイグレーション実行時にエラーが発生する場合
データベースの接続設定を確認してください。`.env`ファイルの`DB_*`設定が正しいことを確認してください。

### フロントエンドのビルドが失敗する場合
node_modulesを削除して再インストールしてみてください。
```bash
./vendor/bin/sail npm cache clean --force
./vendor/bin/sail rm -rf node_modules
./vendor/bin/sail npm install
```

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。
