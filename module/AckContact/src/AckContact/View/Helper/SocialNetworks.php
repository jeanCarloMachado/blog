<?php
namespace AckContact\View\Helper;
use \AckCore\HtmlEncapsulated;
class SocialNetworks extends HtmlEncapsulated
{
    protected $url;
    protected $identifier;
    protected $cols = array(
        "facebook",
        "twitter",
    );

    public static function getInstance()
    {
        $class = get_called_class();

        return new $class;
    }

    public function render()
    {
         $system =  \AckCore\Model\Systems::getMainSystem();
         $layout = $this->getLayout();

        foreach ($this->cols as $col) {
            if (isset($system->vars[$col]) && $system->vars[$col]->getBruteVal()) {
                $this->setUrl($system->vars[$col]->getVal());
                $this->setIdentifier($col);
                $this->$layout();
            }
        }
    }

    public function defaultLayout()
    {
        ?>
        <p class="icon <?php echo $this->getIdentifier()?>"><a href="http://<?php echo $this->getUrl()?>" class="animate"><?php echo $this->getUrl()?></a></p>
        <?php
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
}
