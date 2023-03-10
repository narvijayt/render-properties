@component('mail::message')
Hello {{ ucfirst($user->first_name) }}, 

Welcome to Render and congratulations on becoming a premier member of one of the most valuable sites for loan officers like yourself, top real estate agents and home buyers throughout the United States and beyond. Now that you’re part of the family, here are a few things you can do next to help maximize your membership:
 
1. 	   Review and complete your member profile. Make sure you have a great profile photo, all your email and personal web site links are accurate, and you have a compelling description about your experience, achievements and more.
2.     Search for and connect with top real estate agents in your market. By reaching out to, and connecting with agents, Render builds additional marketing programs to enhance their profile and drive traffic to their site.
3. 	   Refer Render to your real estate agent connections. Adding them to the site and matching with them increase the marketing and grow your mortgage and real estate network. As always, Render is free to all real estate agents.
4.     Find out what else Render can do for you. We have other plans and programs available to our members to help further increase your business and pipeline. Give us a call or drop us an email to find out more, we’re adding site enhancements all the time!
 
Once again, congratulations and welcome! If there’s anything we can do for you, don’t hesitate to contact us. Call (704) 935-3588 or email member@render.properties today!

Thanks,<br>
{{ config('app.name') }}
@endcomponent