<p>500 Not Found !</p>

@if(!empty($message['exist']))
    <p>Class : {{@ $message['Class']}}</p>
    <p>Message : {{@ $message['Message']}}</p>
    <p>GetTraceAsString : {{@ $message['GetTraceAsString']}}</p>
    <p>File : {{@ $message['File']}}</p>
    <p>Line : {{@ $message['Line']}}</p>
    <p>Code : {{@ $message['Code']}}</p>
@endif

@if(is_string($message))

    <p>Message : {{@ $message}}</p>

@endif