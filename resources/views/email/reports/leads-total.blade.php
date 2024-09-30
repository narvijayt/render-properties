@component('mail::message')
# Leads Received
<b>Buy Property:</b> {{ $buy_property_count }}<br>
<b>Sell Property:</b> {{ $sell_property_count }}<br>
<b>Refinance:</b> {{ $refinance_count }}<br>
<b>Total:</b> {{ $all_type_leads_count }}

The report is attached.

@endcomponent