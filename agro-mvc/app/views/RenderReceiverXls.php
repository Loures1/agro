<?php

class RenderReceiverXls
{
    public function view($htmlFileName)
    {
        echo file_get_contents($htmlFileName);
    }
}