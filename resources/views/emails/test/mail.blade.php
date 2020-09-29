
<div>

@component('mail::message', ["app_name" => $app_name])

<div style="text-align: center!important; background: #057AFC;padding: 30px 10px;">
    <h3 style="font-size: 30px;color: #fff;">{{$subject}}</h3>
</div>

<div class="xxx" style="font-size: 20px; color: #057AFC; border: 3px solid #057AFC;padding: 20px 20px 100px;">{!! $body !!}</div>


@endcomponent


</div>
