<?php

declare(strict_types=1);

namespace DocumentComparator\Domain\Service;

/**
* Calculate cosine similarity of two vectors, which is a scalar multiplication (dot product) of two vectors.
* See: https://en.wikipedia.org/wiki/Dot_product
*
* Each text is presented as a vector in a common (for two texts) vector space.
*
* #       |  word  |  word  |  word  |  word  |
* # -------------------------------------------
* # text1 | weight | weight | weight | weight |
* # -------------------------------------------
* # text2 | weight | weight | weight | weight |
* # -------------------------------------------
*
* For text comparison purposes 'weight' is tf (Term Frequency) factor.
* tf factor is simply number of occurrences of term (some word) in document (some text).
* In this case, we only have two texts to compare, so idf (Inverse Document Frequency) factor is not important.
*
* Before multiplication, the vectors are normalized using L2-Norm: Xi = Xi / Sqrt(X0^2 + X1^2 + X2^2 + ... + Xn^2);
*
* -----------------------------------------------------------------------------------------------------------------
* EXAMPLE: Vector space for two texts (before normalization):
*
* 1. Is simply dummy text of printing industry, dummy dummy text.
* 2. This is dummy example example text.
*
* #       |    is    |  simply  |  dummy   |   text   |    of    | printing | industry |   this   | example  |
* # ----------------------------------------------------------------------------------------------------------
* # text1 |    1     |    1     |    3     |    2     |    1     |    1     |    1     |    0     |    0     |
* # ----------------------------------------------------------------------------------------------------------
* # text2 |    1     |    0     |    1     |    1     |    0     |    0     |    0     |    1     |    2     |
* # ----------------------------------------------------------------------------------------------------------
*/
final class DocumentComparator
{
    private const ZERO     = 0;
    private const EXPONENT = 2;

    public function compare(array $first, array $second): float
    {
        $similarity = self::ZERO;

        $sumOfExponentsForFirstText  = self::ZERO;
        $sumOfExponentsForSecondText = self::ZERO;

        $words = $this->words($first, $second);

        foreach ($words as $word) {
            if (true === array_key_exists($word, $first)) {
                $sumOfExponentsForFirstText += pow($first[$word], self::EXPONENT);
            }

            if (true === array_key_exists($word, $second)) {
                $sumOfExponentsForSecondText += pow($second[$word], self::EXPONENT);
            }
        }

        $squareRootForFirstText  = sqrt($sumOfExponentsForFirstText);
        $squareRootForSecondText = sqrt($sumOfExponentsForSecondText);

        foreach ($words as $word) {
            if (true === array_key_exists($word, $first) && true === array_key_exists($word, $second)) {
                $similarity += ($first[$word] / $squareRootForFirstText) * ($second[$word] / $squareRootForSecondText);
            }
        }

        return $similarity;
    }

    private function words(array $first, array $second): array
    {
        return array_unique(
            array_merge(
                array_keys($first),
                array_keys($second),
            ),
        );
    }
}
