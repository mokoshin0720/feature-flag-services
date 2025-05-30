FROM php:7.4-cli

# 必要なPHP拡張をインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /app

# ポート8000を公開
EXPOSE 8000

# デフォルトでPHPビルトインサーバーを起動
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"] 
