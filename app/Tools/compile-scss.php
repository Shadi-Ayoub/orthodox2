<?php
// php compile-scss.php path/to/input.scss path/to/output.css format

require 'vendor/autoload.php'; // Adjust this path to your Composer's autoload.php

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Formatter\Expanded;
use ScssPhp\ScssPhp\Formatter\Compressed;

// Check if input file, output file, and format are provided
if ($argc !== 4) {
    echo "Usage: php script.php [input.scss] [output.css] [format: extended|compressed]" . PHP_EOL;
    exit(1);
}

// Read input and output file paths, and format from the command line arguments
$inputFile = __DIR__ . "//..//" . $argv[1];
$outputFile = $argv[2];
$format = $argv[3];

try {
    // Create an instance of the SCSS compiler
    $scss = new Compiler();

    // Set the output format
    if ($format === 'compressed') {
        $scss->setFormatter(Compressed::class);
    } else {
        // Default to expanded format
        $scss->setFormatter(Expanded::class);
    }

    // Read the content of the SCSS file
    $scssContent = file_get_contents($inputFile);
    if ($scssContent === false) {
        throw new Exception("Failed to read the input file: $inputFile");
    }

    // Compile the SCSS content to CSS
    $cssContent = $scss->compile($scssContent);

    // Write the compiled CSS to the output file
    $writeResult = file_put_contents($outputFile, $cssContent);
    if ($writeResult === false) {
        throw new Exception("Failed to write the compiled CSS to the output file: $outputFile");
    }

    echo "Successfully compiled SCSS from $inputFile to $outputFile in $format format" . PHP_EOL;
} catch (Exception $e) {
    // Handle any exceptions that occur during the process
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
