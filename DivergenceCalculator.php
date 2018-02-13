<?php

/**
 * Class DivergenceCalculator
 */
class DivergenceCalculator {

    /**
     * @param int[] $instructions
     * @param int $myStart
     * @param int $otherRobotsStart
     * @return string
     */
    public function calculate(array $instructions, $myStart, $otherRobotsStart) {
        $position = $previousPosition = $loopStart = $myStart;
        $startDiff = abs($myStart - $otherRobotsStart);
        $loops = 0;
        $skip = false;
        do {
            $leftmost = $rightmost = $loopStart;
            foreach ($instructions as $instruction) {
                list($skip, $position, $leftmost, $rightmost) = $this->oneStep(
                    $instruction, $skip, $position, $myStart, $otherRobotsStart, $leftmost, $rightmost
                );
            }
            $loops += 1;
            $relativeDivergence = $position - $previousPosition;
            $loopStart = $relativeDivergence + $loopStart;
            if ($previousPosition === $position) {
                break;
            }
            $previousPosition = $position;
        } while ($rightmost >= 0 && $leftmost <= $startDiff);
        return bcdiv($relativeDivergence, count($instructions), 10);
    }


    /**
     * @param int $instruction
     * @param bool $skip
     * @param int $position
     * @param int $myStart
     * @param int $otherRobotsStart
     * @param int $leftmost
     * @param int $rightmost
     * @return int[]
     */
    private function oneStep($instruction, $skip, $position, $myStart, $otherRobotsStart, $leftmost, $rightmost) {
        $newSkip = false;
        switch ($instruction) {
            case InstructionsEnum::INSTRUCTIONS_LEFT:
                if (!$skip) {
                    $position -= 1;
                }
                if ($position < $leftmost) {
                    $leftmost = $position;
                }
                break;
            case InstructionsEnum::INSTRUCTIONS_RIGHT:
                if (!$skip) {
                    $position += 1;
                }
                if ($position > $rightmost) {
                    $rightmost = $position;
                }
                break;
            case InstructionsEnum::INSTRUCTIONS_SKIP_NEXT:
                if (!$skip) {
                    $newSkip = $this->shouldSkip($position, $myStart, $otherRobotsStart);
                }
                break;
        }
        return [$newSkip, $position, $leftmost, $rightmost];
    }

    /**
     * @param int $position
     * @param int $myStart
     * @param int $otherRobotsStart
     * @return bool
     */
    private function shouldSkip($position, $myStart, $otherRobotsStart) {
        return $position === $myStart || $position === $otherRobotsStart;
    }

}