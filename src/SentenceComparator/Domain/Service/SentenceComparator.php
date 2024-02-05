<?php

declare(strict_types=1);

namespace SentenceComparator\Domain\Service;

use Shared\Domain\Service\WordBreaker;

/**
* Calculate cosine similarity of two vectors, which is a scalar multiplication (dot product) of two vectors.
* See: https://en.wikipedia.org/wiki/Dot_product
*
* Each sentence is presented as a vector in a common (for all sentences in the two compared texts) vector space.
*
* #           |  word  |  word  |  word  |  word  | -> all words in two compared texts
* # -----------------------------------------------
* # sentence1 | weight | weight | weight | weight |
* # -----------------------------------------------
* # sentence2 | weight | weight | weight | weight |
* # -----------------------------------------------
* # sentence3 | weight | weight | weight | weight |
* # -----------------------------------------------
* # sentence4 | weight | weight | weight | weight |
* # -----------------------------------------------
* # sentence5 | weight | weight | weight | weight |
* # -----------------------------------------------
*
* For sentence comparison purposes 'weight' is idf (Inverse Document Frequency) factor.
*
* idf factor is calculated according to the formula: idf = log(N / df);
* where N is a number of documents in collection (in out case, number of all sentences in two texts combined)
* df is Document Frequency - the number of documents (in our case sentences) in which term (word) appears.
*
* If the word does not appear in the sentence, the weight is 0.
*
* In this case, we only have short sentences to compare, so tf (Term Frequency) factor is not important.
*
* Before multiplication, the vectors are normalized using L2-Norm: Xi = Xi / Sqrt(X0^2 + X1^2 + X2^2 + ... + Xn^2);
*
* -----------------------------------------------------------------------------------------------------------------
* EXAMPLE: Vector space for three sentences (before normalization):
*
* 1. Is simply dummy sentence of printing industry, dummy dummy sentence.
* 2. This is dummy example example sentence.
* 3. Dummy example sentence.
*
* #           |    is    |  simply  |  dummy   | sentence |    of    | printing | industry |   this   | example  |
* # --------------------------------------------------------------------------------------------------------------
* # sentence1 |   0.41   |   1.10   |    0     |    0     |   1.10   |   1.10   |   1.10   |   0      |   0      |
* # --------------------------------------------------------------------------------------------------------------
* # sentence2 |   0.41   |   0      |    0     |    0     |   0      |   0      |   0      |   1.10   |   0.41   |
* # --------------------------------------------------------------------------------------------------------------
* # sentence3 |   0      |   0      |    0     |    0     |   0      |   0      |   0      |   0      |   0.41   |
* # --------------------------------------------------------------------------------------------------------------
*
* TODO: since we have many zeros in the vector space, we can use sparse vector (sparse matrix) methods for optimization.
*/
final class SentenceComparator
{
    private const ZERO = 0;

    public function __construct(private readonly WordBreaker $breaker)
    {
    }

    public function compare(string $first, string $second, array $space): float
    {
        $similarity = self::ZERO;

        $words = array_unique($this->breaker->break($first));

        foreach ($words as $word) {
            $similarity += $space[$first][$word] * $space[$second][$word];
        }

        return $similarity;
    }
}
