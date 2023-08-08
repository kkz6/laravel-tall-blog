<?php

namespace App\Models\Posts\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait PresentsAttributes
{
    public function renderedIntroduction() : Attribute
    {
        return Attribute::make(
            fn () => str($this->introduction ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedContent() : Attribute
    {
        return Attribute::make(
            fn () => str($this->content ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedConclusion() : Attribute
    {
        return Attribute::make(
            fn () => str($this->conclusion ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedTeaser() : Attribute
    {
        return Attribute::make(
            fn () => str($this->teaser ?? '')->marxdown()
        )->shouldCache();
    }
}