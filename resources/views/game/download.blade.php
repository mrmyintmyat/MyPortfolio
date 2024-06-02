<!DOCTYPE html>
<html>
<head>
    <title>Download</title>
    <meta name="referrer" content="no-referrer">
    <meta http-equiv="refresh" content="0;url={{ $dir_link }}">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var dirLink = @json($dir_link);
            window.open(dirLink, '_blank', 'noopener,noreferrer');
        });
    </script>
</head>
<body>
    <p>If the download doesn't start, <a href="{{ $dir_link }}" target="_blank" rel="noopener noreferrer">click here</a>.</p>
</body>
</html>
