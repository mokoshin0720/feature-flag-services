<?php
$autoloadPath = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
    $ldAvailable = class_exists('LaunchDarkly\LDClient');
} else {
    $ldAvailable = false;
    $composerNotInstalled = true;
}

echo "<h1>PHP 7.4 環境が正常に動作しています！</h1>";
echo "<p>PHPバージョン: " . phpversion() . "</p>";
echo "<p>現在時刻: " . date('Y-m-d H:i:s') . "</p>";

// LaunchDarkly SDKテスト
echo "<h2>LaunchDarkly SDK</h2>";
echo "<ul>";
if (isset($composerNotInstalled) && $composerNotInstalled) {
    echo "<li>Composer依存関係: ❌ 未インストール（composer installを実行してください）</li>";
    echo "<li>LaunchDarkly SDK: ❌ 利用不可</li>";
} else {
    echo "<li>Composer依存関係: ✅ インストール済み</li>";
    echo "<li>LaunchDarkly SDK: " . ($ldAvailable ? '✅ インポート完了' : '❌') . "</li>";

    // 環境変数からSDKキーを取得
    $sdkKey = getenv('LAUNCHDARKLY_SDK_KEY') ?: $_ENV['LAUNCHDARKLY_SDK_KEY'] ?? null;
    
    if (empty($sdkKey)) {
        echo "<li>LaunchDarkly SDK Key: ❌ 環境変数 LAUNCHDARKLY_SDK_KEY が設定されていません</li>";
        echo "<li>フラグテスト: ❌ スキップされました</li>";
    } else {
        echo "<li>LaunchDarkly SDK Key: ✅ 環境変数から取得</li>";
        echo "<li>SDK Key: " . $sdkKey . "</li>";
        
        $client = new LaunchDarkly\LDClient($sdkKey);

        $flagKey = "sample-in-private";
        $contextKey = "context-key-123abc";
        $contextName = "test";

        $user = (new LaunchDarkly\LDUserBuilder($contextKey))
            ->name($contextName)
            ->build();

        if ($client->variation($flagKey, $user)) {
            echo "✅ フラグが有効です";
        } else {
            echo "❌ フラグが無効です";
        }
    }
}
echo "</ul>";

// 基本的な機能テスト
echo "<h2>機能テスト</h2>";
echo "<ul>";
echo "<li>JSON拡張: " . (extension_loaded('json') ? '✅' : '❌') . "</li>";
echo "<li>PDO拡張: " . (extension_loaded('pdo') ? '✅' : '❌') . "</li>";
echo "<li>ZIP拡張: " . (extension_loaded('zip') ? '✅' : '❌') . "</li>";
echo "<li>MySQL PDO: " . (extension_loaded('pdo_mysql') ? '✅' : '❌') . "</li>";
echo "</ul>";

phpinfo();
?>
