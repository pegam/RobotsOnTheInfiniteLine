<?php

spl_autoload_register(function ($className) {
    /** @noinspection PhpIncludeInspection */
    require_once __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
});

try {
    $leftRobot = new Robot(0);
    $rightRobot = new Robot(random_int(0, 1000));//random_int(0, PHP_INT_MAX)
    $instructionsGenerator = new InstructionsGenerator();
    $instructionsLeftRobot = $instructionsGenerator->generate();
    $divergenceCalculator = new DivergenceCalculator();
    $divergenceLeftRobot = $divergenceCalculator->calculate(
        $instructionsLeftRobot, $leftRobot->getStartPosition(), $rightRobot->getStartPosition()
    );
    $instructionsRightRobot = $instructionsGenerator->generate();
    $instructionsRightRobot = $instructionsGenerator->tweak(
        $instructionsRightRobot, $divergenceLeftRobot, $rightRobot->getStartPosition(), $leftRobot->getStartPosition()
    );
    $divergenceRightRobot = $divergenceCalculator->calculate(
        $instructionsRightRobot, $rightRobot->getStartPosition(), $leftRobot->getStartPosition()
    );

    /* TEST */
    echo "D1: {$divergenceLeftRobot}\n";
    echo "D2: {$divergenceRightRobot}\n";
    testCollision(
        $leftRobot->getStartPosition(), $instructionsLeftRobot, $rightRobot->getStartPosition(), $instructionsRightRobot
    );
} catch (Exception $e) {
    echo "!!! ERROR !!!\n";
}

function testCollision($start1st, array $instructions1st, $start2nd, array $instructions2nd) {
    $position1st = $start1st;
    $position2nd = $start2nd;
    $skip1st = $skip2nd = false;
    $countInstructions1st = count($instructions1st);
    $countInstructions2nd = count($instructions2nd);
    $step = 0;
    do {
        $instruction1st = $instructions1st[$step % $countInstructions1st];
        list($skip1st, $position1st) = oneStep($instruction1st, $skip1st, $position1st, $start1st, $start2nd);
        $instruction2nd = $instructions2nd[$step % $countInstructions2nd];
        list($skip2nd, $position2nd) = oneStep($instruction2nd, $skip2nd, $position2nd, $start2nd, $start1st);
        $step += 1;
    } while ($position1st < $position2nd);
    echo "!!! COLLISION !!!\n";
    echo "position1st: {$position1st}, position2nd: {$position2nd}, steps: {$step}\n";
}

/**
 * @param int $instruction
 * @param bool $skip
 * @param int $position
 * @param int $myStart
 * @param int $otherRobotsStart
 * @return int[]
 */
function oneStep($instruction, $skip, $position, $myStart, $otherRobotsStart) {
    $newSkip = false;
    switch ($instruction) {
        case InstructionsEnum::INSTRUCTIONS_LEFT:
            if (!$skip) {
                $position -= 1;
            }
            break;
        case InstructionsEnum::INSTRUCTIONS_RIGHT:
            if (!$skip) {
                $position += 1;
            }
            break;
        case InstructionsEnum::INSTRUCTIONS_SKIP_NEXT:
            if (!$skip) {
                $newSkip = $position === $myStart || $position === $otherRobotsStart;
            }
            break;
    }
    return [$newSkip, $position];
}