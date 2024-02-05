<?php

declare(strict_types=1);

namespace Application\Infrastructure;

enum Module
{
    case Shared;
    case Document;
    case Orchestrator;
    case EnglishLanguageChecker;
    case CyrillicInspector;
    case CyrillicReport;
    case CyrillicNormalizer;
    case Normalizer;
    case EnglishSentenceSplitter;
    case EnglishStemmer;
    case DocumentComparator;
    case SentenceComparator;
    case Report;
}
