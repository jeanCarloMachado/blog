<?php
/**
 * elemento html que representa uma imagem a ser mostrada
 *
 * PHP version 5
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\HtmlElements;
class Image extends ElementAbstract
{
    protected $path;
    protected $galleryFolder = "/galeria/";
    protected $pathPrefix = "/plugins/thumb/phpThumb.php?src=";
    protected $file;
    protected $quality = 80;

    protected static $fileColumn = "arquivo";
    protected static $defaultImageName = "none.jpg";

    //variáveis do thumb
    /**
     * se o thumbEstá habilitado ou não
     * @var integer
     */
    protected $thumbStatus = 1;
    protected $thumbParams;
    protected $cropParams = "";
    //variáveis do crop
    protected $cropStatus = 1;

    public static function setupPath($obj = null,$params = null,$paramsWithoutCrop = null)
    {
        $instance = new self;

        if ($obj instanceof \AckDb\ZF1\RowAbstract) {
            $fileColumn = "get".self::$fileColumn;
            $file = $obj->$fileColumn()->getBruteVal();

            //tenta pegar o crop ("caso ele exista");
                $modelCrops = new \AckMultimidia\Model\Crops;
                $whereCrop = array("relacao_id"=>$obj->getId()->getVal());
                $resultCrop = $modelCrops->toObject()->getOne($whereCrop,array("order"=>"id desc"));
                /**
                 * se o crop retornou algum objeto adiciona o crop à url
                 */
                if (!empty($resultCrop)) {
                    $instance->cropParams.= "&aoe=1".
                    "&sx=".$resultCrop->getX()->getVal().
                    "&sy=".$resultCrop->getY()->getVal().
                    "&sw=".$resultCrop->getLargura()->getVal().
                    "&sh=".$resultCrop->getAltura()->getVal().
                    "&far=1&bg=ffffff";

                    if (!$resultCrop->getLargura()->getVal() && !$resultCrop->getAltura()->getVal())
                        $instance->cropParams.= $paramsWithoutCrop;

                } else {
                    $instance->cropParams.= $paramsWithoutCrop;
                }

        }

        if (empty($file)) {
            $instance->galleryFolder = "/img/site/";
            $file = self:: $defaultImageName;
        }

        $instance->setFile($file);
        $instance->setThumbParams($params);

        return $instance->makePath()->getPath();
    }

    // public function  makePath($obj = null,$params = null)
    // {
    // 	return self::makePath($obj,$params);
    // }

    public function makePath()
    {
        $this->path  = $this->pathPrefix.$this->galleryFolder.$this->file.$this->thumbParams.$this->cropParams."&q=".$this->quality;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function disableThumb()
    {
        $this->thumbStatus = 0;

        return $this;
    }

    public function enableThumb()
    {
        $this->thumbStatus = 1;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getThumbParams()
    {
        return $this->thumbParams;
    }

    public function setThumbParams($thumbParams)
    {
        $this->thumbParams = $thumbParams;

        return $this;
    }

    public function defaultLayout()
    {

    }

    public function metisLayout()
    {
        $this->defaultLayout;
    }

    public function getGalleryFolder()
    {
        return $this->galleryFolder;
    }

    public function setGalleryFolder($galleryFolder)
    {
        $this->galleryFolder = $galleryFolder;

        return $this;
    }

    public function disableCrop()
    {
        $this->cropStatus = 0;

        return $this;
    }

    public function enableCrop()
    {
        $this->cropStatus = 1;

        return $this;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }
}
