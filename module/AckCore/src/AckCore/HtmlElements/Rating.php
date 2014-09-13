<?php
namespace AckCore\HtmlElements;
class Rating extends ElementAbstract
{
    protected static $resourcesIncluded = false;

    public static function resources()
    {
        if(!self::$resourcesIncluded) :
        ?>
          <script type="text/javascript" src="/plugins/devil/raty-2.5.2/lib/jquery.raty.js"></script>
        <?php
            self::$resourcesIncluded = true;
        endif;
    }

    public function defaultLayout()
    {
        $this->resources();
        ?>

        <div class="<?php echo $this->parentClasses; ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <input type="hidden" autocomplete="off" <?php echo $this->composeName() ?>  id="rating-<?php echo $this->getName(); ?>" value="<?php echo $this->getValue() ?>"/>

                <div id="star" data-score="5"></div>
        </div>

            <script type="text/javascript">
            $('#star').raty({
                score: <?php echo $this->getValue() ?>,
                click: function (score, evt) {
                    document.getElementById("rating-<?php echo $this->getName(); ?>").value=score;
                }
            });
            </script>
        <?php
    }

}
