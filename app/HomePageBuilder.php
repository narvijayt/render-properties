<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomePageBuilder extends Model
{
    protected $table = 'home_page_builder';

    static $rules = [
        'banner' => 'required',
        'section1' => 'required',
        'section2.*' => 'required',
        'section3.*' => 'required',
        'section4' => 'required',
        'section5' => 'required',
    ];
    
    static $messages = [
        'banner.required' => 'Banner field is required.',
        'section1.required' => 'Section 1 field is required.',
        'section2.*.required' => 'Section 2 sub sections are required.',
        'section3.*.required' => 'Section 3 sub sections are required.',
        'section4.required' => 'Section 4 field is required.',
        'section5.required' => 'Section 5 field is required.',
    ];

    static $banner = '<h1 class="m-0">Welcome to Render The Real Estate Connection</h1>
    <div class="home-banner-heading">
    <h2>We Connect Home <br />Buyers &amp; Sellers With <br />Top-tier Real Estate Agents, <br />Loan Officers &amp; Vendors.</h2>
    </div>
    <p class="pr-4">Our platform empowers users to browse <br />and match with the best in the industry, <br />ensuring a seamless and successful <br />real estate experience.</p>';

    static $section1 = '<h2 class="text-center h1  mb-1 mt-0">Join Render Today!</h2>
    <p class="text-center text-primary">Whether you\'re buying your dream home or selling a property, Render&trade; is here to help you every step of the way. Our curated network of Real Estate Pros is comprised of experienced and reputable individuals who are dedicated to providing exceptional service and guidance throughout your transaction.</p>
    <p class="text-center text-primary">With Render, you can browse profiles, read reviews, and connect with professionals who align with your needs and preferences. Our platform streamlines the process of finding the right realtor, loan officer, or vendor, saving you time and effort.</p>
    <p class="text-center text-primary">Join Render today and experience the difference. Let us connect you with the best in real estate, so you can focus on finding your perfect home or closing the deal on your property.</p>';

    static $section2 = '{"subsection1":"<h2 class=\"text-center text-white h1  mb-1 mt-0 text-center\">Get Seen By Home Buyers &amp; Sellers<\/h2>\r\n<p class=\"text-box-center text-center text-white\">Render is a social network exclusively for real estate professionals that want to connect with other real estate pros. We&rsquo;re all working towards the same goals&hellip; get more deals, close more deals.<\/p>","subsection2":"<h3 class=\"text-orange\">Get Seen by people <br \/>that want to connect:<\/h3>\r\n<p class=\"text-white\">Render was designed to connect and match real estate pros that are open to new relationships. With Render, you can spread your name, build your reputation, scale your business, and do it all with professionals that are open and looking for your service. No more cold calling and talking to the wrong people.<\/p>","subsection3":"<h3 class=\"text-orange\">More Leads &amp; Referrals:<\/h3>\r\n<p class=\"text-white\">Everyone knows that the more you refer, the more referrals you&rsquo;ll get. That&rsquo;s what the Render Network is all about. Getting qualified leads is as easy as making a connection. Together, we all grow faster.<\/p>","subsection4":"<h3 class=\"text-orange\">Speed to Sale:<\/h3>\r\n<p class=\"text-white\">It takes a whole crew to move a property. Realtors, Lenders, Inspectors, Contractors, Title Agents, Lawyers, Photographers, and maybe even a handful of dudes with a truck. And connecting with everyone you need to make that sale has never been easier with Render.<\/p>"}';

    static $section3 = '{"subsection1":"<h2 class=\"text-left text-white h1  mb-1 mt-0\">How It Works For&hellip;<\/h2>\r\n<div class=\"mobile-image\"><img src=\"img\/realtors-img-new.png\" \/><\/div>\r\n<h4 class=\"text-left text-white m-0\">Realtors:<\/h4>\r\n<p class=\"text-left text-white\">Whether you&rsquo;re a seasoned real estate agent or just starting, Render Properties provides you with a platform to connect with the right lenders and vendors for your clients. Easily find mortgage experts, photographers, home stagers, and more to enhance your services and provide a comprehensive experience to your clients.<\/p>\r\n<a class=\"sign-link text-orange\" href=\"..\/..\/realtor-register\">Free Sign Up For Realtors<\/a>","subsection2":"<h4 class=\"text-left text-white m-0\">Lenders:<\/h4>\r\n<p class=\"text-left text-white\">For lenders, Render Properties offers a direct line to real estate professionals seeking financing solutions. Connect with realtors who are open to establishing new relationships and have clients in need of mortgage services, ensuring a seamless and efficient lending process. No more Cold Calling or meet and greets.<\/p>\r\n<a class=\" sign-link text-orange\" href=\"..\/..\/lender-register\">Sign Me Up<\/a>","subsection3":"<h4 class=\"text-left text-white m-0\">Vendors:<\/h4>\r\n<p class=\"text-left text-white\">If you&rsquo;re a vendor specializing in real estate services such as photography, staging, or property inspection, Render Properties is your gateway to a wider network of potential clients. Realtors on our platform are actively seeking new partnerships, allowing you to showcase your skills and offerings to those who need them.<\/p>\r\n<a class=\"sign-link text-orange\" href=\"vendor-register\">Sign Me Up<\/a>"}';

    static $section4 = '<h2 class="text-center h1  mb-1 mt-0">All Profits Are Yours! <br />We Never Take A Cut.</h2>
    <p class="text-primary">Unlike other online marketplaces, we never take a dime of <br />your proceeds. You only pay for your monthly subscription, <br />so you can do all the deals you want risk-free.</p>';

    static $section5 = '<h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br />1,000s Of Real Estate Pros, <br />Nationwide!</h2>
        <p class="text-primary">Render was created by The Carolinas leading, mortgage and real estate broker Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up creating the largest network of realtors and lenders in the country. Now, they&rsquo;re bringing this powerful network to you.</p>
        <p class="text-primary">No more cold-calling.</p>
        <p class="text-primary">No more hours of searching for the pros.</p>
        <p class="text-primary">No more incompetent real estate pros.</p>
        <p class="text-primary">And you get access to talent nationwide. Sign up now and see what the Render network can do for you.</p>';
}