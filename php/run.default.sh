#!/usr/bin/env bash
set -eu

# LaunchDarkly SDK Key環境変数を設定
# 注意: 実際の本番環境では、この値を直接スクリプトに記載せず、
# 外部の環境変数やシークレット管理システムから取得してください
export LAUNCHDARKLY_SDK_KEY="${LAUNCHDARKLY_SDK_KEY:-sdk-key-123abc}"

# Docker Composeでサービスが起動していない場合は起動
if ! docker-compose ps | grep -q "php74-app.*Up"; then
    echo "PHP 7.4環境を起動中..."
    docker-compose up -d
fi

# コンテナ内でPHPスクリプトを実行
if [ $# -eq 0 ]; then
    echo "PHP 7.4サーバーが起動しています: http://localhost:8000"
    echo "LaunchDarkly SDK Key: $LAUNCHDARKLY_SDK_KEY"
    echo "停止するには: task down"
else
    docker-compose exec -e LAUNCHDARKLY_SDK_KEY="$LAUNCHDARKLY_SDK_KEY" php74 "$@"
fi 
