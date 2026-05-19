<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  body { font-family:'Segoe UI', Arial, sans-serif; background:#f4f6fb; color:#333; }
  .wrapper { max-width:600px; margin:30px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:linear-gradient(135deg,#696cff,#9155fd); padding:32px 40px; text-align:center; }
  .header h1 { color:#fff; font-size:22px; font-weight:700; }
  .body { padding:32px 40px; }
  .greeting { font-size:16px; margin-bottom:20px; color:#555; }
  .content { font-size:15px; line-height:1.8; color:#444; white-space:pre-line; }
  .footer { background:#f8f9ff; padding:20px 40px; text-align:center; border-top:1px solid #eee; }
  .footer p { font-size:12px; color:#aaa; }
  .footer strong { color:#696cff; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>📬 {{ config('app.name') }}</h1>
  </div>
  <div class="body">
    @if($name)
    <p class="greeting">Hi <strong>{{ $name }}</strong>,</p>
    @endif
    <div class="content">{{ $body }}</div>
  </div>
  <div class="footer">
    <p>This email was sent by <strong>{{ config('app.name') }}</strong> admin team.</p>
  </div>
</div>
</body>
</html>