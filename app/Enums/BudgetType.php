<?php

namespace App\Enums;

enum BudgetType: string
{
    case INCOME = 'Penghasilan';
    case EXPENSE = 'Pengeluaran';
    case SAVING = 'Tabungan dan Investasi';
    case SHOPPING = 'Belanja';
    case DEBT = 'Cicilan Hutang';
    case BILL = 'Tagihan';

    /**
     * Ambil daftar opsi [label => ..., value => ...]
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
     * Ambil nama enum: ['INCOME', 'EXPENSE', ...]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Ambil label enum: ['Penghasilan', 'Pengeluaran', ...]
     */
    public static function labels(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Ambil enum berdasarkan label
     */
    public static function fromLabel(string $label): ?self
    {
        return collect(self::cases())
            ->first(fn(self $item) => $item->value === $label);
    }
}
