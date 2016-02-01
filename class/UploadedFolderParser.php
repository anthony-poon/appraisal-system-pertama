<?php
class UploadedFolderParser {
    //put your code here
    private $dir;
    private $stopRootingFolder = TRUE;
    public function __construct($inDir = NULL) {
        
        $this->dir = UPLOAD_DIR.$inDir;
        // Prevent url injection by using ../
        if ($this->stopRootingFolder) {
            if (preg_match("/\.\./", $this->dir)) {
                throw new Exception("Illegal query string.");
            }
        }
    }
    
    public function isRootAFolder() {
        return is_dir($this->dir);
    }
    
    public function getRootContent() {
        if (!is_dir($this->dir)) {
            return file_get_contents($this->dir);
        }
    }
    
    public function getRootName() {
        return basename($this->dir);
    }
    public function getFolders() {
        $returnArray = array();
        foreach (scandir($this->dir) as $fileName) {
            if ($fileName !== "." && $fileName !== "..") {
                $fullPath = $this->dir."/".$fileName;
                if (is_dir($fullPath)) {
                    $returnArray[$fileName]["fileName"] = $fileName;
                    $returnArray[$fileName]["fullPath"] = $fullPath;
                    $returnArray[$fileName]["type"] = "folder";
                }
            }
        }
        if (!empty($returnArray)) {
            return $returnArray;
        } else {
            return false;
        }
    }
    
    public function getFiles() {
        $returnArray = array();
        foreach (scandir($this->dir) as $fileName) {
            if ($fileName !== "." && $fileName !== "..") {
                $fullPath = $this->dir."/".$fileName;
                if (!is_dir($fullPath)) {
                    $returnArray[$fileName]["fileName"] = $fileName;
                    $returnArray[$fileName]["fullPath"] = $fullPath;
                    $returnArray[$fileName]["type"] = "file";
                }
            }
        }
        if (!empty($returnArray)) {
            return $returnArray;
        } else {
            return false;
        }
    }
}
