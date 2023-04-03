@extends('layouts.app')
@section('title') Terms & Conditions @endsection
@section('meta')
@if(!empty($termMeta) && !is_null($termMeta))
@if(!is_null($termMeta->description))
{{ meta('description',html_entity_decode(strip_tags($termMeta->description))) }}
@else
{{ meta('description','Render Terms & Conditions') }}
@endif
@if(!is_null($termMeta->keyword))
{{ meta('keywords',html_entity_decode(strip_tags($termMeta->keyword))) }}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description','Render Terms & Conditions') }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
     @php
        $description = 'Render Terms & Conditions'
    @endphp
    {{ openGraph('og:title', 'Terms & Conditions') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Terms & Conditions') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Terms & Conditions') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')

    @component('pub.components.banner', ['banner_class' => 'terms-and-conditions'])
        @if(isset($termsPage) && !empty($termsPage))
            @if($termsPage->header != '')
            <h1 class="banner-title"><?php echo html_entity_decode($termsPage->header);?></h1>
            @else
                <h1 class="banner-title">Terms &amp; Conditions</h1>
            @endif
        @endif
    @endcomponent

    @if(isset($termsPage) && !empty($termsPage))
        @if($termsPage->content != '')
            @php echo html_entity_decode($termsPage->content); @endphp
        @else
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4>1. Terms</h4>

                        <p>By accessing this web site, you are agreeing to be bound by these web site Terms and Conditions of Use, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this web site are protected by applicable copyright and trade mark law.
                        </p>

                        <h4>2. Use License</h4>

                        <p>Permission is granted to temporarily download one copy of the materials (information or software) on {!! get_application_name() !!}'s web site for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                        </p>
                        <ul>
                            <li>modify or copy the materials;</li>
                            <li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
                            <li>attempt to decompile or reverse engineer any software contained on {!! get_application_name() !!}'s web site;</li>
                            <li>remove any copyright or other proprietary notations from the materials; or</li>
                            <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                        </ul>

                        <p>This license shall automatically terminate if you violate any of these restrictions and may be terminated by {!! get_application_name() !!} at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.
                        </p>

                        <h4>3. Disclaimer</h4>

                        <p>The materials on {!! get_application_name() !!}'s web site are provided "as is". {!! get_application_name() !!} makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, {!! get_application_name() !!} does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.
                        </p>

                        <h4>4. Limitations</h4>

                        <p>In no event shall {!! get_application_name() !!} or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on {!! get_application_name() !!}'s Internet site, even if {!! get_application_name() !!} or a {!! get_application_name() !!} authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.
                        </p>

                        <h4>5. Revisions and Errata</h4>

                        <p>The materials appearing on {!! get_application_name() !!}'s web site could include technical, typographical, or photographic errors. {!! get_application_name() !!} does not warrant that any of the materials on its web site are accurate, complete, or current. {!! get_application_name() !!} may make changes to the materials contained on its web site at any time without notice. {!! get_application_name() !!} does not, however, make any commitment to update the materials.
                        </p>

                        <h4>6. Links</h4>

                        <p>{!! get_application_name() !!} has not reviewed all of the sites linked to its Internet web site and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by {!! get_application_name() !!} of the site. Use of any such linked web site is at the user's own risk.
                        </p>

                        <h4>7. Site Terms of Use Modifications</h4>

                        <p>{!! get_application_name() !!} may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use.
                        </p>

                        <h4>8. Governing Law</h4>

                        <p>Any claim relating to {!! get_application_name() !!}'s web site shall be governed by the laws of the State of North Carolina without regard to its conflict of law provisions.
                        </p>

                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection