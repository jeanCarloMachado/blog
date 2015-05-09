<?php
namespace AckCore\Utils;
class Image
{
//const OBJECT_NAME = '005';
//const EDIT_STATUS = '007';
//const PRIORITY = '010';
//const CATEGORY = '015';
//const SUPPLEMENTAL_CATEGORY = '020';
//const FIXTURE_IDENTIFIER = '022';
  const KEYWORDS = '025';
//const RELEASE_DATE = '030';
//const RELEASE_TIME = '035';
//const SPECIAL_INSTRUCTIONS = '040';
//const REFERENCE_SERVICE = '045';
//const REFERENCE_DATE = '047';
//const REFERENCE_NUMBER = '050';
  const CREATED_DATE = '055';
  const CREATED_TIME = '060';
//const ORIGINATING_PROGRAM = '065';
//const PROGRAM_VERSION = '070';
//const OBJECT_CYCLE = '075';
const BYLINE = '080'; //Fotógrafo
//const BYLINE_TITLE = '085';
//const CITY = '090';
//const PROVINCE_STATE = '095';
//const COUNTRY_CODE = '100';
//const COUNTRY = '101';
//const ORIGINAL_TRANSMISSION_REFERENCE = '103';
const HEADLINE = '105'; //Vai ser Tag
const CREDIT = '110';
//const SOURCE = '115';
//const COPYRIGHT_STRING = '116';
//const CAPTION = '120';
//const LOCAL_CAPTION = '121';

private $fileName = null;
private $metaCache = null;

public function __construct($fileName = null)
{
  $this->fileName = $fileName;
}
/**
* retorna um array com os dados de info
* @return multitype:|boolean
*/
public function getAllInfo()
{
  if($this->metaCache)

    return $this->metaCache;
  $size = getimagesize($this->getFullFileName(),$info);

  if (is_array($info)) {
    $this->metaCache = iptcparse($info["APP13"]);

    return $this->metaCache;
  }

  return false;
}

/**
* retorna os dados da constante passada
*/
public function getInfoByConst($key)
{
  $metaCache = $this->getAllInfo();

  $result = $metaCache["2#".$key] ? $metaCache["2#".$key] : null;

  if(is_array($result) && count($result) == 1)

    return reset($result);

  return $result;
}

public function getFileName()
{
  $fileName = explode("/", $this->fileName);

  return end($fileName);
}

public function getFullFileName()
{
  return $this->fileName;
}

  public static function getImagickInstance($file_name)
  {
      $im = new Imagick();

      $config['width_threshold'] = 8388600;
      $config['height_threshold'] = 8388600;

      $im->pingImage($file_name);

      $width  = $im->getImageWidth();
      $height = $im->getImageHeight();
      if ($width > $config['width_threshold'] || $height > $config['height_threshold']) {
        try {
    /* send thumbnail parameters to Imagick so that libjpeg can resize images
    * as they are loaded instead of consuming additional resources to pass back
    * to PHP.
    */
    $fitbyWidth = ($config['width_threshold'] / $width) > ($config['height_threshold'] / $height);
    $aspectRatio = $height / $width;
    if ($fitbyWidth) {
      $im->setSize($config['width_threshold'], abs($width * $aspectRatio));
    } else {
      $im->setSize(abs($height / $aspectRatio), $config['height_threshold']);
    }
    $im->readImage($file_name);

    /* Imagick::thumbnailImage(fit = true) has a bug that it does fit both dimensions
    */
    //  $im->thumbnailImage($config['width_threshold'], $config['height_threshold'], true);

    // workaround:
    if ($fitbyWidth) {
      $im->thumbnailImage($config['width_threshold'], 0, false);
    } else {
      $im->thumbnailImage(0, $config['height_threshold'], false);
    }

    $im->setImageFileName($thumbnail_name);
    $im->writeImage();
    } catch (ImagickException $e) {
      header('HTTP/1.1 500 Internal Server Error');
      throw new \Exception(_('An error occured reszing the image.'));
    }
    }

    return $im;
  }

  public static function getExtensionByName($name)
  {
    $name = explode(".",$name);

    return end($name);
  }
}
