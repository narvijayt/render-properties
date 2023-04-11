@if(isset($realtorRegPage) && !empty($realtorRegPage))
    @if($realtorRegPage->footer != '')
        <div class="venn-img">
            @php echo $realtorRegPage->footer; @endphp
        </div>
    @endif
@endif