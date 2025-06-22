# らくカケ API

## 概要

らくカケは家計管理を簡単にするためのLaravel APIバックエンドシステムです。収入・支出の管理、カテゴリー分類、レポート機能を提供し、個人の家計管理をサポートします。

## 主な機能

- **収入管理**
  - 収入の登録・更新・削除
  - 固定収入の管理
  - 収入カテゴリーの管理

- **支出管理**
  - 支出の登録・更新・削除
  - 固定支出の管理
  - 支出カテゴリーの管理
  - CSV一括インポート・エクスポート

- **レポート機能**
  - 貯蓄レポート
  - 支出レポート
  - カテゴリー別集計

- **認証機能**
  - Laravel Sanctumを使用したAPI認証
  - ユーザー管理

## 技術スタック

- **フレームワーク**: Laravel 10.x
- **PHP**: 8.2以上
- **認証**: Laravel Sanctum
- **アーキテクチャ**: ドメイン駆動設計（DDD）
- **データベース**: MySQL/PostgreSQL対応

## アーキテクチャ

このプロジェクトはドメイン駆動設計（DDD）とクリーンアーキテクチャの原則に基づいて構築されています。

```
app/
├── Application/          # アプリケーション層
│   ├── Port/            # インターフェース定義
│   ├── Query/           # クエリサービス
│   ├── Service/         # アプリケーションサービス
│   └── UseCase/         # ユースケース実装
├── Domain/              # ドメイン層
│   └── Model/           # ドメインモデル
├── Infrastructure/      # インフラストラクチャ層
│   ├── Adaptor/         # アダプター
│   ├── Query/           # クエリ実装
│   └── Repository/      # リポジトリ実装
└── Http/               # プレゼンテーション層
    └── Controllers/     # コントローラー
```

## セットアップ

### 必要な環境

- PHP 8.2以上
- Composer
- Node.js（フロントエンド開発時）
- MySQL または PostgreSQL

### インストール手順

1. リポジトリをクローン
```bash
git clone <repository-url>
cd backend
```

2. 依存関係をインストール
```bash
composer install
```

3. 環境設定ファイルをコピー
```bash
cp .env.example .env
```

4. アプリケーションキーを生成
```bash
php artisan key:generate
```

5. データベース設定
`.env`ファイルでデータベース接続情報を設定

6. マイグレーション実行
```bash
php artisan migrate
```

7. シーダー実行（オプション）
```bash
php artisan db:seed
```

8. 開発サーバー起動
```bash
php artisan serve
```

## API仕様

### 認証

すべてのAPIエンドポイントはLaravel Sanctumによる認証が必要です。

### エンドポイント一覧

#### 認証関連
- `POST /api/login` - ログイン
- `POST /api/logout` - ログアウト
- `GET /api/user` - ユーザー情報取得

#### 収入管理
- `GET /api/v1/incomes/get` - 収入一覧取得
- `POST /api/v1/incomes/add` - 収入追加
- `PUT /api/v1/incomes/update/{id}` - 収入更新
- `DELETE /api/v1/incomes/{id}` - 収入削除

#### 固定収入管理
- `GET /api/v1/fixed-incomes/get` - 固定収入一覧取得
- `POST /api/v1/fixed-incomes/add` - 固定収入追加
- `PUT /api/v1/fixed-incomes/update/{id}` - 固定収入更新
- `DELETE /api/v1/fixed-incomes/{id}` - 固定収入削除

#### 支出管理
- `GET /api/v1/expenditures` - 支出一覧取得
- `POST /api/v1/expenditures/add` - 支出追加
- `PUT /api/v1/expenditures/update/{id}` - 支出更新
- `DELETE /api/v1/expenditures/{id}` - 支出削除
- `POST /api/v1/expenses/bulk-create` - 支出一括作成

#### 固定支出管理
- `GET /api/v1/fixed-expenses/get` - 固定支出一覧取得
- `POST /api/v1/fixed-expenses/add` - 固定支出追加
- `PUT /api/v1/fixed-expenses/update/{id}` - 固定支出更新
- `DELETE /api/v1/fixed-expenses/{id}` - 固定支出削除

#### カテゴリー管理
- `GET /api/v1/income-categories` - 収入カテゴリー一覧取得
- `POST /api/v1/income-categories` - 収入カテゴリー作成
- `PUT /api/v1/income-categories/{id}` - 収入カテゴリー更新
- `DELETE /api/v1/income-categories/{id}` - 収入カテゴリー削除

- `GET /api/v1/expense-categories/get` - 支出カテゴリー一覧取得
- `POST /api/v1/expense-categories` - 支出カテゴリー作成
- `PUT /api/v1/expense-categories/{id}` - 支出カテゴリー更新
- `DELETE /api/v1/expense-categories/{id}` - 支出カテゴリー削除

#### CSV機能
- `GET /api/v1/expenses/sample` - サンプルCSVダウンロード
- `GET /api/v1/expenses/download` - 支出データCSVエクスポート
- `POST /api/v1/expenses/import` - 支出データCSVインポート

#### レポート
- `GET /api/v1/report/saving` - 貯蓄レポート
- `GET /api/v1/report/expense` - 支出レポート
- `GET /api/v1/report/saving/get` - カテゴリー別貯蓄データ
- `GET /api/v1/report/expense/get` - 支出情報一覧

## データベース構造

### 主要テーブル

- `users` - ユーザー情報
- `incomes` - 収入データ
- `income_categories` - 収入カテゴリー
- `fixed_incomes` - 固定収入データ
- `expenditures` - 支出データ
- `expenditure_categories` - 支出カテゴリー
- `fixed_expenditures` - 固定支出データ
- `preset_expenditure_items` - プリセット支出項目
- `life_insurances` - 生命保険データ

## 開発ガイドライン

### コーディング規約

- 変数名: キャメルケース
- クラス名: パスカルケース
- Enumの定数名: パスカルケース
- すべてのPHPファイルで`declare(strict_types=1);`を使用

### ドメインオブジェクトの実装ルール

- すべてのドメインオブジェクトは`app/Domain/Model`配下に配置
- プリミティブ型は値オブジェクトでラップ
- エンティティはコンストラクタでバリデーション実行
- イミュータブルな設計を心がける

### ユースケースの実装ルール

- 実行メソッド名は必ず`handle`
- 依存性注入でトランザクションとリポジトリを受け取り
- InputDataオブジェクトでパラメータを受け取り
- 対応するInputDataクラスを必ず作成

## テスト

```bash
# 全テスト実行
php artisan test

# 特定のテストクラス実行
php artisan test tests/Feature/ExampleTest.php

# カバレッジ付きテスト実行
php artisan test --coverage
```

## デプロイ

### 本番環境への配置

1. 環境変数の設定
2. 依存関係のインストール
3. アプリケーションキーの生成
4. データベースマイグレーション
5. キャッシュの最適化

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ライセンス

MIT License

## 貢献

プルリクエストや課題報告は歓迎します。貢献する前に、コーディング規約とアーキテクチャガイドラインを確認してください。
