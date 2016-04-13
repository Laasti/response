<?php

namespace Laasti\Response;


trait ResponderAwareTrait
{
    /**
     * Responder instance
     * @var ResponderInterface
     */
    protected $responder;

    /**
     * Set responder instance
     * @param \Laasti\Response\ResponderInterface $responder
     * @return \Laasti\Response\ResponderInterface
     */
    public function setResponder(ResponderInterface $responder)
    {
        $this->responder = $responder;

        return $this->responder;
    }

    /**
     * Get responder instance
     * @return ResponderInterface
     */
    public function getResponder()
    {
        return $this->responder;
    }
}
