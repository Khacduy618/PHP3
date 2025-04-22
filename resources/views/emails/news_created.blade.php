<!DOCTYPE html>
<html>

<head>
    <title>Thông báo tin tức mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .news-details {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .unsubscribe {
            margin-top: 20px;
            font-size: 12px;
        }

        .button-more {
            background-color: #4CAF50;
            /* Green */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        a.button-more,
        a.button-unsub {
            color: white;
        }

        .button-unsub {
            background-color: rgb(221, 68, 8);
            /* Green */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Tin tức mới đã được đăng: {{ $news->title }}</h1>
    <p>{{ $news->summary }}</p>
    <p class="news-details">Ngày đăng: {{ $news->created_at->format('d/m/Y') }}</p>
    <a href="{{ route('news.show', $news->slug) }}" class="button-more">Đọc thêm</a>

    <div class="unsubscribe">
        <p>Nếu bạn không muốn nhận thông báo này nữa, vui lòng nhấn vào nút hủy đăng ký dưới đây:</p>
        <a href="{{ $unsubscribe_url }}" class="button-unsub">Hủy đăng ký</a>
    </div>
</body>

</html>