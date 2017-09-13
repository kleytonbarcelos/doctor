$.base64.utf8encode = true;
function base64_encode(str)
{
    return  $.base64.encode(str);
}
function base64_decode(str)
{
    return  $.base64.decode(str);
}