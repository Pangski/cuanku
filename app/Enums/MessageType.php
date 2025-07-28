<?php

namespace App\Enums;

enum MessageType: string
{
    case CREATED = 'Berhasil menambahkan';
    case UPDATED = 'Berhasil memperbarui';
    case DELETED = 'Berhasil menghapus';
    case ERROR   = 'Terjadi kesalahan. Silakan coba lagi nanti';

    /**
     * Menghasilkan pesan status berdasarkan tipe message
     *
     * @param string $entity Nama entitas (opsional, contoh: "Transaksi")
     * @param string|null $error Pesan error jika tipe adalah ERROR
     * @return string
     */
    public function message(string $entity = '', ?string $error = null): string
    {
        $message = $this->value;

        if ($this === self::ERROR && $error) {
            return "{$message} Error: {$error}";
        }

        return $entity
            ? "{$message} {$entity}."
            : "{$message}.";
    }
}
