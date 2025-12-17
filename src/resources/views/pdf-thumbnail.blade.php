<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF Thumbnail</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
        .card { max-width: 720px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; }
        .row { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .muted { color: #6b7280; }
        .error { color: #b91c1c; margin-top: 8px; }
        .thumb { margin-top: 16px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; }
        img { max-width: 100%; height: auto; display: block; }
        input[type="file"] { padding: 6px; }
        button { padding: 8px 12px; border-radius: 10px; border: 1px solid #111827; background: #111827; color: #fff; cursor: pointer; }
        button:hover { opacity: 0.92; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="margin: 0 0 6px 0;">Generate a thumbnail from a PDF</h2>
        <div class="muted">Uploads a PDF and uses <code>shishima/laravel-thumbnail</code> to render a thumbnail.</div>

        <form action="{{ route('pdf-thumbnail.store') }}" method="post" enctype="multipart/form-data" style="margin-top: 14px;">
            @csrf
            <div class="row">
                <input type="file" name="pdf" accept="application/pdf" required>
                <button type="submit">Generate</button>
            </div>

            @error('pdf')
                <div class="error">{{ $message }}</div>
            @enderror
        </form>

        @if(!empty($result) && !empty($result['path']))
            <div class="thumb">
                <div class="muted" style="margin-bottom: 8px;">
                    <div><strong>Original</strong>: {{ $result['original_name'] ?? 'unknown' }}</div>
                    <div><strong>Thumbnail</strong>: <code>{{ $result['path'] }}</code></div>
                </div>
                <img src="{{ $result['path'] }}" alt="PDF thumbnail">
            </div>
        @endif
    </div>
</body>
</html>


