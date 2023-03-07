@component('mail::message', [
    'user' => $review->subject,
    'email_type' => config('mail.email_types.review_messages')
])
#You have received a review from {{$user->first_name}}!
@component('mail::panel')
#Their review had a rating of : {{$review->rating}}
#Here is what they said about you:
{{$review->message}}
@endcomponent
<a style=" font-family: Avenir, Helvetica, sans-serif;
                box-sizing: border-box;
                border-radius: 3px;
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                color: #FFF;
                display: inline-block;
                text-decoration: none;
                -webkit-text-size-adjust: none;
                background-color: #2ab27b;
                border-top: 10px solid #2ab27b;
                border-right: 18px solid #2ab27b;
                border-bottom: 10px solid #2ab27b;
                border-left: 18px solid #2ab27b;
                float: left;
            " href= "{{config('app.url').'/review/'.$review->review_id.'/accept/'}}" >Accept</a>
<a style=" font-family: Avenir, Helvetica, sans-serif;
                box-sizing: border-box;
                border-radius: 3px;
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                color: #FFF;
                display: inline-block;
                text-decoration: none;
                -webkit-text-size-adjust: none;
                background-color: #9b9b9b;
                border-top: 10px solid #9b9b9b;
                border-right: 18px solid #9b9b9b;
                border-bottom: 10px solid #9b9b9b;
                border-left: 18px solid #9b9b9b;
                float:right;
            " href="{{config('app.url').'/review/'.$review->review_id.'/reject/'}}">Reject</a>
@endcomponent