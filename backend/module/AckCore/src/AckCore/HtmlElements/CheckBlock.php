<?php
namespace AckCore\HtmlElements;

class CheckBlock extends ElementAbstract
{
    protected $checks = array();

    public function defaultLayout()
    {
        ?>
            <div class="slide">
                    <div class="scrollLista">
                        <div class="header"><h4><?php echo $this->getTitle() ?></h4></div>
                            <ul class="list-group">
                                <?php foreach($this->getChecks() as $check) : ?>
                                <li class="list-group-item">
                                    <?php $check->render(); ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                    </div><!-- END scrollLista -->
                </div>
        <?php
    }

    public function getChecks()
    {
        return $this->checks;
    }

    public function setChecks($checks)
    {
        $this->checks = $checks;

        return $this;
    }
}
