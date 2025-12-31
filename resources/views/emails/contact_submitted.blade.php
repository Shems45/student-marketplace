<p><strong>Name:</strong> {{ $msg->name }}</p>
<p><strong>Email:</strong> {{ $msg->email }}</p>
<p><strong>Subject:</strong> {{ $msg->subject }}</p>
<p><strong>Message:</strong></p>
<p>{!! nl2br(e($msg->message)) !!}</p>
