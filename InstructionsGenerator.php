<?php

/**
 * Class InstructionsGenerator
 */
class InstructionsGenerator {

    /** @var int */
    private $minSteps;

    /** @var int */
    private $maxSteps;

    /**
     * InstructionsGenerator constructor.
     *
     * @param int $minSteps
     * @param int $maxSteps
     */
    public function __construct($minSteps = 10, $maxSteps = 100) {
        $this->minSteps = $minSteps;
        $this->maxSteps = $maxSteps;
    }

    /**
     * @return int[]
     * @throws Exception
     */
    public function generate() {
        $result = [];
        do {
            $count = count($result);
            $maxInt = InstructionsEnum::INSTRUCTIONS_LOOP;
            if ($count < $this->minSteps) {
                $maxInt = InstructionsEnum::INSTRUCTIONS_SKIP_NEXT;
            }
            if ($count >= $this->maxSteps) {
                $instruction = InstructionsEnum::INSTRUCTIONS_LOOP;
            } else {
                $instruction = random_int(InstructionsEnum::INSTRUCTIONS_LEFT, $maxInt);
            }
            $result[] = $instruction;
        } while ($instruction !== InstructionsEnum::INSTRUCTIONS_LOOP);
        return $result;
    }

    /**
     * @param int[] $instructions
     * @param string $otherRobotDivergence
     * @param int $myStart
     * @param int $otherRobotsStart
     * @return int[]
     */
    public function tweak(array $instructions, $otherRobotDivergence, $myStart, $otherRobotsStart) {
        $divergenceCalculator = new DivergenceCalculator();
        while (true) {
            $divergence = $divergenceCalculator->calculate($instructions, $myStart, $otherRobotsStart);
            if (bccomp($divergence, $otherRobotDivergence, 10) === -1) {
                break;
            }
            array_splice($instructions, count($instructions) - 1, 0, InstructionsEnum::INSTRUCTIONS_LEFT);
        }
        return $instructions;
    }

}