<?php

namespace App\Constants;

class ColorConstant
{
    const COLORS = [
        'red' => '#ef4444',
        'orange' => '#f97316',
        'amber' => '#f59e0b',
        'lime' => '#84cc16',
        'green' => '#22c55e',
        'teal' => '#14b8a6',
        'sky' => '#0ea5e9',
        'indigo' => '#6366f1',
        'purple' => '#a855f7',
        'fuchsia' => '#d946ef',
        'pink' => '#ec4899',
    ];

    /**
     * Get random color code.
     */
    public static function random(): string
    {
        return array_values(self::COLORS)[array_rand(self::COLORS)];
    }

    /**
     * Get hex code by name (fallback to null).
     */
    public static function get(string $name): ?string
    {
        return self::COLORS[$name] ?? null;
    }

    /**
     * Get list of all color names.
     */
    public static function names(): array
    {
        return array_keys(self::COLORS);
    }

    /**
     * Get all color values.
     */
    public static function values(): array
    {
        return array_values(self::COLORS);
    }
}
