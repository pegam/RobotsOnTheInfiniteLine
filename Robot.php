<?php

/**
 * Class Robot
 */
class Robot {

    /** @var int */
    private $startPosition;

    /**
     * Robot constructor.
     *
     * @param int $startPosition
     */
    public function __construct($startPosition) {
        $this->startPosition = $startPosition;
    }

    /**
     * @return int
     */
    public function getStartPosition() {
        return $this->startPosition;
    }

}