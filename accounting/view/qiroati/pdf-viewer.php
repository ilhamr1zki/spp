<?php
if (isset($_GET['pdf'])) {
    $filenm = $_GET['pdf'];
    $pdfFile = '../../../wwwupload/' . $_GET['pdf']; // Append the PDF file name to the path
    // Rest of the code to send the PDF file as the response

    //$pdfFile = 'path/to/your/file.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="file.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($pdfFile);

} else {
    echo 'PDF file not specified.';
}
?>