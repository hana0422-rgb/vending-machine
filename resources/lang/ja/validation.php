<?php

return [

    'required' => ':attribute は必須です。',
    'unique'   => ':attribute はすでに使用されています。',
    'integer'  => ':attribute は整数でなければなりません。',
    'min' => [
        'numeric' => ':attribute は :min 以上の数値でなければなりません。',

    ],

    'custom' => [
        'product_name' => [
            'required' => '商品名を入力してください。',
        ],
        'maker_name' => [
            'required' => 'メーカー名を入力してください。',
        ],
        'price' => [
            'required' => '価格を入力してください。',
            'integer'  => '価格は整数で入力してください。',
        ],
        'stock' => [
            'required' => '在庫数を入力してください。',
            'integer'  => '在庫数は整数で入力してください。',
        ],
        'comment' => [
            'required' => 'コメントを入力してください。',
        ],
        'company_id' => [
            'required' => '会社を選択してください。',
        ],
        'image_path' => [
            'image' => '画像ファイルを選択してください。',
        ],
    ],

    'attributes' => [
        'product_name' => '商品名',
        'maker_name'   => 'メーカー名',
        'price'        => '価格',
        'stock'        => '在庫数',
        'comment'      => 'コメント',
        'company_id'   => '会社',
        'image_path'   => '画像',
    ],
];
