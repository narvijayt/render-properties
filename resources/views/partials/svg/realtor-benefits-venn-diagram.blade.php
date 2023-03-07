@if(isset($regPage) && !empty($regPage))
    @if($regPage->footer != '')
        <div class="venn-img">
            @php echo $regPage->footer; @endphp
        </div>
    @endif
@endif