<?php class QueuePosition
{
    public $id;
    public $date;
    public $active;
    public $queueroom_id;
    public $user_id;

}

class UserJoinedQueuePosition extends QueuePosition
{
    public $email;
    public $username;

}
?>