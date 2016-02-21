<?php

use phpDocumentor\Reflection\DocBlock\Tag;

class SignatureTag extends Tag
{
    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        if (null === $this->content) {
            $this->content = "{$this->signature} {$this->description}";
        }

        return $this->content;
    }
}
