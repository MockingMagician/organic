<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\PHPUnitExt;

use Throwable;

trait RetryTrait
{
    /**
     * @throws Throwable
     */
    public function runBare(): void
    {
        $e = null;

        $numberOfRetires = $this->getNumberOfRetries();
        if (false == \is_numeric($numberOfRetires)) {
            throw new \LogicException(\sprintf('The $numberOfRetires must be a number but got "%s"', \var_export($numberOfRetires, true)));
        }
        $numberOfRetires = (int) $numberOfRetires;
        if ($numberOfRetires <= 0) {
            throw new \LogicException(\sprintf('The $numberOfRetires must be a positive number greater than 0 but got "%s".', $numberOfRetires));
        }

        for ($i = 0; $i < $numberOfRetires; ++$i) {
            try {
                parent::runBare();

                return;
            } catch (\PHPUnit\Framework\IncompleteTestError $e) {
                throw $e;
            } catch (\PHPUnit\Framework\SkippedTestError $e) {
                throw $e;
            } catch (\Throwable $e) {
                // last one will be thrown after retries
            }
        }

        if ($e) {
            throw $e;
        }
    }

    /**
     * @return int
     */
    private function getNumberOfRetries()
    {
        $annotations = $this->getAnnotations();

        if (isset($annotations['method']['retry'][0])) {
            return $annotations['method']['retry'][0];
        }

        if (isset($annotations['class']['retry'][0])) {
            return $annotations['class']['retry'][0];
        }

        return 1;
    }
}
