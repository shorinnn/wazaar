<?php

return array(

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

	"accepted"             => ":attributeを承認する必要があります",
	"active_url"           => ":attributeは有効なURLではありません",
	"after"                => ":attributeは:date以降を指定してください",
	"alpha"                => ":attributeは文字だけを含みます",
	"alpha_dash"           => ":attributeは文字、数字、ダッシュのみを含みます",
	"alpha_num"            => ":attributeは文字と数字のみを含みます",
	"array"                => ":attributeは配列である必要があります",
	"before"               => ":attributeは:date以前を指定してください",
	"between"              => array(
		"numeric" => ":attributeは:minから:maxまでの値である必要があります",
		"file"    => ":attributeは:minから:maxキロバイトである必要があります",
		"string"  => ":attributeは:min文字以上:max文字以下である必要があります",
		"array"   => "attributeの項目数は:min以上:max以下である必要があります",
	),
	"boolean"              => ":attributeのフィールドにtrueまたはfalseを入力してください",
	"confirmed"            => ":attributeの確認が一致しません",
	"date"                 => ":attributeは有効な日付ではありません",
	"date_format"          => ":attributeが:formatのフォーマットに一致しません",
	"different"            => ":attributeと:otherは異なる値としてください",
	"digits"               => ":attributeは:digits桁の数字としてください",
	"digits_between"       => ":attributeは:min桁以上:max桁以下の数字としてください",
	"email"                => ":attributeは有効なEメールアドレスとしてください",
	"exists"               => "選択中の:attributeは無効です",
	"image"                => ":attributeは画像である必要があります",
	"in"                   => "選択中の:attributeは無効です",
	"integer"              => ":attributeは整数でなくてはなりません",
	"ip"                   => ":attributeは有効なIPアドレスとしてください",
	"max"                  => array(
		"numeric" => ":attributeは:max以下にしてください",
		"file"    => ":attributeは:maxキロバイト以下にしてください",
		"string"  => ":attributeは:max文字以下にしてください",
		"array"   => ":attributeは:max項目以下にしてください",
	),
	"mimes"                => ":attributeのファイルタイプを:valuesにしてください",
	"min"                  => array(
		"numeric" => ":attributeは:min以上にしてください",
		"file"    => ":attributeは:minキロバイト以上にしてください",
		"string"  => ":attributeは:min文字以上にしてください",
		"array"   => ":attributeは:min項目以上にしてください",
	),
	"not_in"               => "選択中の:attributeは無効です",
	"numeric"              => ":attributeは数字である必要があります",
	"regex"                => ":attributeのフォーマットが無効です",
	"required"             => ":attributeのフィールド値が必要です",
	"required_if"          => ":otherが:valueである場合、:attributeのフィールド値が必要です",
	"required_with"        => ":valuesがある場合、:attributeのフィールド値が必要です",
	"required_with_all"    => ":valuesがある場合、:attributeのフィールド値が必要です",
	"required_without"     => ":valuesがない場合、:attributeのフィールド値が必要です",
	"required_without_all" => ":valuesがひとつもない場合、:attributeのフィールド値が必要です",
	"same"                 => ":attributeと:otherが一致する必要があります",
	"size"                 => array(
		"numeric" => ":attributeを:sizeにしてください",
		"file"    => ":attributeを:sizeキロバイトにしてください",
		"string"  => ":attributeを:size文字にしてください",
		"array"   => ":attributeを:size項目にしてください",
	),
	"unique"               => ":attributeはすでに取得されています",
	"url"                  => ":attributeのフォーマットが無効です",
	"timezone"             => ":attributeを有効な範囲にしてください",
        "cannot_self_delete"   =>  "ご自身のアカウントは削除できません",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'カスタムメッセージ',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
            'short_description' => 'サブタイトル',
            'description' => 'コースの概要',
        ),

);
