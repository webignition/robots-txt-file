<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\File;

use webignition\RobotsTxt\Directive\DirectiveInterface;
use webignition\RobotsTxt\Directive\Factory as DirectiveFactory;
use webignition\RobotsTxt\Record\Record;

class Parser
{
    private const STATE_UNKNOWN = 0;
    private const STATE_ADDING_TO_RECORD = 1;
    private const STATE_ADDING_TO_FILE = 2;
    private const STATE_STARTING_RECORD = 3;
    private const STARTING_STATE = self::STATE_UNKNOWN;
    private const COMMENT_START_CHARACTER = '#';
    private const UTF8_BOM = "\xef\xbb\xbf";

    /**
     * Unmodified source of given robots.txt file
     *
     * @var string|null
     */
    private $source = null;

    /**
     * Lines from source
     *
     * @var string[]
     */
    private $sourceLines = [];

    /**
     * Number of lines in source file
     *
     * @var int
     */
    private $sourceLineCount = 0;

    /**
     * Index in $sourceLines of current line being parsed
     *
     * @var int
     */
    private $sourceLineIndex = 0;

    /**
     *
     * @var File|null
     */
    private $file = null;

    /**
     * Current state of the parser
     *
     * @var int
     */
    private $currentState = self::STARTING_STATE;

    /**
     * Previous state of the parser
     *
     * @var int
     */
    private $previousState = self::STARTING_STATE;

    /**
     *
     * @var Record|null
     */
    private $currentRecord = null;

    /**
     * @var array<string, bool>
     */
    private $nonGroupFieldNames = array(
        DirectiveInterface::TYPE_SITEMAP => true
    );

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $this->prepareSource($source);
    }

    private function prepareSource(string $source): string
    {
        $source = trim($source);

        if (substr($source, 0, strlen(self::UTF8_BOM)) == self::UTF8_BOM) {
            $source = substr($source, strlen(self::UTF8_BOM));
        }

        return $source;
    }

    public function getFile(): File
    {
        if (is_null($this->file)) {
            $this->file = new File();
            $this->parse();
        }

        return $this->file;
    }

    private function parse(): void
    {
        $this->currentState = self::STARTING_STATE;
        $this->sourceLines = explode("\n", trim($this->source));
        $this->sourceLineCount = count($this->sourceLines);

        while ($this->sourceLineIndex < $this->sourceLineCount) {
            $this->parseCurrentLine();
        }

        if ($this->hasCurrentRecord()) {
            $this->file->addRecord($this->currentRecord);
        }
    }

    private function parseCurrentLine(): void
    {
        switch ($this->currentState) {
            case self::STATE_UNKNOWN:
                $this->deriveStateFromCurrentLine();
                $this->previousState = self::STATE_UNKNOWN;
                break;

            case self::STATE_STARTING_RECORD:
                $this->currentRecord = new Record();
                $this->currentState = self::STATE_ADDING_TO_RECORD;
                $this->previousState = self::STATE_STARTING_RECORD;
                break;

            case self::STATE_ADDING_TO_RECORD:
                if ($this->isCurrentLineANonGroupDirective()) {
                    $this->currentState = self::STATE_ADDING_TO_FILE;
                    $this->previousState = self::STATE_ADDING_TO_RECORD;

                    return;
                }

                if ($this->isCurrentLineADirective()) {
                    $directive = DirectiveFactory::create($this->getCurrentLine());

                    if ($directive->isType(DirectiveInterface::TYPE_USER_AGENT)) {
                        $this->currentRecord->getUserAgentDirectiveList()->add($directive);
                    } else {
                        $this->currentRecord->getDirectiveList()->add($directive);
                    }
                } else {
                    if (!empty($this->currentRecord)) {
                        $this->file->addRecord($this->currentRecord);
                        $this->currentRecord = null;
                    }

                    $this->currentState = self::STATE_UNKNOWN;
                }

                $this->sourceLineIndex++;

                break;

            case self::STATE_ADDING_TO_FILE:
                $directive = DirectiveFactory::create($this->getCurrentLine());

                if (!is_null($directive)) {
                    $this->file->getNonGroupDirectives()->add($directive);
                }

                $this->currentState = ($this->previousState == self::STATE_ADDING_TO_RECORD)
                    ? self::STATE_ADDING_TO_RECORD
                    : self::STATE_UNKNOWN;
                $this->previousState = self::STATE_ADDING_TO_FILE;
                $this->sourceLineIndex++;

                break;

            default:
        }
    }

    private function getCurrentLine(): string
    {
        return isset($this->sourceLines[$this->sourceLineIndex])
            ? trim($this->sourceLines[$this->sourceLineIndex])
            : '';
    }

    private function hasCurrentRecord(): bool
    {
        return !is_null($this->currentRecord);
    }

    private function isCurrentLineBlank(): bool
    {
        return $this->getCurrentLine() == '';
    }

    private function isCurrentLineAComment(): bool
    {
        return substr($this->getCurrentLine(), 0, 1) == self::COMMENT_START_CHARACTER;
    }

    private function isCurrentLineADirective(): bool
    {
        if ($this->isCurrentLineBlank()) {
            return false;
        }

        if ($this->isCurrentLineAComment()) {
            return false;
        }

        $directive = DirectiveFactory::create($this->getCurrentLine());

        if (empty($directive)) {
            return false;
        }

        return true;
    }

    private function isCurrentLineANonGroupDirective(): bool
    {
        if (!$this->isCurrentLineADirective()) {
            return false;
        }

        $directive = DirectiveFactory::create($this->getCurrentLine());

        if (empty($directive)) {
            return false;
        }

        return array_key_exists($directive->getField(), $this->nonGroupFieldNames);
    }

    private function deriveStateFromCurrentLine(): void
    {
        if (!$this->isCurrentLineADirective()) {
            $this->sourceLineIndex++;
            $this->currentState = self::STATE_UNKNOWN;

            return;
        }

        $directive = DirectiveFactory::create($this->getCurrentLine());

        if (!is_null($directive) && $directive->isType(DirectiveInterface::TYPE_USER_AGENT)) {
            $this->currentState = self::STATE_STARTING_RECORD;

            return;
        }

        $this->currentState = self::STATE_ADDING_TO_FILE;

        return;
    }
}
