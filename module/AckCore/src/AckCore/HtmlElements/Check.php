<?php
namespace AckCore\HtmlElements;
class Check extends ElementAbstract
{
    protected $_url = null;
    protected $checked = false;

    public function defaultLayout()
    {
        $title = $this->getTitle();
        ?>

            <label style="display:inline">
                <?php if(($this->_url)) : ?>
                    <a class="modalTrigger" href="<?php echo $this->composeUrl() ?>" ><?php echo $title ?></a>
                <?php else : ?>
                    <input <?php echo $this->composeChecked() ?> type="checkbox" <?php echo $this->composeName() ?> value="<?php echo $this->getValue() ?>">
                    <em><?php echo $title ?></em>
                <?php endif; ?>
            </label>

        <?php
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setUrl($_url)
    {
        $this->_url = $_url;

        return $this;
    }

    public function getChecked()
    {
        return $this->checked;
    }

    public function composeUrl()
    {
        if(!empty($this->_url))

            return $this->_url;

        return "javascript:void(0);";
    }

    /**
     * retorna o html de acordo com o checked
     * @return [type] [description]
     */
    public function composeChecked()
    {
        if($this->getChecked())

            return 'checked = "CHECKED"';

        return '';
    }

    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }
}
