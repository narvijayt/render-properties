<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRegisterPageBuilder extends Model
{
    protected $table = 'vendor_register_page_builder';

    static $banner = '<h1 class="m-0 text-orange">VENDOR SIGN UP</h1>
    <h2 class="mt-1 h1 mb-1 text-white">Your Expertise, <br />Their Needs &ndash; <br />Perfect Match</h2>
    <p class="text-primary mb-0 pl-5 text-white"><strong>Gain unrivaled access to a growing marketplace of realtors, lenders, and real estate pros looking for your services.</strong></p>';

    static $section1Header = '<h2 class="text-left text-white h2  pb-1 mt-0">How Render Gets You <br />More Jobs</h2>';

    static $section1 = '["<h4 class=\"text-orange m-0\">Generate New Leads:<\/h4>\r\n<p class=\"text-white\">Render can give you a steady stream of potential business without the need for expensive marketing. Our platform is a one-stop shop for realtors and other real estate pros who can constantly recommend your services.<\/p>","<h4 class=\"text-orange m-0\">Showcase Your Expertise &amp; Services:<\/h4>\r\n<p class=\"text-white\">Realtors and lenders are actively looking for unique services that will help them close deals. Render gives you the opportunity to show how your experience and services solve their problems.<\/p>","<h4 class=\"text-orange m-0\">Create Strategic Partnerships:<\/h4>\r\n<p class=\"text-white\">At Render you&rsquo;ll find a targeted audience of real estate professionals looking for your skills to help them close deals. Connecting with them is easy and puts you at the forefront of the real estate landscape.<\/p>"]';

    static $section2 = '<h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br />1,000s Of Real Estate Pros, <br />Nationwide!</h2>
    <p class="text-primary">Render was created by The Carolinas leading, mortgage and real estate broker Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up creating the largest network of realtors and lenders in the country. Now, they&rsquo;re bringing this powerful network to you.</p>
    <p class="text-primary">No more cold-calling.</p>
    <p class="text-primary">No more hours of searching for the pros.</p>
    <p class="text-primary">No more incompetent real estate pros.</p>
    <p class="text-primary">And you get access to talent nationwide. Sign up now and see what the Render network can do for you.</p>';
}
