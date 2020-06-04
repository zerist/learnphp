<?php

class authorControl
{
    public function message(leaveModel $leaveModel, gbookModel $gbookModel, message $message)
    {
        $leaveModel->write($gbookModel, $message);
    }

    public function view(gbookModel $gbookModel)
    {
        return $gbookModel->read();
    }

    public function delete(gbookModel $gbookModel)
    {
        $gbookModel->delete();
        echo self::view($gbookModel);
    }
}
