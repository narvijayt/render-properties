@php
    /** @var $user \App\User */
@endphp
@component('mail::message')
<div style="width: 100%; background: #f5f8fa; padding: 20px;">
@if($user->user_type == "broker")
    <h1 style="font-size: 18px; color: #184586;">
        A new Lender has registered on {!! get_application_name() !!}. Below are the contact details:
    </h1>
@else
    <h1 style="font-size: 18px; color: #184586;">
        A new Real Estate Agent has registered on {!! get_application_name() !!}. Below are the contact details:
    </h1>
@endif
    <div style="width: 100%; background: #fff; padding: 5px 5px; boder: 1px solid #ddd;">
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tr>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>Name</b></p>
                </td>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;">{{ $user->full_name() }}</p>
                </td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>Email</b></p>
                </td>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;">{{ $user->email }}</p>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>Phone</b></p>
                </td>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;"><a href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a></p>
                </td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>City</b></p>
                </td>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;">{{ $user->city }}</p>
                </td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>State</b></p>
                </td>
                <td style="border-bottom: 1px solid #eee; padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;">{{ $user->state }}</p>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 10px;">
                    <p style="font-size: 15px; color: #184586; margin-bottom: 0px;"><b>Zip Code</b></p>
                </td>
                <td style="padding: 8px 10px;">
                    <p style="font-size: 15px; margin-bottom: 0px;">{{ $user->zip }}</p>
                </td>
            </tr>
        </table>
    </div>

</div>

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent