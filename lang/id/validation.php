<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Field :attribute harus diterima.',
    'accepted_if' => 'Field :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Field :attribute harus berupa URL yang valid.',
    'after' => 'Field :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Field :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Field :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Field :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Field :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Field :attribute harus berupa array.',
    'ascii' => 'Field :attribute hanya boleh berisi karakter alfanumerik dan simbol byte tunggal.',
    'before' => 'Field :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Field :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Field :attribute harus memiliki antara :min dan :max item.',
        'file' => 'Field :attribute harus berukuran antara :min dan :max kilobyte.',
        'numeric' => 'Field :attribute harus bernilai antara :min dan :max.',
        'string' => 'Field :attribute harus berisi antara :min dan :max karakter.',
    ],
    'boolean' => 'Field :attribute harus bernilai true atau false.',
    'can' => 'Field :attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi field :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => 'Field :attribute harus berupa tanggal yang valid.',
    'date_equals' => 'Field :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Field :attribute harus sesuai dengan format :format.',
    'decimal' => 'Field :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Field :attribute harus ditolak.',
    'declined_if' => 'Field :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Field :attribute dan :other harus berbeda.',
    'digits' => 'Field :attribute harus terdiri dari :digits digit.',
    'digits_between' => 'Field :attribute harus terdiri dari :min sampai :max digit.',
    'dimensions' => 'Field :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Field :attribute memiliki nilai duplikat.',
    'doesnt_end_with' => 'Field :attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => 'Field :attribute tidak boleh dimulai dengan salah satu dari berikut: :values.',
    'email' => 'Field :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Field :attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'extensions' => 'Field :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Field :attribute harus berupa file.',
    'filled' => 'Field :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Field :attribute harus memiliki lebih dari :value item.',
        'file' => 'Field :attribute harus lebih besar dari :value kilobyte.',
        'numeric' => 'Field :attribute harus lebih besar dari :value.',
        'string' => 'Field :attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Field :attribute harus memiliki :value item atau lebih.',
        'file' => 'Field :attribute harus lebih besar dari atau sama dengan :value kilobyte.',
        'numeric' => 'Field :attribute harus lebih besar dari atau sama dengan :value.',
        'string' => 'Field :attribute harus lebih dari atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Field :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Field :attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => 'Field :attribute harus ada di :other.',
    'integer' => 'Field :attribute harus berupa bilangan bulat.',
    'ip' => 'Field :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Field :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Field :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Field :attribute harus berupa string JSON yang valid.',
    'lowercase' => 'Field :attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => 'Field :attribute harus memiliki kurang dari :value item.',
        'file' => 'Field :attribute harus kurang dari :value kilobyte.',
        'numeric' => 'Field :attribute harus kurang dari :value.',
        'string' => 'Field :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Field :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Field :attribute harus kurang dari atau sama dengan :value kilobyte.',
        'numeric' => 'Field :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Field :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Field :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Field :attribute tidak boleh memiliki lebih dari :max item.',
        'file' => 'Field :attribute tidak boleh lebih besar dari :max kilobyte.',
        'numeric' => 'Field :attribute tidak boleh lebih besar dari :max.',
        'string' => 'Field :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Field :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Field :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Field :attribute harus berupa file bertipe: :values.',
    'min' => [
        'array' => 'Field :attribute harus memiliki setidaknya :min item.',
        'file' => 'Field :attribute harus setidaknya :min kilobyte.',
        'numeric' => 'Field :attribute harus setidaknya :min.',
        'string' => 'Field :attribute harus setidaknya :min karakter.',
    ],
    'min_digits' => 'Field :attribute harus memiliki setidaknya :min digit.',
    'missing' => 'Field :attribute harus hilang.',
    'missing_if' => 'Field :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Field :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Field :attribute harus hilang ketika :values ada.',
    'missing_with_all' => 'Field :attribute harus hilang ketika :values ada.',
    'multiple_of' => 'Field :attribute harus kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format field :attribute tidak valid.',
    'numeric' => 'Field :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Field :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Field :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Field :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Field :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => 'Field :attribute harus ada.',
    'present_if' => 'Field :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Field :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Field :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Field :attribute harus ada ketika :values ada.',
    'prohibited' => 'Field :attribute dilarang.',
    'prohibited_if' => 'Field :attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => 'Field :attribute dilarang kecuali :other ada di :values.',
    'prohibits' => 'Field :attribute melarang :other untuk ada.',
    'regex' => 'Format field :attribute tidak valid.',
    'required' => 'Field :attribute wajib diisi.',
    'required_array_keys' => 'Field :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Field :attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => 'Field :attribute wajib diisi ketika :other diterima.',
    'required_unless' => 'Field :attribute wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Field :attribute wajib diisi ketika :values ada.',
    'required_with_all' => 'Field :attribute wajib diisi ketika :values ada.',
    'required_without' => 'Field :attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => 'Field :attribute wajib diisi ketika tidak ada satupun dari :values yang ada.',
    'same' => 'Field :attribute harus sama dengan :other.',
    'size' => [
        'array' => 'Field :attribute harus berisi :size item.',
        'file' => 'Field :attribute harus berukuran :size kilobyte.',
        'numeric' => 'Field :attribute harus berukuran :size.',
        'string' => 'Field :attribute harus berisi :size karakter.',
    ],
    'starts_with' => 'Field :attribute harus dimulai dengan salah satu dari berikut: :values.',
    'string' => 'Field :attribute harus berupa string.',
    'timezone' => 'Field :attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => 'Field :attribute harus berupa huruf besar.',
    'url' => 'Field :attribute harus berupa URL yang valid.',
    'ulid' => 'Field :attribute harus berupa ULID yang valid.',
    'uuid' => 'Field :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'phone' => 'telepon',
        'address' => 'alamat',
        'role' => 'peran',
        'description' => 'deskripsi',
        'price' => 'harga',
        'stock' => 'stok',
        'category' => 'kategori',
        'image' => 'gambar',
        'status' => 'status',
        'customer_name' => 'nama pelanggan',
        'customer_phone' => 'telepon pelanggan',
        'customer_email' => 'email pelanggan',
        'payment_method' => 'metode pembayaran',
        'notes' => 'catatan',
        'quantity' => 'jumlah',
        'unit_price' => 'harga satuan',
        'subtotal' => 'subtotal',
        'total_amount' => 'total jumlah',
    ],

];
