<?php

/**
 * @author: PhongPhamHong<minhcoltech@gmail.com>
 * Class for upload handel on server

 * overrided from:
 *  @author John Ciacia <Sidewinder@extreme-hq.com>
 *  @version 1.0
 *  @copyright Copyright (c) 2007, John Ciacia
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 * @date: 12/23/2013
 */
require './UploadBase.php';
require './Resize.php';
require './HtmlFormat.php';

class Uploadhandel extends UploadBase {

    /**
     * default max size
     */
    const MAX_FILE_SIZE = 500000;

    /**
     * type upload
     */
    const UPLOAD_IMAGE = 1;
    const UPLOAD_FILES = 2;
    const UPLOAD_BOOK = 3;
    const STATIC_FOLDER_NAME = 'static';

    /**
     * folder prefix name for resize and crop
     */
    const PRE_FIX_FOLDER_RESIZE = 's';
    const PRE_FIX_FOLDER_CROP = 'c';

    /**
     * just for upload book;
     * @var type 
     */
    protected $pageCount = 0;
    protected $pathOut = '';
    protected $default_avatar_path = '';
    protected $default_avatar_name = '';
    protected $assetPath = '';

    /**
     * upload type
     */
    protected $uploadType;

    /**
     * array allowed extension for upload image
     */
    protected $allowedImgExt = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico');
    protected $allowedImgSize = array(
        '50_50' => '50_50',
        '80_80' => '80_80',
        '100_100' => '100_100',
        '150_150' => '150_150',
        '180_180' => '180_180',
        '200_200' => '200_200',
        '300_300' => '300_300',
        '400_400' => '400_400',
        '500_500' => '500_500',
        '600_600' => '600_600',
        '700_700' => '700_700',
        '800_800' => '800_800',
    );

    public function getAllowedImgSize() {
        return $this->allowedImgSize;
    }

    /**
     * base DIR folder to upload
     */
    public function getBaseDir() {
        if (self::STATIC_FOLDER_NAME) {
            return DS . '..' . DS . self::STATIC_FOLDER_NAME . DS . 'media' . DS;
        } else {
            return DS . 'media' . DS;
        }
    }

    /**
     * get base DIR for image folder
     */
    public function getBaseDirImage() {
        return $this->getBaseDir() . 'images' . DS;
    }

    /**
     * get base DIR for files
     */
    public function getBaseDirFile() {
        return $this->getBaseDir() . 'files' . DS;
    }

    /**
     * get base DIR for books
     */
    public function getBaseDirBook() {
        return $this->getBaseDir() . 'books' . DS;
    }

    /**
     * get base DIR default
     */
    public function getBaseDirDefault() {
        switch ($this->uploadType) {
            case self::UPLOAD_IMAGE: return $this->getBaseDirImage();
            default :return $this->getBaseDirFile();
        }
    }

    /**
     * true: create thumb
     * false: not create thumb
     * default is true
     * 
     * @var boolen
     */
    protected $createThumb = true;

    /**
     * dir upload
     */
    protected $dirUpload;

    /**
     * resize image object
     * 
     * @var Resize
     */
    protected $resizeModel;

    public function getUploadType() {
        return $this->uploadType;
    }

    public function getCreateThumb() {
        return $this->createThumb;
    }

    public function getPageCount() {
        return $this->pageCount;
    }

    public function getPathOut() {
        return $this->pathOut;
    }

    public function setUploadType($uploadType) {
        $this->uploadType = $uploadType;
    }

    public function setCreateThumb($createThumb) {
        $this->createThumb = $createThumb;
    }

    public function getResizeModel() {
        return $this->resizeModel;
    }

    public function getDirUpload() {
        return $this->dirUpload;
    }

    public function setDirUpload($dirUpload) {
        $this->dirUpload = $dirUpload;
    }

    public function setPageCount($pages = 0) {
        $this->pageCount = $pages;
    }

    public function setPathOut($path = '') {
        $this->pathOut = $path;
    }

    function getDefault_avatar_path() {
        return $this->default_avatar_path;
    }

    function getDefault_avatar_name() {
        return $this->default_avatar_name;
    }

    function getAllowedImgExt() {
        return $this->allowedImgExt;
    }

    function setDefault_avatar_path($default_avatar_path) {
        $this->default_avatar_path = $default_avatar_path;
    }

    function setDefault_avatar_name($default_avatar_name) {
        $this->default_avatar_name = $default_avatar_name;
    }

    function setAllowedImgExt($allowedImgExt) {
        $this->allowedImgExt = $allowedImgExt;
    }

