<?php
namespace AckContent\View\Helper;
use Zend\View\Helper\AbstractHelper;
class NotificationBlock extends AbstractHelper
{
    protected static $instance;
    protected $messages = array();

    public static function getInstance()
    {
        if(!self::$instance)
            self::$instance = new self;

        return self::$instance;
    }

    public function hasMessages()
    {
        if(!empty($this->messages)) return true;

        return false;
    }

    protected function __construct()
    {
    }

    public function error($message)
    {
        $this->append($message,E_USER_ERROR);

        return $this;
    }

    public function notice($message)
    {
        $this->append($message,E_NOTICE);

        return $this;
    }

    public function info($message)
    {
        $this->append($message,E_NOTICE);

        return $this;
    }

    public function success($message)
    {
        $this->append($message);

        return $this;
    }

    public function __invoke(array $messages = null)
    {

        if(empty($messages)) $messages = $this->getMessages();

        return $this;
    }

    public function render()
    {
       if(!empty($this->messages)) :
           foreach($this->messages as $message) :

              $content = $message['message'];
              $content = (is_array($content)) ? reset($content) : $content;
              $content = (is_array($content)) ? reset($content) : $content;
              $content = (is_array($content)) ? reset($content) : $content;

            if (isset($message['type']) && $message['type'] == E_USER_ERROR):
            ?>
                <div class="alert alert-danger notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <?php echo $content; ?>
                </div>
            <?php elseif (!isset($message['type'])): ?>
                <div class="alert alert-success notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <?php echo $content; ?>
                </div>
            <?php elseif(isset($message['type']) && $message['type'] == E_NOTICE): ?>
                <div class="alert alert-info notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                 <?php echo $content; ?>
                </div>
            <?php
            endif;
        endforeach;
        endif;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    public function append($message,$type = null)
    {
        $this->messages[] = array("message" => $message,"type"=>$type);

        return $this;
    }
}
