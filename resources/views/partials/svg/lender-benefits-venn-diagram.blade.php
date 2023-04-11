@if(isset($lenderRegPage) && !empty($lenderRegPage))
    @if($lenderRegPage->footer != '')
        <div class="venn-img">
            @php echo $lenderRegPage->footer; @endphp
        </div>
    @endif
@endif