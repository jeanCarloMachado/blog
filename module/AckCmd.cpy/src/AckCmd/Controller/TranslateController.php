<?php
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
class TranslateController extends ConsoleBase
{
    public function indexAction()
    {
                $request = $this->getRequest();

                // Make sure that we are running in a console and the user has not tricked our
                // application into running this action from a public web server.
                if (!$request instanceof ConsoleRequest) {
                    throw new \RuntimeException('You can only use this action from a console!');
                }

                echo "Gestão de traduções";
        }

    public function addAction()
    {
        echo "Adicionar uma entrada de tradução\n";

        $translateFileName = "src/translate.php";

        $filePhp = new \AckCore\Utils\File($translateFileName);
        $filePhp->open();
        $phpContent = $filePhp->read();
        $filePhp->close();

        echo "Rotina para inserir uma nova tradução\n";

        echo "\nDigite a chave da tradução: ";
        $key = fgets(STDIN);
        System_Object_String::sanitize($key);
        if(!empty($key))
            $key = "'$key'";

        echo "\nDigite a versão em português: ";
        $pt = fgets(STDIN);
        System_Object_String::sanitize($pt);

        echo "\nDigite a versão em inglês: ";
        $en = fgets(STDIN);
        System_Object_String::sanitize($en);

        $replaceWith = '$trl["pt"]['.$key.']="'.$pt.'";'."\n".'//#HASH_PT';
        $phpContent = str_replace("//#HASH_PT",$replaceWith, $phpContent);

        $replaceWith = '$trl["en"]['.$key.']="'.$en.'";'."\n".'//#HASH_EN';
        $phpContent = str_replace("//#HASH_EN",$replaceWith, $phpContent);

        $filePhpWrite = new \AckCore\Utils\File($translateFileName);
        $filePhpWrite->open("w")->write($phpContent)->save()->close();

    }
}
