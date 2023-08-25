<div class="box-title-box text-center">
  <h1 class="box-title line-center family-mont">Vendor Advertising Packages</h1>
  <p> Reach Top Performing Lender And Real Estate Agents Online</p>
</div>


<div class="package-header">
  <div class="">
    @if(!is_null($vendorPackages))
      @foreach($vendorPackages as $package)
        <div class="text-center">
          <div class="pricing-table  text-center starter">
            <div class="head"><h3 class="period text-uppercase">{{ $package->packageType == "usa" ? "United States" : "Pick a ".$package->packageType }}</h3></div>

            <div class="middle">
              <h1 class="price"><span>$</span>{{ (get_decimal_value($package->basePrice) > 0) ? $package->basePrice : floor($package->basePrice)  }} <u>MO</u></h1>
              <p class="small-price">{{ $package->packageType == "usa" ? "For One Month" : "For One City" }}</p>
              @if(!is_null($package->addOnPrice))
                <h1 class="price"><span>$</span>{{ (get_decimal_value($package->addOnPrice) > 0) ? $package->addOnPrice : floor($package->addOnPrice)  }} <u>MO</u></h1>
                <p class="small-price">EACH ADDITIONAL*</p>
              @endif
              @if($package->packageType == "usa")
                <h2 class="text-white highlighted-text">OWN THE U.S. IN YOUR INDUSTRY!!!</h2>              
              @endif
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>