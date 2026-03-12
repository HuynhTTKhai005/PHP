<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đang tải...</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <meta http-equiv="refresh" content="0.4;url={{ $to }}">
</head>

<body class="reload-page" data-reload-target="{{ $to }}">
    <div class="reload-card" role="status" aria-live="polite">
        <div class="reload-badge">Sincay</div>
        <h1 class="reload-title">Đang chuyển trang</h1>
        <p class="reload-subtitle">Vui lòng chờ trong giây lát...</p>
        <div class="reload-progress" aria-hidden="true"><span></span></div>
        <div class="reload-dots" aria-hidden="true">
            <span></span><span></span><span></span>
        </div>
    </div>
</body>

</html>