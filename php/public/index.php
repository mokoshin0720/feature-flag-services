<?php
echo "<h1>PHP 7.4 環境が正常に動作しています！</h1>";
echo "<p>PHPバージョン: " . phpversion() . "</p>";
echo "<p>現在時刻: " . date('Y-m-d H:i:s') . "</p>";

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
