<?php

require 'vendor/autoload.php';

$uploadDir = 'uploads/temp/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$resumeDir = 'uploads/resume/';

if (!file_exists($resumeDir)) {
    mkdir($resumeDir, 0777, true);
}

// Get the uploaded file
$uploadedFile = $_FILES['file'];

// Remove white spaces and special characters from the original filename
$cleanedFileName = preg_replace('/[^\w\-\.]/', '_', $uploadedFile['name']);

// Generate a new filename based on the cleaned name, date, and time
$newFileName = "read_resume_" . date("YmdHis") . "_" . time() . "_" . $cleanedFileName;

// Set the path for the new file
$targetPath = $uploadDir . $newFileName;

$responseArray = array();
// Move the uploaded file to the specified directory with the new name
if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
    // File upload successful, you can send a success response back to the client
    $responseArray['status'] = 'success';
    $responseArray['message'] = 'File uploaded successfully';
} else {
    // File upload failed, send an error response
    $responseArray['status'] = 'error';
    $responseArray['message'] = 'File upload failed';
}

// Function to read PDF as text
function readResumePDFAsText($pdfPath) {
    $parser = null;
    $parser = new \Smalot\PdfParser\Parser();
    $PDF = $parser->parseFile($pdfPath);
    $fileText = $PDF->getText();

    // line break
    $PDFContent = $fileText;
    return $PDFContent;
}

// Example usage
$pdfPath = $targetPath;
// Read as text
$textData = readResumePDFAsText($pdfPath);
// echo $textData.'<br><br>';

$string = $textData;
$nameMatches = [];
$namePattern = '/\b\w+\b/';

// Perform the regular expression match
preg_match_all($namePattern, $string, $nameMatches);

// Extract the first two words from the matches array
$firstTwoWords = array_slice($nameMatches[0], 0, 2);

// Output the result
$candidteName = @$firstTwoWords[0].' '.@$firstTwoWords[1];
// echo '<br>Candidte Name : '.$candidteName;

$emailMatches = [];
$emailPattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';
// Find all email addresses in the string
preg_match_all($emailPattern, $string, $emailMatches);
// Validate each email address using filter_var
$validEmails = array_filter($emailMatches[0], function($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
});
// Output the result
$candidteEmail = @$validEmails[0];
// echo '<br>Candidte Email : '.$candidteEmail;

$mobileMatches = [];
// $mobilePattern = '/\b(?:\+?\d{1,3}[-.\s]?)?\(?(\d{1,})\)?[-.\s]?\d{1,}[-.\s]?\d{1,}\b/';
// $mobilePattern = '/\b(?:\+?\d{1,3}[-.\s]?)?\d{3}[-.\s]?\d{3}[-.\s]?\d{4}\b/';
$mobilePattern = '/\b\d{3,}[-\s]?\d{3,}[-\s]?(\d{4})?\b/';

// Perform the regular expression match
preg_match_all($mobilePattern, $string, $mobileMatches);
// echo '<pre>';print_r($mobileMatches);
// Output the result
$candidteMobile = @$mobileMatches[0][0];
// echo '<br>Candidte Mobile : '.$candidteMobile;

// Create a regex pattern from the skill set array
$skillSetArray = [
    'Data Visualization',
    'Research Skills',
    'Logistic Regressions',
    'Problem solving',
    'strong technical skills',
    'MS Excel',
    'MySQL',
    'PHP',
    'node',
    'laravel',
    'Car driving',
    'Drill machine operating',
    'Good communication skills',
    'Machinery job work',
    'mathematics',
    'ReactJS'
];
$skillMatches = [];
$skillPattern = '/\b(?:' . implode('|', array_map('preg_quote', $skillSetArray)) . ')\b/i';
$candidateSkills = null;
// Find all matches of skills in the full string
if (preg_match_all($skillPattern, $string, $skillMatches)) {
    $matchedSkills = $skillMatches[0];
    $candidateSkills = implode(', ', $matchedSkills);
} else {
    $candidateSkills = "No matching skills found in the resume.";
}
// Output the result
// echo '<br>Candidte Skills : '.@$candidateSkills;

// Define a regex pattern for matching month and year
$carrierMatches = [];
$carrierPattern = '/(?:\b(?:Jan|Feb|Mar|Apr|Jun|Jul|Aug|Sep|Oct|Nov|Dec|January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{2,4}\b)/';
$carrierArray = [];
$candidateCarrier = null;
// Find all matches of month and year in the string
if (preg_match_all($carrierPattern, $string, $carrierMatches)) {

    // Custom comparison function to sort dates
    function compareDates($date1, $date2) {
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);

        return $timestamp1 - $timestamp2;
    }

    // Use usort to sort the dates array
    usort($carrierMatches[0], 'compareDates');
    // Output the sorted dates
    $carrierArray = @$carrierMatches[0];
} else {
    $candidateCarrier = "No month and year data found in the resume.";
}

if (count($carrierArray) > 0) {
    $candidateCarrier = $carrierArray[0].' - '.end($carrierArray);
}

// Output the result
// echo '<br>Candidte Carrier : '.@$candidateCarrier;

$responseArray['id'] = null;
$responseArray['name'] = @$candidteName;
$responseArray['email'] = @$candidteEmail;
$responseArray['mobile'] = @$candidteMobile;
$responseArray['skills'] = @$candidateSkills;
$responseArray['carrier'] = @$candidateCarrier;
$responseArray['data'] = @$textData;
$responseArray['pdf'] = @$pdfPath;
$responseArray['type'] = "add";

echo json_encode($responseArray);
exit;

?>