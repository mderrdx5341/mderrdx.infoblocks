<?php
namespace Mderrdx\Infoblocks;

class FileImage extends File
{
    private $id;
    private $fileData;

    public function __construct($id)
    {
        $this->id = $id;
        $this->fileData();
    }

    public function value()
    {
        $this->id;
    }

    public function url()
    {

        return $this->fileData['SRC'];
    }

    /**
     * $type = BX_RESIZE_IMAGE_PROPORTIONAL | BX_RESIZE_IMAGE_EXACT
     */

    public function resizeUrl($width, $height, $type = 'BX_RESIZE_IMAGE_PROPORTIONAL')
    {
        $resizedImage = \CFile::ResizeImageGet($this->id, ['width' => $width, 'height' => $height], $type);
        return $resizedImage['src'];
    }

    private function fileData()
    {
        $this->fileData = \CFile::GetById($this->id)->getNext();
    }
}
