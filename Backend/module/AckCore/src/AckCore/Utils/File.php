<?php
namespace AckCore\Utils;
class File
{
    protected $_type;
    protected $fullName;
    protected $str;
    protected $handle;
    /**
     * retorna a extensão de uma string
     * @param  [type] $fileName [description]
     * @return [type] [description]
     */
    public static function removeExtension($fileName)
    {
        assert(0,"esta função não está completamente implementada, ao certo ela deveria dar um re-join do array sem o último elemento");
        $file = explode(".",$fileName);

        if(!is_array($file))

            return null;

        return reset($file);
    }
    /**
     * retorna a extensão de uma string
     * @param  [type] $fileName [description]
     * @return [type] [description]
     */
    public static function extension($fileName)
    {
        $file = explode(".",$fileName);

        return end($fileName);
    }

    public static function getFileStr($str)
    {
        $str = explode("/",$str);

        return end($str);
    }
    public static function getInstance($path)
    {
        $class = get_called_class();

        return new $class($path);
    }

    public function __construct($path)
    {
        $this->setPath($path);
        /**
         * pega o tipo do arquivo à partir do path
         */
        $this->fullName = $path;
        $arr = explode('.',$path);
        $arr = array_reverse($arr);
        $this->setType($arr[0]);
    }
    /**
     * abre o arquivo
     * @param  string a+ == abre e concatena no final
     * @param  string w+ ==  abre  e limpa o arquivo e prepara para a escrita
     * @return [type] [description]
     */
    public function open($openMethod = "a+")
    {
        $user = get_current_user();
        exec("touch $this->fullName");
            exec("chown $user $this->fullName");
            exec("chmod +rw $this->fullName");

        $this->handle = fopen($this->fullName,$openMethod);
        if(!$this->handle)
            throw new \Exception("Não conseguiu abrir o arquivo ".$this->fullName);

        return $this;
    }

    public function read()
    {
        $content = stream_get_contents($this->handle);

        return $content;
    }

    public function save()
    {
        $result = fwrite($this->handle,$this->str,strlen($this->str));
        if(!$result)
            throw new \Exception("Não conseguiu salvar o arquivo.");

        return $this;
    }

    public function write($str)
    {
        if(empty($str))
            throw new \Exception("No data sent");

        $this->str = $str;

        return $this;
    }

    public function close()
    {
        fclose($this->handle);

        return $this;
    }

    /**
     * seta o tipo de um arquivo
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * pega o tipo de um arquivo
     * @param string $type [description]
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * seta o caminho do arquivo (deve contér o nome também)
     * @param [type] $path [description]
     */
    public function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * pega o caminho do arquivo (contém o nometambém)
     * @return [type] [description]
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * seta permissao
     * @param  [type] $permission [description]
     * @param  [type] $file       [description]
     * @param  [type] $params     [description]
     * @return [type] [description]
     */
    public static function chmod($permission,$file,$params=null)
    {
        $files = glob($file);
        if(empty($files))  return false;

        foreach ($files as $file) {
            chmod ($file, $permission);
        }

        return true;
    }

    /**
     * remove arquivos
     * @param  [type] $params [description]
     * @param  [type] $file   [description]
     * @return [type] [description]
     */
    public static function rm($file,$params=null)
    {
        $files = glob($file);

        if(empty($files))

            return false;

        foreach ($files as $file) {
            if (is_file($file)) {
                @chmod($file, 0777);
                @unlink($file);
            }
        }

        return true;
    }

    public static function forceDownload($file_name)
    {
        // grab the requested file's name
        // make sure it's a file before doing anything!
        if (is_file($file_name)) {

            /*
                Do any processing you'd like here:
                1.  Increment a counter
                2.  Do something with the DB
                3.  Check user permissions
                4.  Anything you want!
            */

            // required for IE
            if (ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

            // get the file mime type using the file extension
            switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
                case 'pdf': $mime = 'application/pdf'; break;
                case 'zip': $mime = 'application/zip'; break;
                case 'jpeg':
                case 'jpg': $mime = 'image/jpg'; break;
                default: $mime = 'application/force-download';
            }
            header('Pragma: public'); 	// required
            header('Expires: 0');		// no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
            header('Cache-Control: private',false);
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($file_name));	// provide file size
            header('Connection: close');
            readfile($file_name);		// push it out

            return true;

        }

        return false;
    }

    public static function create_zip($files = array(),$destination = '',$overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if ($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file,$file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

}
