<?php

declare(strict_types=1);

namespace DevLnk\LaravelCodeBuilder\Services\CodeStructure;

use DevLnk\LaravelCodeBuilder\Enums\SqlTypeMap;
use DevLnk\LaravelCodeBuilder\Support\Traits\DataTrait;

final class ColumnStructure
{
    use DataTrait;

    private ?string $inputType = null;

    private ?RelationStructure $relation = null;

    public function __construct(
        private readonly string $column,
        private string $name,
        private SqlTypeMap $type,
        private readonly ?string $default,
        private readonly bool $nullable
    ) {
        if (empty($this->name)) {
            $this->name = str($this->column)->camel()->ucfirst()->value();
        }

        $this->setInputType();
    }

    public function type(): SqlTypeMap
    {
        return $this->type;
    }

    public function column(): string
    {
        return $this->column;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function relation(): ?RelationStructure
    {
        return $this->relation;
    }

    public function default(): ?string
    {
        return $this->default;
    }

    public function defaultInStub(): ?string
    {
        if (! is_null($this->default) && $this->phpType() === 'string') {
            return "'" . trim($this->default, "'") . "'";
        }

        if (
            ! is_null($this->default)
            && ($this->phpType() === 'float' || $this->phpType() === 'int')
        ) {
            return trim($this->default, "'");
        }

        return $this->default;
    }

    public function nullable(): bool
    {
        return $this->nullable;
    }

    public function setRelation(RelationStructure $relation): void
    {
        $this->relation = $relation;
    }

    public function inputType(): ?string
    {
        return $this->inputType;
    }

    public function isCreatedAt(): bool
    {
        return $this->column() === 'created_at';
    }

    public function isUpdatedAt(): bool
    {
        return $this->column() === 'updated_at';
    }

    public function isDeletedAt(): bool
    {
        return $this->column() === 'deleted_at';
    }

    public function isId(): bool
    {
        return  $this->type()->isIdType();
    }

    public function isLaravelTimestamp(): bool
    {
        return $this->isCreatedAt() || $this->isUpdatedAt() || $this->isDeletedAt();
    }

    public function rulesType(): ?string
    {
        if ($this->inputType === 'number') {
            return 'int';
        }

        if ($this->inputType === 'text') {
            return 'string';
        }

        if ($this->inputType === 'checkbox') {
            return 'accepted';
        }

        return $this->inputType;
    }

    public function phpType(): ?string
    {
        if (
            $this->type() === SqlTypeMap::HAS_MANY
            || $this->type() === SqlTypeMap::BELONGS_TO_MANY
        ) {
            return 'array';
        }

        if ($this->type() === SqlTypeMap::HAS_ONE) {
            return $this->relation()?->table()->ucFirstSingular() . 'DTO';
        }

        if (
            $this->inputType === 'text'
            || $this->inputType === 'email'
            || $this->inputType === 'password'
        ) {
            return 'string';
        }

        if ($this->type() === SqlTypeMap::BOOLEAN) {
            return 'bool';
        }

        if (
            $this->type() === SqlTypeMap::DECIMAL
            || $this->type() === SqlTypeMap::DOUBLE
            || $this->type() === SqlTypeMap::FLOAT
        ) {
            return 'float';
        }

        if ($this->inputType === 'number') {
            return 'int';
        }

        return $this->inputType;
    }

    public function setInputType(): void
    {
        if (! is_null($this->inputType)) {
            return;
        }

        if ($this->column === 'email' || $this->column === 'password') {
            $this->inputType = $this->column;

            return;
        }

        $this->inputType = $this->type()->getInputType();
    }
}
