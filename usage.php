<?php

use Dotenv\Dotenv;
use GitWrapper\GitWrapper;

// Initialize the library. If the path to the Git binary is not passed as
// the first argument when instantiating GitWrapper, it is auto-discovered.
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$gitWrapper = new GitWrapper();

// Optionally specify a private key other than one of the defaults
$gitWrapper->setPrivateKey(getenv('PATH_TO_PRIVARE_KEY'));

// Clone a repo into `/path/to/working/copy`, get a working copy object
$git = $gitWrapper->cloneRepository(getenv('REPOSITORY_URL'), getenv('PATH_TO_WORKING_COPY'));

// Create a file in the working copy
touch(getenv('PATH_TO_WORKING_COPY'). '/text.txt');

// Add it, commit it, and push the change
$git->add('text.txt');
$git->commit('Added the test.txt file as per the examples.');
$git->push();

// Render the output for operation
echo $git->push();

// Stream output of subsequent Git commands in real time to STDOUT and STDERR.
$gitWrapper->streamOutput();

// Execute an arbitrary git command.
// The following is synonymous with `git config -l`
$gitWrapper->git('config -l');
