<?php

namespace Laasti\Response;

interface ResponderAwareInterface
{
    /**
     * @return ResponderInterface
     */
    public function getResponder();

    /**
     *
     * @param \Laasti\Response\ResponderInterface $responder
     * @return \Laasti\Response\ResponderInterface
     */
    public function setResponder(ResponderInterface $responder);
}
