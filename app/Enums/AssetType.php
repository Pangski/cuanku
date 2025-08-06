<?php

namespace App\Enums;

enum AssetType: string
{
    case CASH = 'Kas';
    case PERSONAL = 'Personal';
    case SHORTTERM = 'Investasi Jangka Pendek';
    case MIDTERM = 'Investasi Jangka Menengah';
    case LONGTERM = 'Investasi Jangka Panjang';

    /**
     * Dapatkan daftar opsi [label => value]
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
     * Ambil array semua nama enum (value dari enum)
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Ambil array semua label enum (label yang ditampilkan ke UI)
     */
    public static function labels(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Ambil enum dari label, jika cocok
     */
    public static function fromLabel(string $label): ?self
    {
        return collect(self::cases())
            ->first(fn(self $item) => $item->value === $label);
    }
}