    function getAssetPath() {
        return $this->assetPath;
    }

    function setAssetPath($assetPath) {
        $this->assetPath = $assetPath;
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * construct
     */
    public function __construct($_FILE) {
        if (isset($_FILE['tmp_name'])) {
            /**
             * set defaul values
             */
            $this->SetFileName($_FILE['name']);
            $this->SetTempName($_FILE['tmp_name']);
            $this->resizeModel = new Resize();
            //$this->setErrors('name_empty');
            //return false;
        }
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * start upload images
     *  + set some default value like maxumum file size, SetValidExtensions
     *  + set SetUploadDirectory
     * @param type $server_path
     * @return boolen
     */
    public function save() {
        /* set max file size */
        if ($this->MaximumFileSize > self::MAX_FILE_SIZE) {
            $this->MaximumFileSize = self::MAX_FILE_SIZE;
        }
        switch ($this->uploadType) {
            case self::UPLOAD_IMAGE: {
                    /* set allowed extension */
                    if (!$this->ValidExtensions) {
                        $this->SetValidExtensions($this->allowedImgExt);
                    }
                    $this->SetUploadDirectory($this->getBaseDirImage());
                }break;
            case self::UPLOAD_BOOK: {
                    $this->SetUploadDirectory($this->getBaseDirBook());
                }break;
            case self::UPLOAD_FILES:
            default : {
                    $this->SetUploadDirectory($this->getBaseDirFile());
                }break;
        }
        /* set dir to upload */
        $this->buildDirFromParam();
        /* start upload */
        $result = $this->UploadFile();
        /* if createThumb is true and type upload is image, start creating thumb */
        if ($this->createThumb && $this->resizeModel && $this->uploadType == self::UPLOAD_IMAGE) {
            try {
                $this->resizeModel->setImageFile($this->getFullDir() . $this->FileName);
            } catch (Exception $e) {
                //  $this->resizeModel = null;
            }
        }

        return $result;
    }

    /**
     * @method returns $awhether the extension of file to be uploaded
     *    is allowable or not.
     * @return true the extension is valid.
     * @return false the extension is invalid.
     */
    function ValidateExtension() {

        $FileName = trim($this->FileName);
        if ($FileName) {
            $FileParts = pathinfo($FileName);
            $this->FileExtension = strtolower($FileParts['extension']);
            $this->setOriginalBaseName($FileParts['filename']);
            $ValidExtensions = $this->ValidExtensions;

            if (!$this->ValidateExtensionFromSystem() || (is_array($ValidExtensions) && count($ValidExtensions) > 0 && !in_array($this->FileExtension, $ValidExtensions))) {
                $this->setErrors('extension');
                return false;
            }
            return true;
        }
        $this->setErrors('name_empty');
        return false;
    }

    /**
     * valiate file extension from array extension that system allow $this->mime_types
     * need FileExtension is setted
     * @return true if this file mine type is valid
     */
    function ValidateExtensionFromSystem() {
        $ext = $this->FileExtension;
        if ($ext != '' && isset($this->mime_types[$ext])) {
            return true;
        }
        return false;
    }

    /**
     * @method returns $whether the file size is acceptable.
     * @return true the size is smaller than the alloted value.
     * @return false the size is larger than the alloted value.
     */
    function ValidateSize() {
        $MaximumFileSize = $this->MaximumFileSize;
        $TempFileName = $this->GetTempName();
        if ($TempFileName) {
            $TempFileSize = filesize($TempFileName);
            $this->FileSize = $TempFileSize;
            if (is_numeric($MaximumFileSize) && $MaximumFileSize <= $TempFileSize) {
                $this->setErrors('over_size');
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @method determins whether the file already exists. If so, rename $FileName.
     * @return true can never be returned as all file names must be unique.
     * @return false the file name does not exist.
     */
    function ValidateExistance() {
        $FileName = $this->FileName;
        $UploadDirectory = $this->UploadDirectory;
        $File = $UploadDirectory . $FileName;
        /* save original file name */
        $this->OriginalName = $FileName;

        if (!$this->IsOverride && $FileName != '' && file_exists($File)) {
            $this->setErrors('file_exist');
            return false;
        } else {
            $newName = '';
            if ($this->getUploadType() == self::UPLOAD_IMAGE) {
                $originBaseName = $this->getOriginalBaseName();
                $newBaseName = HtmlFormat::parseToAlias($originBaseName) . '-' . time();
                if ($newBaseName) {
                    $newName = $newBaseName . '.' . $this->FileExtension;
                }
            }
            if (!$newName) {
                $newName = rand(1, 1000) . '_' . time() . '_' . uniqid(rand(10, 1000), false) . '.' . $this->FileExtension;
            }
            $this->SetFileName($newName);
        }
        return TRUE;
    }

    /**
     * @method  uploads the file to the server after passing all the validations.
     * @validate file with :   
     *  + validate extension
     *  + validate size
     *  + validate existance
     *  + validate image source
     * @debug   
      //         var_dump($this->ValidateExtension(),
      //          $this->ValidateSize(),
      //          $this->ValidateExistance(),
      //           $this->ValidateImage());
     * @return true the file was uploaded.
     * @return false the upload failed.
     */
    function UploadFile() {
        if ($this->ValidateExtension() && $this->ValidateSize() && $this->ValidateExistance() && $this->ValidateImage()) {
            $FileName = $this->FileName;
            $TempFileName = $this->TempFileName;
            $UploadDirectory = $this->getFullDir(); //var_dump($FileName,$TempFileName,$UploadDirectory);die('ss');
            /* create dir */
            $this->createDirectory();
            if (@copy($TempFileName, $UploadDirectory . $FileName)) {
                if (in_array($this->FileExtension, array('jpg', 'jpeg', 'bmp'))) {
                    $this->getResizeModel()->setImageFile($UploadDirectory . $FileName);
                    list($Width, $Height) = $this->GetImageSize;
                    if ($Width > $this->maxImageSizeWidth || $Height > $this->maxImageSizeHeight) {
                        $this->getResizeModel()->width = $this->maxImageSizeWidth;
                        $this->getResizeModel()->height = $this->maxImageSizeHeight;
                        //
                        $this->getResizeModel()->inframeResize();
                        //
                        if (!$this->getResizeModel()->save($UploadDirectory . $FileName)) {
                            @unlink($UploadDirectory . $FileName);
                            return false;
                        }
                    }
                }
                //
                if ($this->getUploadType() == self::UPLOAD_BOOK) {
                    $this->loadLib('Unoconv');
                    $outputDirPath = $UploadDirectory . 'out' . DIRECTORY_SEPARATOR;
                    $this->rmkdir($outputDirPath);
                    $pdfName = $this->uniqueName();
                    $pdfFile = $UploadDirectory . $pdfName . '.pdf';
                    if ($this->getFileExtension() == 'pdf') {
                        $topdf = true;
                        $pdfFile = $UploadDirectory . $pdfName . '.pdf';
                        @copy($UploadDirectory . $FileName, $pdfFile);
                    } else {
                        $unoconv = new Unoconv($UploadDirectory . $FileName);
                        $unoconv->setOutput($pdfFile);
                        $unoconv->setPageRange('1-3');
                        $topdf = $unoconv->convert();
                    }
                    if ($topdf) {
                        $this->loadLib('Pdf2HtmlEx');
                        $pdf2html = new Pdf2HtmlEx($pdfFile);
                        $pdf2html->setDestDir($outputDirPath);
                        $pdf2html->setSplitPage(1);
                        $pdf2html->setFistPage(1);
                        $pdf2html->setLastPage(3);
                        $tohtml = $pdf2html->convert();
                        if (!$tohtml) {
                            @unlink($pdfFile);
                            $this->setErrors('file_cannot_convert_tohtml');
                            return FALSE;
                        }
                        //
                        // create avatar
                        $_avatarName = $this->uniqueName();
                        $avatarPath = $this->getBaseDirImage() . 'book' . DS . date('Y') . DS . date('m') . DS;
                        $this->rmkdir($this->getCurrentDir() . $avatarPath);
                        $avatarName = $_avatarName . '.jpg';
                        $this->loadLib('Pdf2Image');
                        $pdf2image = new Pdf2Image($pdfFile);
                        $pdf2image->setToFormat('jpg');
                        $pdf2image->setDestDir($this->getCurrentDir() . $avatarPath);
                        $pdf2image->setImageName($avatarName);
                        if ($pdf2image->convertFirstPage()) {
                            $this->setDefault_avatar_path($this->removeExtraName($avatarPath));
                            $this->setDefault_avatar_name($avatarName);
                        }
                        //
                        $this->delUnnecessaries($pdfName, $outputDirPath);
                        // Move file style, font to files folder
                        $assetName = $this->getUniqueCode();
                        $assetPath = $this->getBaseDirFile() . 'book' . DS . date('Y') . DS . date('m') . DS . $assetName . DS;
                        if ($this->rmkdir($this->getCurrentDir() . $assetPath)) {
                            $this->loadLib('ScanDir');
                            $scanDir = new ScanDir($outputDirPath);
                            $scanDir->setExtFilters(array('css', 'woff'));
                            $scanDir->scan();
                            $files = $scanDir->getFiles();
                            foreach ($files as $file) {
                                if (@copy($outputDirPath . $file, $this->getCurrentDir() . $assetPath . $file)) {
                                    @unlink($outputDirPath . $file);
                                }
                            }
                            $assetPath = $this->removeExtraName($assetPath);
                            $this->setAssetPath($assetPath);
                        }
                        // get pdf page count
                        $this->setPageCount($this->getPdfPages($pdfFile));
                        $this->setPathOut($this->GetUploadDirectory() . 'out' . DIRECTORY_SEPARATOR);
                        @unlink($pdfFile);
                    } else {
                        //$this->setErrors('file_cannot_convert_topdf');
                        $this->setErrors($unoconv->getErrors());
                        return false;
                    }
                }
                //
                return true;
            }
        }
        return false;
    }

    //
    function delUnnecessaries($name = '', $path = '') {
        @unlink($path . $name . '.html');
        @unlink($path . $name . '.outline');
    }

    //

    /**
     * @minhbn <minhcoltech@grmail.com>
     * render file thumb name
     * Dir is:
     *  + if resize with width and height. Folder name is started with prefix 's'
     *  + if resize crop. Folder name is started with prefix 'c'
     *  + folder located in folder of original file
     * @return array  
     */
    public function renderFileThumb($size = array()) {
        $count = count($size);
        $dir = $this->GetUploadDirectory();
        $folderResize = null;
        $thumbname = $this->getOriginalFileName() . '.' . $this->getFileExtension();
        if ($count == 1) {
            $folderResize = self::PRE_FIX_FOLDER_RESIZE . array_shift($size);
        } else if ($count == 2) {
            list($w, $h) = $size;
            $w = intval($w);
            $h = intval($h);
            $folderResize = self::PRE_FIX_FOLDER_RESIZE . $w . '_' . $h;
        } else if ($count > 2) {
            list($x1, $x2, $y1, $y2) = $size;
            $x1 = intval($x1);
            $x2 = intval($x2);
            $y1 = intval($y1);
            $y2 = intval($y2);
            $folderResize = self::PRE_FIX_FOLDER_CROP . $x1 . '_' . $x2 . '_' . $y1 . '_' . $y2;
        }
        $dir = $dir . $folderResize . DS;

        return array(
            'fulldir' => __DIR__ . $dir . $thumbname,
            'folder' => $folderResize,
            'file' => $thumbname
        );
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * get file name without extension
     * 
     * @param string name
     */
    public function getOriginalFileName() {
        $path = pathinfo($this->FileName);
        return isset($path['filename']) ? $path['filename'] : null;
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * create dir from array to upload
     * @param Uploadhandel dirUpload
     * @return string dir
     */
    public function buildDirFromParam() {
        $dir = $this->GetUploadDirectory();
        if (is_array($this->dirUpload)) {
            $dir .= implode(DS, $this->dirUpload) . DS;
        }
        $this->SetUploadDirectory($dir);
    }

    /**
     * validate image ext 
     * @param type $ext
     * @return boolean
     */
    public function validateImageExtension($ext = '') {
        return true;
        if ($ext) {
            if (in_array($ext, $this->allowedImgExt))
                return true;
        }
        return false;
    }

    /**
     * Validate image size 
     * @param type $width
     * @param type $height
     * @return boolean
     */
    public function ValidateImageSize($width = 0, $height = 0) {
        $width = (int) $width;
        $height = (int) $height;
        if (isset($this->allowedImgSize[$width . '_' . $height]))
            return true;
        return false;
    }

    function getCurrentDir() {
        return realpath(__DIR__);
    }

    /**
     * 
     */
    function getRealUploadDir() {
        $dirUpload = $this->GetUploadDirectory();
        $dir = $this->removeExtraName($dirUpload);
        return $dir;
    }

    /**
     * 
     * @return type
     */
    function getRealOutDir() {
        $dirOut = $this->getPathOut();
        $dir = $this->removeExtraName($dirOut);
        return $dir;
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    function removeExtraName($str = '') {
        if ($str) {
            $str = str_replace(DS . '..' . DS . self::STATIC_FOLDER_NAME, '', $str);
        }
        return $str;
    }

}
