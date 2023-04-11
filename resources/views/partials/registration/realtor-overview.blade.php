@if(isset($realtorRegPage) && !empty($realtorRegPage))
    @if($realtorRegPage->header != '')
        @php echo html_entity_decode($realtorRegPage->header); @endphp
    @endif
@endif
