<?php

it('renders headings with ids', function () {
    expect(str("# D'abc `def`-._&")->marxdown()->__toString())->toContain('id=');
});

it('adds rel attribute values to external links', function () {
    expect(str('[Apple](https://www.apple.com)')->marxdown()->__toString())
        ->toContain('rel="nofollow noopener noreferrer" target="_blank"');
});

it('does not add any attribute to internal links', function () {
    expect(str('[Foo](' . url('/') . ')')->marxdown()->__toString())
        ->toContain('href="' . url('/') . '">');

    expect(str('[Foo](#foo)')->marxdown()->__toString())->toContain('href="#foo"');
});

it('adds a click event to affiliate links', function () {
    expect(str('[Foo](' . url('/recommends/foo') . '')->marxdown()->__toString())
        ->toContain('@click="window.fathom?.trackGoal(\'LBJL4VHK\', 0)"');
});

it('adds a click event to external links', function () {
    expect(str('[Apple](https://www.apple.com)')->marxdown()->__toString())
        ->toContain("window.fathom?.trackGoal('SMD2GKMN', 0)");
});

it('renders tweets', function () {
})->todo('Test that tweets are rendered from their URL.');

it('renders vimeo', function () {
})->todo('Test that Vimeo videos are rendered from their URL.');

it('renders youtube', function () {
})->todo('Test that YouTube videos are rendered from their URL.');
