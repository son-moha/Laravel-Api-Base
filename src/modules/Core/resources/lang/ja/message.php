<?php

return [
    'validate' => [
        'required' => 'このフィールドは必須です。',
        'remote' => 'このフィールドを修正してください。',
        'email' => 'メールアドレスの形式を正しく入力してください',
        'url' => '有効なURLを入力してください。',
        'date' => '有効な日付を入力してください。',
        'dateISO' => '有効な日付（ISO）を入力してください。',
        'number' => '数字で入力してください。',
        'digits' => '数字のみを入力してください。',
        'creditcard' => '有効なクレジットカード番号を入力してください。',
        'equalTo' => '同じ値をもう一度入力してください。',
        'extension' => '有効な拡張子を含む値を入力してください。',
        'maxlength' => '{0} 文字以内で入力してください。',
        'minlength' => 'パスワードは{0}文字以上で設定してください。',
        'rangelength' => '{0} 文字から {1} 文字までの値を入力してください。',
        'range' => '{0} から {1} までの値を入力してください。',
        'step' => '{0} の倍数を入力してください。',
        'max' => '{0} 以下の値を入力してください。',
        'min' => '{0} 以上の値を入力してください。',
        'greaterThanZero' => '0より大きい値を入力してください',
        'katakana' => 'カタカナを入力してください',
        'deleted' => '削除されました',
        'checktime' => '有効な時間を入力してください。',
        'unique email' => '指定のメールは既に使用されています。',
        'phone' => '電話番号の形式を正しく入力してください。',
        'checkPhone' => '半角で入力してください',
        'withoutSpace' => '少なくとも1語が必要です',
        'password' => 'パスワードは8文字以上~20文字以下半角英数字で、大文字、小文字、数字を全て含んでいる必要があります。',
        'confirmPassword' => '新パスワードと再入力パスワードが一致しません。',
        'IPv4Check' => 'IPV4アドレスが無効です'
    ],
    'notify' => [
        'create success' => '作成が完了しました',
        'update success' => '変更が完了しました',
        'delete success' => '削除が完了しました',
        'create fail' => '作成が失敗しました。再度試してください',
        'update fail' => '変更が失敗しました。再度試してください',
        'delete fail' => '削除が失敗しました。再度試してください',
        'something went wrong' => 'エラーが発生しました。再度試してください',
        'permission denied' => '403：アクセス権限がありません',
        'permission when create account' => 'このアカウントを作成する権限がありません',
        'ip incorrect, please authenticate again' => 'IP incorrect, please authenticate again',
    ]
];