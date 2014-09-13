<?php
namespace AckCore\Utils;
class Directory
{
    protected $path;
    /**
     * lista todos os arquivos de um diretório
     * @param  [type] $path [description]
     * @return [type] [description]
     */
    public static function listAllFiles($path)
    {
        if(!file_exists($path))

          return false;

        $result = null;
            if ($handle = opendir($path)) {
                $result = array();
                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {
                   $result[] = $entry;
                }

            closedir($handle);
        }

        return $result;
    }
    /**
     * retorna o caminho
     * @return [type] [description]
     */
    public function getPath()
    {
        return $this->path;
    }
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
  /**
   * deleta um diretório e seus filhos
   * @param  [type] $dir [description]
   * @return [type]      [description]
   */
  public static function deleteDirectory($dir)
  {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') continue;
      if (!self::deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
    }

    return rmdir($dir);
  }
  /**
   * copia um diretório recursivamente
   * @param  [type] $sourceDir [description]
   * @param  [type] $targetDir [description]
   * @return [type]            [description]
   */
  public static function copyDirectory($sourceDir, $targetDir)
  {
    if (!file_exists($sourceDir)) return false;
    if (!is_dir($sourceDir)) return copy($sourceDir, $targetDir);
    if (!mkdir($targetDir)) return false;
    foreach (scandir($sourceDir) as $item) {
      if ($item == '.' || $item == '..') continue;
      if (!self::copyDirectory($sourceDir.DIRECTORY_SEPARATOR.$item, $targetDir.DIRECTORY_SEPARATOR.$item)) return false;
    }

    return true;
  }
}
