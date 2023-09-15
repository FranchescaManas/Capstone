<?php

require '../vendor/autoload.php'; // Include the Composer autoloader
// require '..\vendor\thiagoalessio\tesseract_ocr\src\TesseractOCR.php'; // Include the Composer autoloader
ini_set('display_errors', 0);
use StanfordNLP\NERTagger;
use thiagoalessio\TesseractOCR\TesseractOCR;
use StanfordNLP\POSTagger;
use StanfordNLP\Parser;


$path = $_SERVER['DOCUMENT_ROOT'] . '/capstone/assets/stanford-postagger';
$path2 = $_SERVER['DOCUMENT_ROOT'] . '/capstone/assets/stanford-parser';
$path3 = $_SERVER['DOCUMENT_ROOT'] . '/capstone/assets/stanford-ner';

$pos = new POSTagger(
$path . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'english-left3words-distsim.tagger',
$path . DIRECTORY_SEPARATOR . 'stanford-postagger-4.2.0.jar'
);
$parser = new Parser($path2 . DIRECTORY_SEPARATOR . '\stanford-parser.jar',
$path2 . DIRECTORY_SEPARATOR . 'stanford-parser-4.2.0-models.jar');
$ner = new NERTagger($path3 . DIRECTORY_SEPARATOR . '\classifiers\english.all.3class.distsim.crf.ser.gz',
$path3 . DIRECTORY_SEPARATOR . 'stanford-ner-4.2.0.jar');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $imagePath = $_FILES['image']['tmp_name'];

    try {
        // Perform OCR to extract text from the image
        $text = (new TesseractOCR($imagePath))->run();
        $namedEntities = $ner->tag(explode(' ',$text));
     
        $name = '';
        $title = extractTitle($text);
        $provider = '';
        $dateCertified = extractDate($text);

        foreach ($namedEntities as $entityGroup) {
            foreach ($entityGroup as $entity) {
                $entityText = $entity[0];
                $entityType = $entity[1];
        
                // Extract relevant information based on entity types
                if ($entityType === 'PERSON') {
                    $name .= $entityText . ' ';
                } elseif ($entityType === 'ORGANIZATION') {
                    $provider = $entityText;
                } elseif ($entityType === 'DATE') {
                    $dateCertified .= $entityText;
                }
            }
        }
        // Create an associative array to store the extracted data
        
        $certificateInfo = [
            'Name' => $name,
            'Title' => $title,
            'IssuedBy' => $provider,
            'DateCertified' => $dateCertified,
        ];
        // Encode the data as JSON and echo it
        echo json_encode($certificateInfo);
       
            
        }
     catch (Exception $e) {
        echo json_encode(array('error' => 'An error occurred: ' . $e->getMessage()));
    }
}
function extractDate($input) {
    $datePattern = '/(\d{4}-\d{2}-\d{2})|(\w+\s+\d{1,2},?\s+\d{4})|(\d{1,2}\/\d{1,2}\/\d{2,4})|(\d{1,2}-\d{1,2}-\d{2,4})|(\d{1,2}\s+(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{2,4})/';

    // Check if the input string contains a date match
    if (preg_match($datePattern, $input, $matches)) {
        return $matches[0]; // Return the matched date
    } else {
        return null; // Return null if no date is found
    }
}
function extractTitle($text) {
    $titlePatterns = [
        '/Certificate\s+of\s+(.+)/i' => 'Certificate of',
    '/Award\s+for\s+(.+)/i' => 'Award for',
    '/Completion\s+of\s+(.+)/i' => 'Completion of',
    '/Employee\s+of\s+the\s+(.+)/i' => 'Employee of the',
    '/Certification\s+in\s+(.+)/i' => 'Certification in',
    '/Diploma\s+in\s+(.+)/i' => 'Diploma in',
    '/Professional\s+Certificate\s+in\s+(.+)/i' => 'Professional Certificate in',
    '/Advanced\s+Certificate\s+in\s+(.+)/i' => 'Advanced Certificate in',
    '/Master\s+of\s+(.+)/i' => 'Master of',
    '/Bachelor\s+of\s+(.+)/i' => 'Bachelor of',
    '/Associate\s+of\s+(.+)/i' => 'Associate of',
    '/Doctorate\s+in\s+(.+)/i' => 'Doctorate in',
    '/Specialist\s+in\s+(.+)/i' => 'Specialist in',
    '/Postgraduate\s+Diploma\s+in\s+(.+)/i' => 'Postgraduate Diploma in',
    '/Fellowship\s+in\s+(.+)/i' => 'Fellowship in',
        // Add more patterns as needed
    ];

    foreach ($titlePatterns as $pattern => $description) {
        if (preg_match($pattern, ucwords($text), $matches)) {
            // TODO: FIX THE UPPERCASING OF THE TEXT
            return $description . ' ' . $matches[1];
        }
    }

    return '';
}


?>