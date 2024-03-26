<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LenderRegisterPageBuilder extends Model
{
    protected $table = 'lender_register_page_builder';

    static $banner = '<h1 class="m-0 text-white orange-bg">LENDER SIGN UP</h1>
    <h2 class="mt-1 h1 mb-2 pb-1">Match with Home Buyers <br />&amp; Sellers on Render</h2>
    <p class="text-primary mb-0 pl-5">Gain access to our network of realtors ready to bring you their next deal. Join our platform today to connect with motivated home buyers and sellers, and collaborate with real estate professionals to grow your business.</p>';

    static $section1Header = '<h2 class="text-left text-white h2  pb-1 mt-0">A Targeted Deal Funnel</h2>';

    static $section1 = '["<h4 class=\"text-orange m-0\">Quality Referrals:<\/h4>\r\n<p class=\"text-white\">Get deals without the hassle of cold-calling and expensive marketing. Connect with Realtors who have ready-to-buy clients. And connecting to Vendors can expand your reach even further.<\/p>","<h4 class=\"text-orange m-0\">Showcase Your Expertise &amp; Services:<\/h4>\r\n<p class=\"text-white\">Realtors are actively looking for unique products that fit their client&rsquo;s needs. Render gives you the opportunity to show how your experience and lending products solve their problems.<\/p>","<h4 class=\"text-orange m-0\">Build Strategic Partnerships:<\/h4>\r\n<p class=\"text-white\">Becoming a preferred pro for realtors and vendors helps build your repeat business. Now, you can focus on lending rather than prospecting.<\/p>"]';

    static $section2 = '<h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br />1,000s Of Real Estate Pros, <br />Nationwide!</h2>
    <p class="text-primary">Render was created by The Carolinas leading, mortgage and real estate broker Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up creating the largest network of realtors and lenders in the country. Now, they&rsquo;re bringing this powerful network to you.</p>
    <p class="text-primary">No more cold-calling.</p>
    <p class="text-primary">No more hours of searching for the pros.</p>
    <p class="text-primary">No more incompetent real estate pros.</p>
    <p class="text-primary">And you get access to talent nationwide. Sign up now and see what the Render network can do for you.</p>';
}
