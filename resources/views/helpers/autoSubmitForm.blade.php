<html>
<head>
<title>IMS LTI message</title>
<script type="text/javascript">
//<![CDATA[
function doOnLoad() {
    document.forms[0].submit();
}
window.onload=doOnLoad;
//]]>
</script>
</head>
<body>
@php
if(!isset($target)){
    $target = '';
}
@endphp
<form action="{{$url}}" method="POST" target="{{$target}}" encType="application/x-www-form-urlencoded">
    @foreach ($params as $key => $value)
        @php
            $key = htmlentities($key, ENT_COMPAT | ENT_HTML401, 'UTF-8');
        @endphp
        @if (!is_array($value))
            @php
                $value = htmlentities($value, ENT_COMPAT | ENT_HTML401, 'UTF-8');
            @endphp
            <input type="hidden" name="{{$key}}" value="{{$value}}" />
        @else
            @php
                // $value = htmlentities($value, ENT_COMPAT | ENT_HTML401, 'UTF-8');
                // $value = http_build_query($value);
                // $value = json_encode($value);
            @endphp
            <input type="hidden" name="{{$key}}" value="{{$value}}" />
        @endif
    @endforeach
</form>
</body>
</html>
