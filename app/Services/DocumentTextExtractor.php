<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Exception;

class DocumentTextExtractor
{
    public function extractText(string $filePath): string
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            throw new Exception('File not found: ' . $filePath);
        }
        
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        
        switch ($extension) {
            case 'pdf':
                return $this->extractFromPdf($fullPath);
            case 'doc':
            case 'docx':
                return $this->extractFromWord($fullPath);
            case 'txt':
                return $this->extractFromText($fullPath);
            default:
                throw new Exception('Unsupported file type: ' . $extension);
        }
    }
    
    private function extractFromPdf(string $filePath): string
    {
        try {
            // Try using the smalot/pdfparser package if available
            if (class_exists('\Smalot\PdfParser\Parser')) {
                try {
                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                    if (!empty(trim($text))) {
                        return trim($text);
                    }
                } catch (Exception $e) {
                    // Continue to fallback methods
                }
            }
            
            // Fallback: Try using pdftotext command if available
            $output = shell_exec("pdftotext '$filePath' - 2>/dev/null");
            if ($output !== null && !empty(trim($output))) {
                return trim($output);
            }
            
            // Another fallback: Try using ps2ascii
            $output = shell_exec("ps2ascii '$filePath' 2>/dev/null");
            if ($output !== null && !empty(trim($output))) {
                return trim($output);
            }
            
            // Final fallback: Basic extraction attempt
            return $this->basicPdfExtraction($filePath);
            
        } catch (Exception $e) {
            throw new Exception('Failed to extract text from PDF: ' . $e->getMessage());
        }
    }
    
    private function basicPdfExtraction(string $filePath): string
    {
        // Very basic PDF text extraction as last resort
        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new Exception('Could not read PDF file');
        }
        
        // Simple text extraction from PDF content
        // This is a very basic approach and won't work for all PDFs
        if (preg_match_all('/\((.*?)\)/', $content, $matches)) {
            $text = implode(' ', $matches[1]);
            if (!empty(trim($text))) {
                return trim($text);
            }
        }
        
        throw new Exception('PDF text extraction failed - no suitable method available. Please try pasting your resume content manually.');
    }
    
    private function extractFromWord(string $filePath): string
    {
        try {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            
            if ($extension === 'docx') {
                // Try extracting from DOCX using unzip
                $text = $this->extractFromDocx($filePath);
                if (!empty($text)) {
                    return $text;
                }
            }
            
            // Try using antiword for DOC files
            $output = shell_exec("antiword '$filePath' 2>/dev/null");
            if ($output !== null) {
                return trim($output);
            }
            
            // Try using catdoc
            $output = shell_exec("catdoc '$filePath' 2>/dev/null");
            if ($output !== null) {
                return trim($output);
            }
            
            throw new Exception('Word document text extraction failed - no suitable method available');
            
        } catch (Exception $e) {
            throw new Exception('Failed to extract text from Word document: ' . $e->getMessage());
        }
    }
    
    private function extractFromDocx(string $filePath): string
    {
        try {
            if (!class_exists('ZipArchive')) {
                return '';
            }
            
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $content = '';
                
                // Extract text from document.xml
                $xml = $zip->getFromName('word/document.xml');
                if ($xml) {
                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);
                    if ($dom->loadXML($xml)) {
                        $content = strip_tags($dom->saveHTML());
                        $content = html_entity_decode($content);
                        $content = preg_replace('/\s+/', ' ', $content);
                    }
                    libxml_clear_errors();
                }
                
                $zip->close();
                return trim($content);
            }
            
            return '';
        } catch (Exception $e) {
            return '';
        }
    }
    
    private function extractFromText(string $filePath): string
    {
        return file_get_contents($filePath);
    }
    
    public function isSupported(string $filePath): bool
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return in_array($extension, ['pdf', 'doc', 'docx', 'txt']);
    }
    
    /**
     * Get a clean excerpt of the extracted text for preview
     */
    public function getTextPreview(string $text, int $maxLength = 200): string
    {
        // Clean up the text
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) <= $maxLength) {
            return $text;
        }
        
        // Try to cut at a sentence boundary
        $excerpt = substr($text, 0, $maxLength);
        $lastPeriod = strrpos($excerpt, '.');
        $lastExclamation = strrpos($excerpt, '!');
        $lastQuestion = strrpos($excerpt, '?');
        
        $lastSentence = max($lastPeriod, $lastExclamation, $lastQuestion);
        
        if ($lastSentence !== false && $lastSentence > $maxLength * 0.7) {
            return substr($text, 0, $lastSentence + 1);
        }
        
        // Cut at word boundary
        $lastSpace = strrpos($excerpt, ' ');
        if ($lastSpace !== false) {
            return substr($text, 0, $lastSpace) . '...';
        }
        
        return $excerpt . '...';
    }
}