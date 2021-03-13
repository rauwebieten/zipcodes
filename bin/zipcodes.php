<?php

namespace bin;

use GuzzleHttp\Client;
use League\CLImate\CLImate;
use RauweBieten\ZipCodes\ZipCodes;

require_once __DIR__ . '/../vendor/autoload.php';

$climate = new CLImate();
$climate->clear();
$climate->addArt(__DIR__ . '/ascii');
$climate->draw('logo');

$input = $climate->input('Country code?');
$countryCode = $input->prompt();
$countryCode = strtoupper($countryCode);

if (!$countryCode) {
    exit(0);
}

// download ZIP file
$downloadUrl = "https://download.geonames.org/export/zip/$countryCode.zip";
$climate->whisper("Downloading $downloadUrl...");

$client = new Client();
$client->get($downloadUrl);

$zipFilePath = __DIR__ . '/tmp/' . $countryCode . '.zip';

$fileHandle = fopen($zipFilePath, 'w');
$client->request('GET', $downloadUrl, ['sink' => $fileHandle]);

// extract ZIP file

$climate->whisper('Extracting ZIP file...');
$zipFolderPath = __DIR__ . '/tmp/' . $countryCode;

$zip = new \ZipArchive();
$bool = $zip->open($zipFilePath);
if (!$bool) {
    throw new \RuntimeException('Could not open ZIP file');
}
$zip->extractTo($zipFolderPath);
$zip->close();

// read csv into array

$climate->whisper("Reading ZIP file contents...");
$dataFilePath = __DIR__ . '/tmp/' . $countryCode . '/' . $countryCode . '.txt';
$bool = $fileHandle = fopen($dataFilePath, 'r');
if (!$bool) {
    throw new \RuntimeException('Could not open data file');
}

$zipcodes = [];
while (($data = fgetcsv($fileHandle, 0, "\t")) !== false) {
    $zipcodes[] = [
        'country' => $data[0],
        'zipcode' => $data[1],
        'place' => $data[2],
        'latitude' => $data[9],
        'longitude' => $data[10],
    ];
}
fclose($fileHandle);

// save result in a PHP file

$climate->whisper("Creating PHP file...");

$phpContent = "<?php \n\n";
$phpContent .= "return " . var_export($zipcodes, true) . ";";

$phpFilePath = __DIR__ . '/../src/data/' . $countryCode . '.php';
file_put_contents($phpFilePath, $phpContent);

$climate->green("Ready!");

// test

$climate->whisper("Testing PHP file...");

$data = ZipCodes::getData($countryCode);
print_r($data[0]);

exit(0);