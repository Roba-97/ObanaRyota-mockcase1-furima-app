@component('mail::message')
# 商品の取引が完了しました

## 取引が完了した相手 : {{ $dealUser->name }}

## 取引が完了した商品 : {{ $dealItem->name }}

トークルームから相手へ評価を送信してください

@component('mail::button', ['url' => $url])
ログインして確認
@endcomponent

Thanks,
<br>{{ config('app.name') }}
@endcomponent