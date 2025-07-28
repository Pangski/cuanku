<?php

namespace App\Enums;

use InvalidArgumentException;

enum MonthEnum: string
{
    case JANUARY = 'Januari';
    case FEBRUARY = 'Februari';
    case MARCH = 'Maret';
    case APRIL = 'April';
    case MAY = 'Mei';
    case JUNE = 'Juni';
    case JULY = 'Juli';
    case AUGUST = 'Agustus';
    case SEPTEMBER = 'September';
    case OCTOBER = 'Oktober';
    case NOVEMBER = 'November';
    case DECEMBER = 'Desember';

    /**
     * Mendapatkan list bulan dalam format value-label untuk select input
     */
    public static function options(array $exclude = []): array
    {
        return collect(self::cases())
            ->filter(fn ($item) => !in_array($item->name, $exclude))
            ->map(fn ($item) => [
                'value' => $item->value,
                'label' => $item->value,
            ])
            ->values()
            ->toArray();
    }

    /**
     * Mengubah nomor bulan (1–12) ke enum MonthEnum
     */
    public static function month(int $month): self
    {
        return match ($month) {
            1 => self::JANUARY,
            2 => self::FEBRUARY,
            3 => self::MARCH,
            4 => self::APRIL,
            5 => self::MAY,
            6 => self::JUNE,
            7 => self::JULY,
            8 => self::AUGUST,
            9 => self::SEPTEMBER,
            10 => self::OCTOBER,
            11 => self::NOVEMBER,
            12 => self::DECEMBER,
            default => throw new InvalidArgumentException("Invalid month number: {$month}"),
        };
    }

    /**
     * Mengubah nama string bulan menjadi enum MonthEnum
     */
    public static function stringMonth(string $month): self
    {
        return match (ucfirst(strtolower($month))) {
            'Januari' => self::JANUARY,
            'Februari' => self::FEBRUARY,
            'Maret' => self::MARCH,
            'April' => self::APRIL,
            'Mei' => self::MAY,
            'Juni' => self::JUNE,
            'Juli' => self::JULY,
            'Agustus' => self::AUGUST,
            'September' => self::SEPTEMBER,
            'Oktober' => self::OCTOBER,
            'November' => self::NOVEMBER,
            'Desember' => self::DECEMBER,
            default => throw new InvalidArgumentException("Invalid month name: {$month}"),
        };
    }
}
