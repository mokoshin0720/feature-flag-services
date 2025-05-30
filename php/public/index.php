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
