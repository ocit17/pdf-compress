<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_compress extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('upload_form');
    }

    public function compress_pdf() {
        $gsPath = "C:\Program Files\gs\gs10.02.0\bin\gswin64c.exe";
        $uploadedFile = $_FILES['pdf_file'];
        $pdfPath = $uploadedFile['tmp_name'];
        $originalFileName = $uploadedFile['name'];
    
        $outputPdfPath = 'uploads/' . date('Y-m-d'). '_'. date('H') . '_'. date('i') . '_'. date('s'). '_compressed.pdf';
        $command = '"C:\Program Files\gs\gs10.02.0\bin\gswin64c.exe" -sDEVICE=pdfwrite -dNOPAUSE -dQUIET -dBATCH -dDownsampleColorImages=true -dColorImageResolution=100 -dDownsampleGrayImages=true -dGrayImageResolution=100 -dDownsampleMonoImages=true -dMonoImageResolution=100 -sOutputFile='.$outputPdfPath.' '.$pdfPath;
        exec($command); // run command Ghostscript
    
        if (file_exists($outputPdfPath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $originalFileName . '_compressed.pdf"');
            readfile($outputPdfPath);
            exit;
        } else {
            echo 'Failed to compress.';
            echo $command;
        }
    }
}
