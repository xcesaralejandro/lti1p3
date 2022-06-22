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
        <input type="hidden" name="{{$key}}" value="{{$value}}" />
    @endforeach
</form>
</body>
</html>
