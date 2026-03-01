<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#title
 */
class Title extends Option
{
    public function __construct(string $text = '')
    {
        parent::__construct($text !== '' ? ['text' => $text] : []);
    }

    public function text(string $text): static
    {
        return $this->set('text', $text);
    }

    public function link(string $link): static
    {
        return $this->set('link', $link);
    }

    /**
     * @param 'self'|'blank' $target
     */
    public function target(string $target): static
    {
        return $this->set('target', $target);
    }

    public function subtext(string $subtext): static
    {
        return $this->set('subtext', $subtext);
    }

    public function sublink(string $sublink): static
    {
        return $this->set('sublink', $sublink);
    }

    /**
     * @param 'self'|'blank' $subtarget
     */
    public function subtarget(string $subtarget): static
    {
        return $this->set('subtarget', $subtarget);
    }

    /**
     * @param 'auto'|'left'|'right'|'center' $left
     */
    public function left(string $left): static
    {
        return $this->set('left', $left);
    }

    /**
     * @param 'auto'|'top'|'middle'|'bottom'|string $top
     */
    public function top(string $top): static
    {
        return $this->set('top', $top);
    }

    /**
     * @param 'auto'|string $right
     */
    public function right(string $right): static
    {
        return $this->set('right', $right);
    }

    /**
     * @param 'auto'|string $bottom
     */
    public function bottom(string $bottom): static
    {
        return $this->set('bottom', $bottom);
    }

    public function backgroundColor(string $color): static
    {
        return $this->set('backgroundColor', $color);
    }

    public function borderColor(string $color): static
    {
        return $this->set('borderColor', $color);
    }

    public function borderWidth(int $width): static
    {
        return $this->set('borderWidth', $width);
    }

    public function borderRadius(int $radius): static
    {
        return $this->set('borderRadius', $radius);
    }

    /**
     * @param int|int[] $padding
     */
    public function padding(int|array $padding): static
    {
        return $this->set('padding', $padding);
    }

    public function itemGap(int $gap): static
    {
        return $this->set('itemGap', $gap);
    }

    public function zlevel(int $zlevel): static
    {
        return $this->set('zlevel', $zlevel);
    }

    public function z(int $z): static
    {
        return $this->set('z', $z);
    }

    public function show(bool $show = true): static
    {
        return $this->set('show', $show);
    }

    /**
     * @param array<string, mixed> $style e.g. ['color' => '#333', 'fontSize' => 18]
     */
    public function textStyle(array $style): static
    {
        return $this->set('textStyle', $style);
    }

    /**
     * @param array<string, mixed> $style e.g. ['color' => '#aaa', 'fontSize' => 12]
     */
    public function subtextStyle(array $style): static
    {
        return $this->set('subtextStyle', $style);
    }
}
