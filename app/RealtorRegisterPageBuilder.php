<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealtorRegisterPageBuilder extends Model
{
    protected $table = 'realtor_register_page_builder';

    static $banner = '<h1 class="m-0 bg-bule text-white">REALTOR SIGN UP</h1>
    <h2 class="mt-1 h1 mb-0">Close Fast &amp; <br />Scale Your Business</h2>
    <p class="text-primary mb-0">Join our network for free and get connected <br />to home buyers and sellers looking for your <br />expertise. With Render, closing deals is <br />easier than ever, thanks to our <br />network of lenders and vendors. <br />Elevate your real estate game today.</p>';

    static $section1Header = '<h2 class="text-left text-white h2  pb-1 mt-0">A Streamlined Social Network, <br />Just For Real Estate Pros</h2>
    <p class="text-left text-white">With Render, you&rsquo;ll get access to pre-approved lenders and <br />real estate vendors in your area.</p>';

    static $section1 = '["<h4 class=\"text-orange m-0\">Connect and Match with Home Buyers on Render:<\/h4>\r\n<p class=\"text-white\">Render allows Realtors to connect and match with home buyers. Our platform provides a seamless experience for Realtors to find and connect with motivated home buyers. Join Render today to start building meaningful connections and closing deals with ease.<\/p>","<h4 class=\"text-orange m-0\">Diverse Lenders with Tailored Products:<\/h4>\r\n<p class=\"text-white\">Get access to a host of different lenders with a variety of offerings. From traditional lending, to Non-QM, to down payment programs; get hand-tailored lending products that fit your client&rsquo;s unique needs.<\/p>","<h4 class=\"text-orange m-0\">Render Offers a Variety of Vendors to Choose From:<\/h4>\r\n<p class=\"text-white\">Render provides access to a range of vendors for your real estate needs. From home inspectors to appraisers and legal professionals, Render has vetted and verified vendors to ensure you\'re working with the best. Choose from our list of trusted vendors to streamline your real estate transactions and close deals faster.<\/p>"]';

    static $section2 = '<h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br />1,000s Of Real Estate Pros, <br />Nationwide!</h2>
    <p class="text-primary">Render was created by The Carolinas leading, mortgage and real estate broker Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up creating the largest network of realtors and lenders in the country. Now, they&rsquo;re bringing this powerful network to you.</p>
    <p class="text-primary">No more cold-calling.</p>
    <p class="text-primary">No more hours of searching for the pros.</p>
    <p class="text-primary">No more incompetent real estate pros.</p>
    <p class="text-primary">And you get access to talent nationwide. Sign up now and see what the Render network can do for you.</p>';
}
