# admin-me-setting

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install admin-me-setting
```

## Profile Editor

Module ini sudah memiliki profile editor. Untuk sekarang, kolom yang ditangani adalah `avatar`,
`fullname`, dan `name`. Jika ingin menambah kolom yang bisa di edit dari halaman profile setting,
tambahkan form rules pada form dengan nama `admin.me.setting.profile` dengan tambahan properti
masing-masing field adalah `xpos` yang bernilai `left`, `center`, `right`, atau `bottom`. Properti
kedua adalah `xindex` untuk menentukan urutan kolom ditampilkan di form.

## Other Setting Handler

Module ini hanya menangani setting profile dan password. Jika ingin menambahkan editor yang berhubungan
dengan user yang sedang login ( dan bagian dari account setting ), maka buatkan controller yang di extends
dari class `AdminMeSetting\Controller`. Kemudian tambahkan konfigurasi seperti di bawah pada konfigurasi
module untuk menambah daftar link dibagian kiri profile setting.

```php
return [
    'adminMeSetting' => [
        'menus' => [
            '/name/' => '/Class/'
        ]
    ]
];
```

Class tersebut harus mengimplementasikan interface `AdminMeSetting\Iface\Menus`. Dan harus memiliki method
sebagai berikut:

### getMenus(): array

Fungsi untuk mengambil daftar link untuk ditampilkan dibagian kiri editor. Fungsi ini diharapkan mengembalikan
array sebagai berikut:

```php
$result = [
    (object)[
        'label' => 'Password',
        'route' => ['adminMeSettingPassword', [], []],
        'index' => 100
    ],
    // ...
];
```