<p> {{ $lastName }} 様 </p>

<p>Wazaarへようこそ！</p>

<p>メールアドレスの確認のために、下記のリンクをクリックしてください。</p>

<a href='{{{ action("UsersController@confirm", $user['confirmation_code']) }}}'>
    {{{ action("UsersController@confirm", $user['confirmation_code']) }}}
</a>

<p>
ワザールではまだまだ動画教材が足りませんので、{{ $lastName }} 様の動画教材を是非、<br />
ワザールにご投稿ください。<br />
今後とも何卒よろしくお願い致します。<br />
ワザール　日本法人代表<br />
峯山<br />
</p>