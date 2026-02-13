@component('mail::message')
# 承認のお知らせ

おめでとうございます。あなたの{{ ucfirst($targetType) }}申請は承認されました。

**ログイン情報**
- メール: {{ $user->email }}
- 仮パスワード: `{{ $tempPassword }}`

初回ログイン後はパスワードを変更してください。

@component('mail::button', ['url' => url('/login')])
ログインする
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
