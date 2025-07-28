<?php

namespace App\Enums;

enum LiabilityType: string
{
    case SHORTTERMDEBT = 'Hutang Jangka Pendek';
    case MIDTERMDEBT = 'Hutang Jangka Menengah';
    case LONGTERMDEBT = 'Hutang Jangka Panjang';

    /**
     * Ambil daftar opsi untuk dropdown/form.
     *
     * @param array $exclude Daftar nama enum yang ingin dikecualikan
     * @return array
     */
    public static function options(array $exclude = []): array
    {
        return collect(self::cases())
            ->reject(fn(self $item) => in_array($item->name, $exclude))
            ->map(fn(self $item) => [
                'label' => $item->value,
                'value' => $item->name,
            ])
            ->values()
            ->toArray();
    }

    /**
     * Ambil daftar nama enum (contoh: ['SHORTTERMDEBT', 'MIDTERMDEBT'])
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Ambil daftar label enum (contoh: ['Hutang Jangka Pendek', ...])
     */
    public static function labels(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Ambil enum berdasarkan label.
     */
    public static function fromLabel(string $label): ?self
    {
        return collect(self::cases())
            ->first(fn(self $item) => $item->value === $label);
    }
}
