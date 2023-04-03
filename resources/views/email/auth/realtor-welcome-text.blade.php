@component('mail::message')
Hello {{ ucfirst($user->first_name) }}, 

Welcome to {!! get_application_name() !!} and congratulations on becoming a premier member of one of the most valuable sites for real estate agents like yourself, top loan officers and home buyers throughout the United States and beyond. Now that you’re part of the family, here are a few things you can do next to help maximize your membership:
 
1.     Review and complete your member profile. Make sure you have a great profile photo, all your email and personal web site links are accurate, and you have a compelling description about your experience, achievements and more.
2.     Search for and connect with top loan officers in your market. By reaching out to, and connecting with loan officers, {!! get_application_name() !!} builds additional marketing programs to enhance your profile and drive traffic to your site.
3.     Refer {!! get_application_name() !!} to your loan officer connections. Adding them to the site and matching with them increases the marketing to your page and profile.
4.     Find out what else {!! get_application_name() !!} can do for you. We have other plans and programs available to our members to help further increase your business and exposure. Give us a call or drop us an email to find out more, we’re adding site enhancements all the time!
 
Once again, congratulations and welcome! If there’s anything we can do for you, don’t hesitate to contact us. Call <a href="tel:7045695072">704-569-5072</a> or email member@render.properties today!

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent