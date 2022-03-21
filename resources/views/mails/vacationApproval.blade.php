@if ($approved)
    @component('mail::message')
    Hello ,  
    Your vacation request has just been approved. Enjoy your vacation!
@else
    Hello ,  
    Unfortunately, your vacation request has just been denied. Feel free to file a complaint!
@endif