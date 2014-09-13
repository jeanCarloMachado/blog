<?php
namespace AckCore\HtmlElements;

class TextEditor extends ElementAbstract
{
    protected static $resourcesIncluded = false;
    protected $markdown = false;

    public function resources()
    {
        if (!$this->markdown) {

            $this->getHeadScript()->offsetSetFile(7,"/plugins/tinymce/js/tinymce/tinymce.min.js");

            if(!self::$resourcesIncluded) :
            ?>
                <script>
                tinymce.init({
                    selector: ".textEditor",
                         plugins: [
                         "advlist autolink lists link image charmap print preview anchor",
                         "searchreplace visualblocks code fullscreen",
                         "insertdatetime media table contextmenu paste jbimages"
                         ],
                         toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
                         relative_urls: false
                         });

                </script>
            <?php
                self::$resourcesIncluded = true;
            endif;

        } else {

            if (!self::$resourcesIncluded) :
            ?>
            <link rel="stylesheet" href="http://lab.lepture.com/editor/editor.css" />
            <script type="text/javascript" src="http://lab.lepture.com/editor/editor.js"></script>
            <script type="text/javascript" src="http://lab.lepture.com/editor/marked.js"></script>
            <?php
            endif;
        }
    }

    public function defaultLayout()
    {
        $this->resources();

        if (!$this->markdown) :
?>
        <div class="<?php echo $this->parentClasses; ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
               <textarea class="textEditor" <?php echo $this->composeName() ?> rows="5" cols="50"><?php echo $this->getValue() ?></textarea>
        </div>
<?php
        else :
?>
        <textarea id="id-<?php echo $this->getName(); ?>"  <?php echo $this->composeName() ?> rows="30" cols="115"><?php echo $this->getValue() ?></textarea>

        <script>
        var editor = new Editor();
        editor.render();

        document.addEventListener("devilSearchingData", function (e) {

            document.getElementById('id-<?php echo $this->getName(); ?>').value = editor.codemirror.getValue();
        });

        </script>

<?php
        endif;

    }

    /**
     * getter de Markdown
     *
     * @return Markdown
     */
    public function getMarkdown()
    {
        return $this->markdown;
    }

    /**
     * setter de Markdown
     *
     * @param int $markdown
     *
     * @return $this retorna o próprio objeto
     */
    public function setMarkdown($markdown)
    {
        $this->markdown = $markdown;

        return $this;
    }
}
