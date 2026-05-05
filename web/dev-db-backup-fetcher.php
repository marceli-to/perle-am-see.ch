<?php 
// v 20240828_3

// Set path constants
define('CRAFT_BASE_PATH', dirname(__DIR__));
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor');

// Load Composer's autoloader
require_once CRAFT_VENDOR_PATH.'/autoload.php';

if (class_exists('Dotenv\Dotenv') && file_exists(CRAFT_BASE_PATH.'/.env')) {
    // Check if 'createUnsafeMutable' method exists
    if (method_exists('Dotenv\Dotenv', 'createUnsafeMutable')) {
        // Dotenv version 5 or later
        // Use createUnsafeMutable() if available (which indicates a newer version)
        Dotenv\Dotenv::createUnsafeMutable(CRAFT_BASE_PATH)->safeLoad();
    } else {
        // Dotenv version 3 or earlier
        // Fallback to create() which is used in older versions
        if (file_exists(CRAFT_BASE_PATH . '/.env')) {
            Dotenv\Dotenv::create(CRAFT_BASE_PATH)->load();
        }
    }
}
else {
	exit;	
}

$devBackupDbFetcherToken = getenv('DEV_BACKUP_DB_FETCHER_TOKEN');
$redirectUrl = !empty(getenv('PRIMARY_SITE_URL')) ? getenv('PRIMARY_SITE_URL') : 'https://webkeeper.work';

// Verification
if (empty($devBackupDbFetcherToken) || $_POST['token'] !== $devBackupDbFetcherToken) {
	header('Location: ' . $redirectUrl);
	exit;
}

// Get the current PHP version (used by PHP-FPM) which can be differ from php-cli
$currentPhpVersion = phpversion();

// Extract the major and minor version (e.g., "8.2" from "8.2.0")
$majorMinorVersion = implode('.', array_slice(explode('.', $currentPhpVersion), 0, 2));
$phpVersion = str_replace('.', '', $majorMinorVersion);
// Construct the path to the PHP binary based on the version
$phpBinaryPath = "/opt/php{$phpVersion}/bin/php";

// Create new backup
$backupCmdOutput = shell_exec("{$phpBinaryPath} ../craft backup/db");

// Check if backup cmd seems to be done 
if(strpos($backupCmdOutput, 'done') !== false) {
	
	$folderPath = '../storage/backups/';

}

// Check if folder exists
if(is_dir($folderPath)){
    $newestFileTime = 0; 
    $newestFile = '';

    // Iterate through folder
    $directory = new DirectoryIterator($folderPath);
    foreach($directory as $file){
        if($file->isFile()){
            $fileTime = $file->getMTime();
            // Compare with newest file
            if($fileTime > $newestFileTime){
                $newestFileTime = $fileTime;
                $newestFile = $file->getFilename();
            }
        }
    }

    // Return newest file
    if($newestFile !== ''){

		$file = $folderPath . $newestFile;
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
		
    } else {
        echo "Keine Dateien gefunden im Verzeichnis: $folderPath";
    }
} else {
    echo "$folderPath ist kein gultiges Verzeichnis";
}